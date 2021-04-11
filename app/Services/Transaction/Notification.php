<?php

namespace App\Services\Transaction;

use App\Services\Transaction\Exceptions\CreditNotificationUndeliveredException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class Notification
{
    public function notify(): array
    {
        $response = $this->getClient()
            ->get('/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');

        $response = $response->json();

        if ($response['message'] !== 'Enviado') {
            throw new CreditNotificationUndeliveredException();
        }

        return $response;
    }

    private function getClient(): PendingRequest
    {
        return Http::withOptions([
            'base_uri' => config('services.transaction.notification.base_url'),
        ])->withHeaders([
            'Accept' => 'application/json',
        ]);
    }
}
