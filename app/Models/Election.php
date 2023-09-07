<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'start', 'end'];

    // Define the relationship with the Candidate model
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    // Define the relationship with the Vote model
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Define the relationship with the User (voter) model through the Vote model
    public function voters()
    {
        return $this->belongsToMany(User::class, 'votes', 'election_id', 'voter_id');
    }
}
