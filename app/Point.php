<?php

namespace Gamify;

use Gamify\Events\PointCreated;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Point.
 *
 *
 * @property  int    $id           Object unique id..
 * @property  int    $points       How many points has been given.
 * @property  string $description  Reason to obtain the points.
 */
class Point extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'points';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points',
        'description',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'points' => 'int',
        'description' => 'string',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PointCreated::class,
    ];

    /**
     * A point belongs to one User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Gamify\User');
    }
}
