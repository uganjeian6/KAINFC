<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'description',
        'team_leader_id',
    ];

    public function leader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_members');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
