<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class Bulletin extends Model
{
    use HasFactory;
    #[SearchUsingFullText(['text_without_formatation'])]

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_of_file',
        'original_text',
        'text_without_formatation',
        'path_of_file',        
        'date_of_publish',        
    ];
}
