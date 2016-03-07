<?php

namespace Gamify;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';

    protected $fillable = array(
        'points',
        'description'
    );

    public function user()
    {
        return $this->belongsTo('Gamify\User');
    }
}
