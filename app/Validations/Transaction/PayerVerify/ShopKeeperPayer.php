<?php

namespace App\Validations\Transaction\PayerVerify;

use App\Models\Role;
use App\Models\User;
use App\Validations\Transaction\Contracts\PayerVerifiable;
use App\Validations\Transaction\Excetions\InvalidPayerException;

class ShopKeeperPayer implements PayerVerifiable
{
    private $nextPayerVerifiable;

    public function setNext(PayerVerifiable $nextPayerVerifiable)
    {
        $this->nextPayerVerifiable = $nextPayerVerifiable;
    }

    public function getPayer(int $payerId, int $payeeId)
    {
        $user = User::query()
            ->where(
                'role_id',
                Role::query()->select('id')->where('label', Role::SHOPKEEPER)->first()->id
            )
            ->find($payerId);

        if ($user) {
            throw new InvalidPayerException(__('Shopkeepers users only receive transactions'));
        }

        return $this->nextPayerVerifiable->getPayer($payerId, $payeeId);
    }
}
