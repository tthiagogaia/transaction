<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Operation;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use App\Validations\Transaction\Exceptions\InvalidRefundTransactionException;
use App\Validations\Transaction\Exceptions\RefundedTransactionException;
use Database\Seeders\RoleSeeder;
use Illuminate\Http\Response;

class RefundTransactionTest extends FeatureTest
{
    private $consumer;

    private $company;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);

        $this->consumer = User::factory()->consumer()->create();
        $this->consumer->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);

        $this->company = Company::factory()->create();
        $this->company->wallet()->create(['amount' => Wallet::DEFAULT_VALUE]);
    }

    public function test_it_should_be_able_to_make_refund_transaction()
    {
        $transaction = Transaction::factory()->create([
            'payer_id'    => $this->consumer->id,
            'payee_id'    => $this->company->id,
            'refunded_at' => null,
        ]);

        $this->postJson(route('transaction.refund'), [
            'transaction_id' => $transaction->id,
        ])
            ->assertSuccessful();
    }

    public function test_it_should_deny_refund_already_refunded_transaction()
    {
        $transaction = Transaction::factory()->create([
            'payer_id'    => $this->consumer->id,
            'payee_id'    => $this->company->id,
            'refunded_at' => now(),
        ]);

        $this->postJson(route('transaction.refund'), [
            'transaction_id' => $transaction->id,
        ])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['error' => (new RefundedTransactionException())->getMessage()]);
    }

    public function test_it_should_deny_refund_non_credit_transaction()
    {
        $transaction = Transaction::factory()->create([
            'operation_id' => Operation::factory()->create(['type' => Operation::REFUND]),
            'payer_id'     => $this->consumer->id,
            'payee_id'     => $this->company->id,
            'refunded_at'  => now(),
        ]);

        $this->postJson(route('transaction.refund'), [
            'transaction_id' => $transaction->id,
        ])
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson(['error' => (new InvalidRefundTransactionException())->getMessage()]);
    }
}
