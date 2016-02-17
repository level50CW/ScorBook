<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $primaryKey = 'idplayer';
    protected $fillable = [
        'Firstname',
        'Lastname',
        'Number',
        'Position',
        'Bats',
        'Throws',
        'Height',
        'Weight',
        'College',
        'Class',
        'Hometown',
        'State',
        'Photo'
    ];

    public $timestamps = false;

    public $positions = [
        'P' => 'P', 'C' => 'C', '1B' => '1B', '2B' => '2B', '3B' => '3B', 'SS' => 'SS',
        'LF' => 'LF', 'CF' => 'CF', 'RF' => 'RF', 'EF' => 'EF', 'DH' => 'DH', 'PH' => 'PH',
        'PR' => 'PR', 'CR' => 'CR',
    ];


    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'Teams_idteam');
    }

    public function gamesBatter()
    {
        return $this->hasMany('App\Models\Batter', 'Players_idplayer');
    }

    public function getFullName()
    {
        return $this->Firstname.' '.$this->Lastname;
    }

    public function getCutName()
    {
        return $this->Firstname[0].'. '.$this->Lastname;
    }
}
