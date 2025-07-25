<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResourceVideoLink extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'resource_video_links';
    
    protected $guarded = [];
}
