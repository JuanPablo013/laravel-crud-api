<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlayerController extends Controller
{

    public function index () 
    {
        $players = Player::all();

        if ($players->isEmpty()) {
            $data = [
                'message' => 'No se encontraron jugadores',
                'status' => 200
            ];
            return response()->json( $data, 404);
        }

        $data = [
            'players' => $players,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|max:100',
            'position' => 'required|max:50',
            'number' => 'required|digits:3'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $player = Player::create([
            'name' => $request->name,
            'position' => $request->position,
            'number' => $request->number
        ]);

        if (!$player) {
            $data = [
                'message' => 'Error al crear el jugador',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'player' => $player,
            'status' => 201
        ];

        return response()->json($data, 201);

    }

    public function show($id)
    {
        $player = Player::find($id);

        if (!$player) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json( $data, 404);
        }

        $data = [
            'player' => $player,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $player = Player::find($id);

        if (!$player) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json( $data, 404);
        }

        $player->delete();

        $data = [
            'message' => 'Jugador eliminado',
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function update(Request $request, $id)
    {
        $player = Player::find($id);

        if (!$player) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json( $data, 404);
        }

        $validator = Validator::make( $request->all(), [
            'name' => 'required|max:100',
            'position' => 'required|max:50',
            'number' => 'required|digits:3'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $player->name = $request->name;
        $player->position = $request->position;
        $player->number = $request->number;

        $player->save();

        $data = [
            'message' => 'Jugador actualizado',
            'player' => $player,
            'status' => 200
        ];

        return response()->json($data, 200);

    }

    public function updatePartial(Request $request, $id)
    {
        $player = Player::find($id);

        if (!$player) {
            $data = [
                'message' => 'Jugador no encontrado',
                'status' => 404
            ];
            return response()->json( $data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:100',
            'position' => 'max:100',
            'number' => 'digits:3'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('name')) {
            $player->name = $request->name;
        }

        if ($request->has('position')) {
            $player->position = $request->position;
        }

        if ($request->has('number')) {
            $player->number = $request->number;
        }

        $player->save();

        $data = [
            'message' => 'Jugador actualizado',
            'player' => $player,
            'status' => 200
        ];

        return response()->json($data, 200);
            
    }

}
