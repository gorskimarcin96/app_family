<?php

namespace App\Identity\Domain\Repository;

use App\Identity\Domain\Model\User;
use App\Identity\Domain\ValueObject\Email;

interface UserRepositoryInterface
{
    public function save(User $user): void;

    public function delete(User $user): void;

    public function findByEmail(Email $email): ?User;
}
