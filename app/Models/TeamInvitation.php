<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamInvitation extends Model
{
    protected $fillable = [
        'team_id',
        'email',
        'token',
        'accepted_at',
        'declined_at'
    ];

    protected function casts(): array
    {
        return [
            'accepted_at' => 'datetime',
            'declined_at' => 'datetime',
        ];
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return User::where('email', $this->email)->first();
    }

    public function isAccepted()
    {
        return $this->accepted_at !== null;
    }

    public function isDeclined()
    {
        return $this->declined_at !== null;
    }
}
