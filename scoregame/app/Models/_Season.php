<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class _Season extends Model
{
    protected $table = 'season';
    protected $primaryKey = 'idseason';
    protected $fillable = [
        'season',
        'startdate',
        'enddate',
        'status'
    ];

    public $timestamps = false;

    public function games()
    {
        return $this->hasMany('App\Models\Game', 'season_idseason');
    }
}
