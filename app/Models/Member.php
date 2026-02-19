<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'kelas',
        'jurusan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
