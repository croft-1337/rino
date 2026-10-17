<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $fillable = [
        'visitor_id',
        'session_id',
        'path',
        'route_name',
        'referrer_host',
        'ip_hash',
        'user_agent',
        'viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'viewed_at' =>
                'datetime',
        ];
    }
}