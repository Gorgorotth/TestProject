<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'user_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function getFilePathAttribute()
    {
        return Storage::disk('files')->url($this->name);
    }

}
