<?php

namespace Domain\Customers\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;


/**
 * @property string uuid
 * @property string email
 * @property string name
 */

class Customer extends Authenticatable
{
    use HasUuids;

    
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

   
    protected $hidden = [
        'password',
    ];


    public function uniqueIds(): array
    {
        return ['uuid'];
    }
    
}
