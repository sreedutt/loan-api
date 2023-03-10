<?php

namespace Domain\Customers\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string uuid
 * @property string email
 * @property string name
 */
class Customer extends Authenticatable
{
    use HasUuids;
    use HasFactory;
    use HasApiTokens;

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

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}
