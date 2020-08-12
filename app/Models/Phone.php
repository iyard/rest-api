<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $phone_number
 * @property integer $user_id
 * @property datetime $created_at
 * @property datetime $updated_at
 */
class Phone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
    ];
}
