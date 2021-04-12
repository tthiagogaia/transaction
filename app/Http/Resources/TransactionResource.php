<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'payer_id'           => $this->payer_id,
            'operation_id'       => $this->operation_id,
            'authorization_code' => $this->authorization_code,
            'payee_id'           => $this->payee_id,
            'refunded_at'        => $this->refunded_at,
            'created_at'         => $this->created_at,
            'updated_at'         => $this->updated_at,
        ];
    }
}
