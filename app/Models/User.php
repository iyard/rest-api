<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer $id
 * @property string $name
 * @property string $last_name
 * @property datetime $created_at
 * @property datetime $updated_at
 * @property Phone[] $phones
 * @property Email[] $emails
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the phones for the user.
     * @return HasMany
     */
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    /**
     * Get the emails for the user.
     * @return HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * Scope a query filter users by name and last name
     *
     * @param Builder $query
     * @param string $name
     * @param string $lastName
     * @return Builder
     */
    public function scopeFilterByNameAndLastName(Builder $query, $name = null, $lastName = null)
    {
        if (is_null($name) || is_null($name)) {
            return $query;
        }
        return $query->where('name', 'like', '%' . $name . '%')
            ->where('last_name', 'like', '%' . $lastName . '%');
    }

    /**
     * Scope a query filter users by phone
     *
     * @param Builder $query
     * @param string $phoneNumber
     * @return Builder
     */
    public function scopeFilterByPhoneNumber(Builder $query, $phoneNumber = null)
    {
        if (is_null($phoneNumber)) {
            return $query;
        }

        return $query->whereHas('phones', function (Builder $query) use ($phoneNumber) {
            $query->where('phone_number', $phoneNumber);
        });
    }

    /**
     * Scope a query filter users by email
     *
     * @param Builder $query
     * @param string $email
     * @return Builder
     */
    public function scopeFilterByEmail(Builder $query, $email = null)
    {
        if (is_null($email)) {
            return $query;
        }
        return $query->whereHas('emails', function (Builder $query) use ($email) {
            $query->where('email', $email);
        });
    }
}
