<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\UserDomicilio;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::select('id','name', 'email', 'telefono')
            ->get();
            //->pluck();

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return response()->json(['result' => 'ok'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $campos = [
            'name',
            'email',
            'telefono',
        ];

        /*$user = User::select('name', 'email', 'telefono')
            ->where('id', $id)
            ->first();
        $user = User::select('name', 'email', 'telefono')
            ->where('id', $id)
            ->firstOrFail();
        $user = User::select('name', 'email', 'telefono')
            ->where('id', $id)
            ->find();*/
        $user = User::select($campos)
            ->findOrFail($id);

        $domicilio = [
            'calle',
            'colonia',
            'cp'
        ];
        $user->domicilio = UserDomicilio::select($domicilio)
            ->where('user_id', $id)
            ->get();

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $data = $request->all();

        $user->update($data);

        return response()->json(['result' => 'ok'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return response()->json(['result' => 'ok'], 200);
    }
}
