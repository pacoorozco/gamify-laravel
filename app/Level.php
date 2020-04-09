<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This file is part of some open source application.
 *
 * Licensed under GNU General Public License 3.0.
 * Some rights reserved. See LICENSE, AUTHORS.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use QCod\ImageUp\HasImageUploads;

/**
 * Model that represents a level.
 *
 * @property int    $id                    Object unique id.
 * @property string $name                  Name of the level..
 * @property int    $required_points       How many points do you need to achieve it.
 * @property string image                  URL of the level's image
 * @property bool   active                 Is this level enabled?
 * @property string $imagesUploadDisk
 * @property string $imagesUploadPath
 * @property string $autoUploadImages
 */
class Level extends Model
{
    use SoftDeletes;
    use HasImageUploads;

    /**
     * Default badge image to be used in case no one is supplied.
     */
    const DEFAULT_IMAGE = '/images/missing_level.png';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'levels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'required_points',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'int',
        'name' => 'string',
        'required_points' => 'int',
        'active' => 'boolean',
    ];

    /**
     * Path in disk to use for upload, can be override by field options.
     *
     * @var string
     */
    protected $imagesUploadPath = 'levels';

    /**
     * Auto upload allowed.
     *
     * @var bool
     */
    protected $autoUploadImages = true;

    /**
     * Fields that are managed by the HasImageUploads trait.
     *
     * @var array
     */
    protected static $imageFields = [
        'image_url' => [
            // width to resize image after upload
            'width' => 150,

            // height to resize image after upload
            'height' => 150,

            // set true to crop image with the given width/height and you can also pass arr [x,y] coordinate for crop.
            'crop' => true,

            // placeholder image if image field is empty
            'placeholder' => self::DEFAULT_IMAGE,

            // validation rules when uploading image
            'rules' => 'image|max:2000',

            // if request file is don't have same name, default will be the field name
            'file_input' => 'image',
        ],
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get image attribute or default image.
     *
     * @return string
     */
    public function getImageAttribute(): string
    {
        try {
            return $this->imageUrl();
        } catch (\Exception $exception) {
            return asset(self::DEFAULT_IMAGE);
        }
    }

    /**
     * Returns a collection of active Level.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Returns Level (object) for the specified experience.
     *
     * @param int $experience
     *
     * @return \Gamify\Level
     */
    public static function findByExperience(int $experience)
    {
        return self::active()
            ->where('required_points', '<=', $experience)
            ->orderBy('required_points', 'desc')
            ->first();
    }

    /**
     * Return the upcoming Level (object) for the specified experience.
     *
     * Throws an exception in case that this is the highest possible level.
     *
     * @param int $experience
     *
     * @return \Gamify\Level
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findNextByExperience(int $experience)
    {
        return self::active()
            ->where('required_points', '>', $experience)
            ->orderBy('required_points', 'asc')
            ->firstOrFail();
    }

    /**
     * Returns if this is the default level.
     *
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->required_points === 0;
    }
}
