<?php

namespace App\Http\Controllers\Api;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(User::get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json($this->payloadFormat(400, "Validation Failed", $validator->errors()), 400);
        }

        $user = new User();
        $user::create($request->all());

        return response()->json($this->payloadFormat(201, "User Created Successfully", ["user" => $request->all()]), 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    private function payloadFormat($status, $message, $data)
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
        return $response;
    }

    private function validator($data = [])
    {
        return validator($data, [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|email|max:100|unique:users',
            'password' => 'required|max:100',
            'description' => 'max:100',
        ]);
    }
}
