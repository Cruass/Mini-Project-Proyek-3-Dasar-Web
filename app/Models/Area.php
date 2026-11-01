<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = ['nama'];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
