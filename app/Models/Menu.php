<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Menu extends Model
{
    public $table = 'menu';

    use HasFactory, AsSource;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'url',
        'order_num',
        'parent_id'
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }

    public function scopeFirstLevel(Builder $query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSecondLevel(Builder $query)
    {
        return $query->whereNotNull('parent_id');
    }



}
