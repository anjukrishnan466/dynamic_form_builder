<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    use SoftDeletes;
    protected $fillable = ['title'];

    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($form) {
            if (! $form->isForceDeleting()) {
                $form->fields()->each(function ($field) {
                    $field->delete(); // soft delete each field
                });
            }
        });
    }
}
