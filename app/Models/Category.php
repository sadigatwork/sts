<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
    ];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
