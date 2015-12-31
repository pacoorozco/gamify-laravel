<?php

namespace Gamify\Traits;

use Illuminate\Support\Facades\Auth;

// Record who create an object, who update an object
trait RecordSignature
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id;
            $model->updated_by = Auth::id;
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id;
        });
    }
}