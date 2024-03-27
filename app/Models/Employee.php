<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    const STATUS_AKTIF = 0;
    const STATUS_TIDAK_AKTIF = 1;

    const AGAMA_ISLAM = 0;
    const AGAMA_KRISTEN = 1;
    const AGAMA_HINDU = 2;
    const AGAMA_BUDDHA = 3;
    const AGAMA_KHATOLIK = 4;

    /**
     * Get the position that owns the Employee
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function getStatusLabelAttribute()
    {
        $list = self::listStatus();

        return isset($list[$this->status])
            ? $list[$this->status]
            : $this->status;
    }

    public function getAgamaLabelAttribute()
    {
        $list = self::listAgama();

        return isset($list[$this->agama])
            ? $list[$this->agama]
            : $this->agama;
    }

    public static function listStatus()
    {
        return [
            self::STATUS_AKTIF => 'Aktif',
            self::STATUS_TIDAK_AKTIF => 'Tidak Aktif',
        ];
    }

    public static function listAgama()
    {
        return [
            self::AGAMA_ISLAM => 'Islam',
            self::AGAMA_KRISTEN => 'Kristen',
            self::AGAMA_HINDU => 'Hindu',
            self::AGAMA_BUDDHA => 'Buddha',
            self::AGAMA_KHATOLIK => 'Khatolik',
        ];
    }
}
