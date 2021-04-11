<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CompanyTest extends FeatureTest
{
    private $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->consumer = User::factory()->create([
            'role_id' => Role::query()->select('id')->where('label', Role::CONSUMER)->first()->id,
        ]);
    }

    public function test_only_authenticated_users_can_create_a_company()
    {
        $this->postJson(route('company.store'), [
            'name' => 'Company Inc',
            'cnpj' => '30668548000175',
        ])
            ->assertUnauthorized();

        $this->actingAs($this->consumer);

        $this->postJson(route('company.store'), [
            'name' => 'Company Inc',
            'cnpj' => '30668548000175',
        ])
            ->assertSuccessful();
    }

    public function test_validate_all_fields_to_create_new_company()
    {
        $this->actingAs($this->consumer);

        $this->postJson(route('company.store'), [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name' => __('validation.required', ['attribute' => 'name']),
                'cnpj' => __('validation.required', ['attribute' => 'cnpj']),
            ]);

        $this->postJson(route('company.store'), [
            'name' => 'Company name',
            'cnpj' => '00000000000000',
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'cnpj' => __('Invalid CNPJ'),
            ]);

        $company = Company::factory()->create();

        $this->postJson(route('company.store'), [
            'name' => Str::random(256),
            'cnpj' => $company->cnpj,
        ])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255]),
                'cnpj' => __('validation.unique', ['attribute' => 'cnpj']),
            ]);
    }

    public function test_when_the_user_has_a_company_his_role_is_changed_to_shopkeeper()
    {
        $this->actingAs($this->consumer);

        $this->postJson(route('company.store'), [
            'name' => 'Company Inc',
            'cnpj' => '30668548000175',
        ])
            ->assertSuccessful();

        $this->assertEquals(
            $this->consumer->role_id,
            Role::query()->select('id')->where('label', Role::SHOPKEEPER)->first()->id
        );
    }
}
