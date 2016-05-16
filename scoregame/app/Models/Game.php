<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $primaryKey = 'idgame';

    public $fillable = [
        'location',
        'date',
        'comment',
        'attendance',
        'weather',
        'temperature',
        'Plateump',
        'Fieldump1',
        'Fieldump2',
        'Fieldump3',
        'Fieldump4',
        'Fieldump5',
        'status',
        'Tickets',
        'duration',
        'winning_team',
        'regulation',
        'last_inning',
        'half_inning',
        'game_type'
    ];


    public $timestamps = false;

    public $statuses = [
        '0' => 'created', '1' => 'in progress', '2' => 'End-regulation', '3' => 'End-extraInnings', '4' => 'End-timeLimit', '5' => 'End-runRule', '6' => 'End-forfeit', '7' => 'End-darkness',
        '8' => 'End-rainOut', '9' => 'End-other', '10' => 'Suspended - Darkness', '11' => 'Suspended-rain', '12' => 'Suspended-other'
    ];

    public $weathers = [
        'Cloudy' => 'Cloudy',
        'Overcast' => 'Overcast',
        'Rain-Intermittent' => 'Rain-Intermittent',
        'Rain' => 'Rain',
        'Sleet' => 'Sleet',
        'Sunny' => 'Sunny',
        'Thunderstorms' => 'Thunderstorms'
    ];

    public $weatherIcons = [
        'Cloudy' => '/images/atbat/weather/ic_mist.png',
        'Overcast' => '/images/atbat/weather/ic_partly_cloudy.png',
        'Rain-Intermittent' => '/images/atbat/weather/ic_light_rain.png',
        'Rain' => '/images/atbat/weather/ic_rain.png',
        'Sleet' => '/images/atbat/weather/ic_snow_rain.png',
        'Sunny' => '/images/atbat/weather/ic_sunny.png',
        'Thunderstorms' => '/images/atbat/weather/ic_thunder_rain.png'
    ];

    public function getDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['date'])->format('m-d-Y H:i');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('m-d-Y H:i',$date)->format('Y-m-d H:i:s');
    }

    public function getDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',$this->attributes['date']);
    }

    public function teamHome()
    {
        return $this->hasOne('App\Models\Team', 'idteam', 'Teams_idteam_home');
    }

    public function teamVisitor()
    {
        return $this->hasOne('App\Models\Team', 'idteam', 'Teams_idteam_visiting');
    }

    public function lineups()
    {
        return $this->hasMany('App\Models\Lineup', 'Games_idgame');
    }

    public function season()
    {
        return $this->belongsTo('App\Models\_Season', 'season_idseason');
    }

    public function storage()
    {
        return $this->hasOne('App\Models\AtBat', 'Games_idgame', 'idgame');
    }

    public function getLineupHome()
    {
        return $this->lineups->where('Teams_idteam', $this->Teams_idteam_home)->first();
    }

    public function getLineupVisitor()
    {
        return $this->lineups->where('Teams_idteam', $this->Teams_idteam_visiting)->first();
    }
}
