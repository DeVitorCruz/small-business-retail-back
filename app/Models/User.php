<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_OWNER = 1;
    const ROLE_EMPLOYEE = 2;
    const ROLE_SELLER = 3;
    const ROLE_CUSTOMER = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Validate the credential of the user and check if is the owner
     * 
     * @return boolean
     */
    public function isOwner()
    {
        return $this->role === 1;
    }

    /**
     * Validate the credential of the user and check if is an employee
     * 
     * @return boolean
     */
    public function isEmployee()
    {
        return $this->role === 2;
    }

    /**
     * Validate the credential of the user and check if is a seller
     * 
     * @return boolean
     */
    public function isSeller()
    {
        return $this->role === 3;
    }

    /**
     * Validate the credential of the user and check if is a costumer
     * 
     * @return boolean
     */
    public function isCustomer()
    {
        return $this->role === 4;
    }
}
