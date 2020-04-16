<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDomicilioRequest;
use App\Models\UserDomicilio;
use Illuminate\Http\Request;

class UsersDomicilioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $campos = [
            'users_domicilio.id',
            'users_domicilio.calle',
            'users_domicilio.colonia',
            'users_domicilio.cp',
            'users.name as usuario'
        ];
        $domicilio = UserDomicilio::select($campos)
            ->join('users', 'users.id', '=', 'users_domicilio.user_id')
            ->get();
            //->pluck();

        return response()->json($domicilio, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserDomicilioRequest $request)
    {
        $data = $request->all();

        UserDomicilio::create($data);

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
            'users_domicilio.id',
            'users_domicilio.calle',
            'users_domicilio.colonia',
            'users_domicilio.cp',
            'users.name as usuario'
        ];

        $domicilio = UserDomicilio::select($campos)
            ->join('users', 'users.id', '=', 'users_domicilio.user_id')
            ->findOrFail($id);

        return response()->json($domicilio, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $domicilio = UserDomicilio::where('id', $id)->firstOrFail();
        $data = $request->all();

        $domicilio->update($data);

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
        UserDomicilio::findOrFail($id)->delete();

        return response()->json(['result' => 'ok'], 200);
    }
}
