<?php

namespace App\Factory;

use App\Repository\UserRepository;

class UserRepositoryFactory
{
    public function __invoke()
    {
        return new UserRepository();
    }
}