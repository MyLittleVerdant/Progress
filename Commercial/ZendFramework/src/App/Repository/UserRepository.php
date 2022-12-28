<?php

namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    public function findOneByID(string $accId): ?User
    {
        return User::where('accountId', $accId)->first();
    }

    public function findOneByDomain(string $domain): ?User
    {
        return User::where('baseDomain', $domain)->first();
    }

    public function save(User $user): bool
    {
        return $user->save();
    }

    public function findByExpires(string $expires = null)
    {
        return User::where("expires", "<", time() + $expires * 60 * 60)->pluck('accountId')->all();
    }

}