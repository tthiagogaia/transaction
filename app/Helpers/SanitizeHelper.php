<?php

namespace App\Helpers;

class SanitizeHelper
{
    private ?string $word;

    public function __construct(?string $word)
    {
        $this->word = $word;
    }

    public function sanitize(): ?string
    {
        return $this->word;
    }

    public function cpfCnpj(): self
    {
        if ($this->word === null) {
            return $this;
        }

        $this->word = str_replace('-', '', $this->word);
        $this->word = str_replace('.', '', $this->word);
        $this->word = str_replace('/', '', $this->word);

        return $this;
    }
}
