<?php

namespace Gamify\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_name',
        'provider_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'provider_name' => 'string',
        'provider_id' => 'int',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
