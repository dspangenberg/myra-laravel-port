<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'first_name',
        'avatar_url',
        'is_admin',
        'email',
        'password',
    ];

    protected $appends = [
        'full_name',
        'reverse_full_name',
        'initials',
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

    public function getFullNameAttribute(): string
    {
      return "$this->first_name $this->last_name";
    }

    public function getInitialsAttribute(): string
    {
      return substr($this->first_name, 0,1) . substr($this->last_name, 0,1);
    }

    public function getReverseFullNameAttribute(): string
    {
      return "$this->last_name, $this->first_name";
    }

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
            'is_admin' => 'boolean',
        ];
    }
}
