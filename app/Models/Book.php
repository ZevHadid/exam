<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun',
        'returned_at',
    ];
}
