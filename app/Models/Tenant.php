<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'database_path',
        'email',
        'phone',
        'subscription_expires',
        'plan',
        'is_active'
    ];
}