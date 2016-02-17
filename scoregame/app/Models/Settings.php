<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'idsettings';
    public $timestamps = false;

    public function season()
    {
        return $this->belongsTo('App\Models\_Season', 'idseason');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'iduser');
    }

    public static function get()
    {
        return Settings::first();
    }

}