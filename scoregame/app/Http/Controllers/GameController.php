<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $games = Game::whereRaw('date >= ? and date < ?', [Carbon::today(), Carbon::tomorrow()])->get();
        return view('game.admin',compact('games'));
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        $numberUmps = Settings::get()->numberUmps;
        return view('game.update.gameinfo',compact(['game','numberUmps']));
    }

    public function store($id, Request $request)
    {
        $game = Game::findOrFail($id);
        $numberUmps = Settings::get()->numberUmps;

        $conditions = [
            'status'=>'required|numeric',
            'attendance'=>'numeric',
            'weather'=>'required',
            'temperature'=>'required|numeric',
            'Plateump'=>'required',
        ];

        for($i=1; $i<=$numberUmps; $i++){
            $conditions['Fieldump'.$i] = 'required';
        }

        $input = $request->all();
        $validator = validator($input,$conditions);

        if ($validator->fails()){
            return view('game.update.gameinfo',compact(['game','numberUmps']))
                ->withErrors($validator);
        }

        $game->update(array_except($request->all(),['_token']));
        return redirect(action('LineupController@edit',['id'=>$id, 'team'=>'home']));
    }
}
