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

    /*
     * What attributes do we use to build the slug?
     * This can be a single field, like "name" which will build a slug from:
     *
     *     $model->name;
     *
     * Or it can be an array of fields, like ("name", "company"), which builds a slug from:
     *
     *     $model->name . ' ' . $model->company;
     *
     * If you've defined custom getters in your model, you can use those too,
     * since Eloquent will call them when you request a custom attribute.
     *
     * Defaults to null, which uses the toString() method on your model.
     */

    'source' => null,

    /*
     * The maximum length of a generated slug.  Defaults to "null", which means
     * no length restrictions are enforced.  Set it to a positive integer if you
     * want to make sure your slugs aren't too long.
     */

    'maxLength' => null,

    /*
     * If left to "null", then use the cocur/slugify package to generate the slug
     * (with the separator defined below).
     *
     * Set this to a closure that accepts two parameters (string and separator)
     * to define a custom slugger.  e.g.:
     *
     *    'method' => function( $string, $sep ) {
     *       return preg_replace('/[^a-z]+/i', $sep, $string);
     *    },
     *
     * Otherwise, this will be treated as a callable to be used.  e.g.:
     *
     *    'method' => array('Str','slug'),
     */

    'method' => null,

    /*
     * Separator to use when generating slugs.  Defaults to a hyphen.
     */

    'separator' => '-',

    /*
     * Enforce uniqueness of slugs?  Defaults to true.
     * If a generated slug already exists, an incremental numeric
     * value will be appended to the end until a unique slug is found.  e.g.:
     *
     *     my-slug
     *     my-slug-1
     *     my-slug-2
     */

    'unique' => true,

    /*
     * If you are enforcing unique slugs, the default is to add an
     * incremental value to the end of the base slug.  Alternatively, you
     * can change this value to a closure that accepts three parameters:
     * the base slug, the separator, and a Collection of the other
     * "similar" slugs.  The closure should return the new unique
     * suffix to append to the slug.
     */

    'uniqueSuffix' => null,

    /*
     * Should we include the trashed items when generating a unique slug?
     * This only applies if the softDelete property is set for the Eloquent model.
     * If set to "false", then a new slug could duplicate one that exists on a trashed model.
     * If set to "true", then uniqueness is enforced across trashed and existing models.
     */

    'includeTrashed' => true,

    /*
     * An array of slug names that can never be used for this model,
     * e.g. to prevent collisions with existing routes or controller methods, etc..
     * Defaults to null (i.e. no reserved names).
     * Can be a static array, e.g.:
     *
     *    'reserved' => array('add', 'delete'),
     *
     * or a closure that returns an array of reserved names.
     * If using a closure, it will accept one parameter: the model itself, and should
     * return an array of reserved names, or null. e.g.
     *
     *    'reserved' => function( Model $model) {
     *      return $model->some_method_that_returns_an_array();
     *    }
     *
     * In the case of a slug that gets generated with one of these reserved names,
     * we will do:
     *
     *    $slug .= $separator + "1"
     *
     * and continue from there.
     */

    'reserved' => null,

    /*
     * Whether to update the slug value when a model is being
     * re-saved (i.e. already exists).  Defaults to false, which
     * means slugs are not updated.
     *
     * Be careful! If you are using slugs to generate URLs, then
     * updating your slug automatically might change your URLs which
     * is probably not a good idea from an SEO point of view.
     * Only set this to true if you understand the possible consequences.
     */

    'onUpdate' => false,

];
