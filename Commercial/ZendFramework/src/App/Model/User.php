<?php

declare(strict_types=1);

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $primaryKey = 'accountId';
    protected $fillable = [
        'accountId',
        'accessToken',
        'refreshToken',
        'expires',
        'baseDomain',
        'unisenderToken',
        "unisenderList"
    ];


    public function getId(): int
    {
        return $this->getAttributeFromArray("accountId");
    }

    public function setId($value): void
    {
        $this->setAttribute("accountId", $value);
    }

    public function getReferer(): string
    {
        return $this->getAttributeFromArray("baseDomain");
    }

    public function setReferer($value): void
    {
        $this->setAttribute("baseDomain", $value);
    }

    public function getAccessToken(): string
    {
        return $this->getAttributeFromArray("accessToken");
    }

    public function setAccessToken($value): void
    {
        $this->setAttribute("accessToken", $value);
    }

    public function getRefreshToken(): string
    {
        return $this->getAttributeFromArray("refreshToken");
    }

    public function setRefreshToken($value): void
    {
        $this->setAttribute("refreshToken", $value);
    }

    public function getExpires(): int
    {
        return $this->getAttributeFromArray("expires");
    }

    public function setExpires($value): void
    {
        $this->setAttribute("expires", $value);
    }

    public function getUnisenderToken(): string
    {
        return $this->getAttributeFromArray("unisenderToken");
    }

    public function setUnisenderToken($value): void
    {
        $this->setAttribute("unisenderToken", $value);
    }

    public function getUniList(): int
    {
        return $this->getAttributeFromArray("unisenderList");
    }

    public function setUniList($value): void
    {
        $this->setAttribute("unisenderList", $value);
    }

}