<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isNormalUser(): bool
    {
        return $this->role === 'user';
    }

    public function canEditUser(User $target): bool
    {
        if ($this->isAdministrator() || $this->isManager()) {
            return $target->isNormalUser();
        }

        return $this->id === $target->id;
    }
}
