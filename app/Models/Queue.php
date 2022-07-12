<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Queue extends Model
{
    use HasFactory, AsSource;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'time', 'current_user', 'start_time', 'end_time'
    ];

    protected $dates = [
        'start_time',
        'end_time'
    ];

    public function experiments()
    {
        return $this->belongsToMany(Experiment::class);
    }
}
