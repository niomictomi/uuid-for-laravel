<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    /**
     * Boot the Has Uuid trait for the model.
     *
     * @return void
     */
    public static function bootHasUuid()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }
        });
    }
}
