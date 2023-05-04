<?php

namespace App\Http\Controllers\Api;

use App\Models\User\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Validator;
use Throwable;

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
        try {
            $validator = $this->validateInput($request->all());

            if ($validator->fails()) {
                return response()->json($this->payloadFormat(400, "Validation Failed!", $validator->errors()), 400);
            }

            $user = new User();
            $user::create($request->input());

            return response()->json($this->payloadFormat(201, "User created successfully!", $request->all()), 201);
        } catch (Throwable $th) {
            return response()->json($this->payloadFormat(400, "Something went wrong", ["error" => $th->errorInfo]), 400);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateInput($request->input(), $id);
        if ($validator->fails()) {
            return response()->json($this->payloadFormat(400, "Validation failed",  $validator->errors()), 400);
        }

        $user = User::find($id);
        $user->update($request->input());
        return response()->json($this->payloadFormat(200, "User updated successfully!", $request->input()), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    private function payloadFormat($status, $message, $data = null)
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
        return $response;
    }

    private function validateInput($data = [], $id = "")
    {
        return validator($data, [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'unique:users,email,' . $id,
            'password' => 'required|max:100',
            'description' => 'max:100',
        ]);
    }
}
