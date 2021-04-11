<?php

namespace App\Services\Transaction;

use App\Services\Transaction\Exceptions\TransactionUnauthorizedException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Authorization
{
    public function authorize(): array
    {
        $response = $this->getClient()
            ->get('/8fafdd68-a090-496f-8c9a-3442cf30dae6');

        $response = $response->json();

        if ($response['message'] !== 'Autorizado') {
            throw new TransactionUnauthorizedException();
        }

        $response['authorization_code'] = (string)Str::uuid();

        return $response;
    }

    private function getClient(): PendingRequest
    {
        return Http::withOptions([
            'base_uri' => config('services.transaction.authorization.base_url'),
        ])->withHeaders([
            'Accept' => 'application/json',
        ]);
    }
}
