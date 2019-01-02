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
            $user = Auth::user();
            $model->created_by = $user->id;
            $model->updated_by = $user->id;
        });

        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
    }
}
