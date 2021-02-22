<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

return [

    /**
     * Default upload storage disk.
     */
    'upload_disk' => env('UPLOAD_DISK', 'public'),

    /**
     * Default Image upload directory on the disc
     * eg. 'uploads' or 'user/avatar'.
     */
    'upload_directory' => 'uploads',

    /**
     * Auto upload images from incoming Request if same named field or
     * file_input field on option present upon model update and create.
     * can be override in individual field options.
     */
    'auto_upload_images' => true,

    /**
     * It will auto delete images once record is deleted from database.
     */
    'auto_delete_images' => true,

    /**
     * Set an image quality.
     */
    'resize_image_quality' => 80,
];
