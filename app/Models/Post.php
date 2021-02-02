<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory, AsSource, Filterable;
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'hero'
    ];

    protected array $allowedSorts = [
        'title',
        'created_at',
        'updated_at'
    ];


}
