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

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $connection = config('taggable.connection');
        $taggableTagsTable = config('taggable.tables.taggable_tags', 'taggable_tags');
        $taggableTaggablesTable = config('taggable.tables.taggable_taggables', 'taggable_taggables');

        $charset = Schema::connection($connection)->getConnection()->getConfig('charset') ?? 'utf8mb4';
        $driver = Schema::connection($connection)->getConnection()->getConfig('driver');

        $collation = match ($driver) {
            'pgsql' => '',
            default => $charset.'_bin',
        };

        if (! Schema::connection($connection)->hasTable($taggableTagsTable)) {
            Schema::connection($connection)->create($taggableTagsTable,
                static function (Blueprint $table) use ($collation) {
                    $table->bigIncrements('tag_id');
                    $table->string('name');
                    $table->string('normalized')->unique()->collation($collation);
                    $table->timestamps();

                    $table->index('normalized');
                });
        }

        if (! Schema::connection($connection)->hasTable($taggableTaggablesTable)) {
            Schema::connection($connection)->create($taggableTaggablesTable, static function (Blueprint $table) {
                $table->unsignedBigInteger('tag_id');
                $table->unsignedBigInteger('taggable_id');
                $table->string('taggable_type');
                $table->timestamps();

                $table->unique(['tag_id', 'taggable_id', 'taggable_type']);

                $table->index(['tag_id', 'taggable_id'], 'i_taggable_fwd');
                $table->index(['taggable_id', 'tag_id'], 'i_taggable_rev');
                $table->index('taggable_type', 'i_taggable_type');
            });
        }
    }

    public function down(): void
    {
        $connection = config('taggable.connection');
        $taggableTagsTable = config('taggable.tables.taggable_tags', 'taggable_tags');
        $taggableTaggablesTable = config('taggable.tables.taggable_taggables', 'taggable_taggables');

        if (Schema::connection($connection)->hasTable($taggableTagsTable)) {
            Schema::connection($connection)->drop($taggableTagsTable);
        }

        if (Schema::connection($connection)->hasTable($taggableTaggablesTable)) {
            Schema::connection($connection)->drop($taggableTaggablesTable);
        }
    }
};
