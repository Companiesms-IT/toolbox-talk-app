<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFile extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'media_files';
    
    protected $fillable = [
        'user_id',
        'toolbox_talk_id',
        'file_name',
        'file_size',
        'file_path'
    ];
}
