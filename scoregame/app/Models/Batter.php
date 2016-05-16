<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batter extends Model
{
    protected $primaryKey = 'idbatter';
    protected $fillable = [
        'DefensePosition',
        'Number',
        'BatterPosition',
        'Inning',
        'Players_idplayer',
        'SubOrder'
    ];

    public static $defensePositions = [
        '0'=>'*', '1' => 'P', '2' => 'C', '3' => '1B', '4' => '2B', '5' => '3B', '6' => 'SS',
        '7' => 'LF', '8' => 'CF', '9' => 'RF', '11' => 'DH', '12' => 'PH',
        '13' => 'PR'
    ];

    public $timestamps = false;

    public function lineup()
    {
        return $this->belongsTo('App\Models\Lineup','Lineup_idlineup');
    }

    public function player()
    {
        return $this->belongsTo('App\Models\Player','Players_idplayer');
    }

    public function setDefensePosition($playerPosition)
    {
        $dict = array_flip(Batter::$defensePositions);
        $this->DefensePosition = $dict[$playerPosition];
    }

    public function getDefensePosition()
    {
        return Batter::$defensePositions[$this->DefensePosition];
    }
}
