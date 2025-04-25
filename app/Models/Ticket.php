<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ticket extends Model
{

    const STATUS = [
        'Open' => 'Open',
        'Archived' => 'Archived',
        'Resolved' => 'Resolved',
        'Closed' => 'Closed',
    ];
    const PRIORITY = [
        'Low' => 'Low',
        'Medium' => 'Medium',
        'High' => 'High',
    ];
    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'is_resolved',
        'comment',
        'assigned_by',
        'assigned_to',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
