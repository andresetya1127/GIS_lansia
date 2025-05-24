<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
            $model->umur = self::hitungUmur($model->tgl_lahir);
        });

        static::updating(function ($model) {
            $model->umur = self::hitungUmur($model->tgl_lahir);
        });
    }

    protected static function hitungUmur($tanggalLahir)
    {
        $lahir = Carbon::parse($tanggalLahir);
        $sekarang = Carbon::now();

        // Ambil selisih dengan detail tahun & bulan
        $diff = $lahir->diff($sekarang);

        $tahun = $diff->y;
        $bulan = $diff->m;
        return $tahun . ' Tahun ' . $bulan . ' Bulan';
    }


    public function pendata()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
