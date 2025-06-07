<?php

namespace App\Identity\Domain\Exception;

final class InvalidEmailException extends \InvalidArgumentException
{
    public function __construct(string $email)
    {
        parent::__construct(sprintf('Email "%s" is invalid.', $email));
    }
}
