<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Random extends Model
{
    protected $fillable = ['values', 'flag'];
    use HasFactory;

    public function getBreakDowns()
    {
        return $this->hasMany(Breakdown::class, 'random_id');
    }
}
