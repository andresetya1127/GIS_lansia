<?php

namespace App\Models;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class Lansia extends Model
{
    protected $primaryKey = 'uuid';
    protected $guarded = ['uuid'];
    protected $keyType = 'string';
    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function pendata()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
