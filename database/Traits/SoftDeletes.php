<?php

namespace Database\Traits;

use DateTime;

trait SoftDeletes
{
    public static function bootSoftDeletes()
    {
        static::deleting(function ($model) {
            if ($model->isForceDeleting()) {
                return;
            }

            $model->deleted_at = (new DateTime())->format('Y-m-d H:i:s');
            $model->save();
        });
    }
    
    public function softDelete()
    {
        $this->deleted_at = (new DateTime())->format('Y-m-d H:i:s');
        $this->save();
    }
    
    public function Delete()
    {
        return $this->delete();
    }
}