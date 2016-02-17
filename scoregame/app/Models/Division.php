<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'division';
    protected $primaryKey = 'iddivision';
    protected $fillable = [
        'Name'
    ];

    public $timestamps = false;

    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'Division_iddivision');
    }
}