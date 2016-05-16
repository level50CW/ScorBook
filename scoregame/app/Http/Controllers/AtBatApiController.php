<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AtBat;
use App\Models\Game;
use Request;
use Response;

class AtBatApiController extends Controller
{
    public function postGameStatus()
    {
        $data = Request::all();
        $game = Game::findOrFail($data['_id']);
        $game->status = $data['data']['status'];
        $game->save();
        return Response::json(['success'=>true]);
    }

    public function getGameStatus()
    {
        $data = Request::all();
        $game = Game::findOrFail($data['_id']);

        return Response::json(['status'=>$game->status]);
    }

    public function postStorage()
    {
        $data = Request::all();
        $game = Game::findOrFail($data['_id']);

        $storage = $game->storage;
        if ($storage == null){
            $storage = new AtBat();
            $storage->game()->associate($game);
            $storage->save();
        }

        $storage->storage = $data['data']['storage'];
        $storage->save();

        return Response::json(['success'=>true]);
    }

    public function getStorage()
    {
        $data = Request::all();
        $game = Game::findOrFail($data['_id']);

        $storage = $game->storage;
        if ($storage == null){
            $storage = new AtBat();
            $storage->game()->associate($game);
            $storage->save();
        }

        return Response::json(['storage'=>$storage->storage]);
    }

    public function postLastInning()
    {
        $data = Request::all();
        $game = Game::findOrFail($data['_id']);

        $game->last_inning = $data['data']['inning'];
        $game->save();

        return Response::json(['success'=>true]);
    }
}
