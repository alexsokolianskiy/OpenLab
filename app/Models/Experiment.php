<?php

namespace App\Models;

use App\Models\Queue;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Experiment extends Model
{
    use HasFactory, AsSource;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'queue_id'
    ];

    public function queue()
    {
        return $this->hasOne(Queue::class, 'id', 'queue_id');
    }
}
