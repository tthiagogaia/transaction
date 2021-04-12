<?php

namespace Tests\Feature;

use App\Facades\TransactionAuthorization;
use App\Jobs\Transaction\CreditNotification;
use App\Models\User;
use App\Validations\Transaction\Exceptions\InvalidPayerException;
use App\Validations\Transaction\Exceptions\PayeeNotFoundException;
use App\Validations\Transaction\Exceptions\SamePayerException;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Str;

class CreditTransactionTest extends FeatureTest
{
    private $consumer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->consumer = User::factory()->consumer()->create();
    }

    public function test_only_authenticated_users_can_make_a_transaction()
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

    public function test_it_should_be_able_to_make_credit_transaction()
    {
        $payee = User::factory()->consumer()->create();

        $this->actingAs($this->consumer);

        TransactionAuthorization::shouldReceive('authorize')
            ->once()
            ->andReturn(['message' => 'Autorizado', 'authorization_code' => (string)Str::uuid()]);

        Bus::fake();

        $this->postJson(route('transaction.credit', [
            'payee_id' => $payee->id,
            'amount'   => 100,
        ]))
            ->assertSuccessful();

        Bus::assertDispatched(CreditNotification::class);
    }

    public function test_it_should_validate_required_fields_to_transaction()
    {
        $this->actingAs($this->consumer);

        $this->postJson(route('transaction.credit', []))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'payee_id' => __('validation.required', ['attribute' => 'payee id']),
                'amount'   => __('validation.required', ['attribute' => 'amount']),
            ]);
    }

    public function test_it_should_validate_transaction_amount()
    {
        $payee = User::factory()->consumer()->create();

        $this->actingAs($this->consumer);

        $this->postJson(route('transaction.credit', [
            'payee_id' => $payee->id,
            'amount'   => 'invalid',
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'amount' => __('validation.numeric', ['attribute' => 'amount']),
            ]);

        $this->postJson(route('transaction.credit', [
            'payee_id' => $payee->id,
            'amount'   => -1,
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'amount' => __('validation.gt.numeric', ['attribute' => 'amount', 'value' => 0]),
            ]);

        $this->postJson(route('transaction.credit', [
            'payee_id' => $payee->id,
            'amount'   => 0,
        ]))
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'amount' => __('validation.gt.numeric', ['attribute' => 'amount', 'value' => 0]),
            ]);
    }

    public function test_it_should_validate_the_payer_cannot_be_a_shopkeeper()
    {
        $payee           = User::factory()->consumer()->create();
        $shopKeeperPayer = User::factory()->shopkeeper()->create();

        $this->actingAs($shopKeeperPayer);

        $this->postJson(route('transaction.credit', [
            'payee_id' => $payee->id,
            'amount'   => 100,
        ]))
            ->assertJson(['error' => (new InvalidPayerException())->getMessage()])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_validate_the_payer_and_the_payee_cannot_be_the_same_user()
    {
        $this->actingAs($this->consumer);

        $this->postJson(route('transaction.credit', [
            'payee_id' => $this->consumer->id,
            'amount'   => 100,
        ]))
            ->assertJson(['error' => (new SamePayerException())->getMessage()])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function test_it_should_validate_the_payee_is_a_valid_user()
    {
        $this->actingAs($this->consumer);

        $this->postJson(route('transaction.credit', [
            'payee_id' => 100,
            'amount'   => 100,
        ]))
            ->assertJson(['error' => (new PayeeNotFoundException())->getMessage()])
            ->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
