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
 * Model that represents a badge.
 *
 * @property int    $id                    Object unique id.
 * @property string $name                  Name of this badge.
 * @property string $description           Description of the badge.
 * @property int    $required_repetitions  How many times you need to request the badge to achieve it.
 * @property string $image                  URL of the badge's image
 * @property bool   $active                 Is this badge enabled?
 * @property string $imagesUploadDisk
 * @property string $imagesUploadPath
 * @property string $autoUploadImages
 */
class Badge extends Model
{
    use SoftDeletes;
    use HasImageUploads;

    /**
     * Default badge image to be used in case no one is supplied.
     */
    const DEFAULT_IMAGE = '/images/missing_badge.png';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'badges';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'required_repetitions',
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
        'description' => 'string',
        'required_repetitions' => 'int',
        'active' => 'boolean',
    ];

    // which disk to use for upload, can be override by field options
    //protected $imagesUploadDisk;

    // path in disk to use for upload, can be override by field options
    protected $imagesUploadPath = 'badges';

    // auto upload allowed
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
}
