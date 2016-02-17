<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtBat extends Model
{
    protected $primaryKey = 'idatbat';
    protected $table = 'atbats';
    protected $fillable = [
        'storage',
    ];

    public $timestamps = false;

    public function game()
    {
        return $this->belongsTo('App\Models\Game','Games_idgame');
    }
}
