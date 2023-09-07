<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    // Define the relationship with the voter (User model)
    public function voter()
    {
        return $this->belongsTo(User::class, 'voter_id');
    }

    // Define the relationship with the candidate
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // Define the relationship with the election
    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
