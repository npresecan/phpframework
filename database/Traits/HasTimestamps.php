<?php

namespace Database\Traits;

use DateTime;

trait HasTimestamps
{
    public static function bootHasTimestamps()
    {
        static::creating(function ($model) {
            $currentTimestamp = new DateTime();
            $model->created_at = $currentTimestamp->format('Y-m-d H:i:s');
            $model->updated_at = $currentTimestamp->format('Y-m-d H:i:s');
        });
        
        static::updating(function ($model) {
            $model->updated_at = (new DateTime())->format('Y-m-d H:i:s');
        });
    }
}