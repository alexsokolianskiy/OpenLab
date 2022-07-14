<?php

namespace App\Models;

use App\Services\Page\PageService;
use Orchid\Screen\AsSource;
use Spatie\Sluggable\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Sluggable\SlugOptions;

class Page extends Model
{
    use HasFactory, AsSource, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'view'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')
        ->saveSlugsTo('view');
    }

    public function getCodeAttribute()
    {
        return PageService::getViewContent($this->view);
    }

    public function getRouteKeyName()
    {
        return 'view';
    }
}
