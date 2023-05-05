<?php

namespace App\Http\Controllers\Api;

use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response($this->payloadFormat(200, "All users lists", $this->getAllUser()), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $payload = $request->input();
            $validator = $this->validateInput($payload);
            if ($validator->fails())
                return Response($this->payloadFormat(400, "Validation Failed!", $validator->errors()), 400);

            // hashing password
            $payload['password'] = Hash::make($request->input('password'));
            // creating User 
            $user = new User();
            $payload["id"] = $user->create($payload)->id;
            // $user = Auth::user();
            //generating token

            $payload['token'] = $user->createToken("authToken")->accessToken;
            unset($payload['password']);

            return Response($this->payloadFormat(201, "User created successfully!", $payload), 201);
        } catch (Throwable $th) {
            return Response($this->payloadFormat(400, "Something went wrong", ["error" => $th]), 400);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // $user = Auth::guard('api')->check();
        // dd($user);
        if ($id) {
            $user = $this->getUserById($id);
            if (!$user) {
                return Response($this->payloadFormat(404, "User nPuot found", []), 404);
            }
            return Response($this->payloadFormat(200, "User found!", $user), 200);
        }
        return Response($this->payloadFormat(401, "Unauthenticated Request!",), 401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $payload = $request->input();
        $validator = $this->validateInput($payload, $id);
        if ($validator->fails()) {
            return Response($this->payloadFormat(400, "Validation failed!",  $validator->errors()), 400);
        }

        $user = $this->getUserById($id);
        if (!$user) {
            return Response($this->payloadFormat(404, "User not found!", $id), 404);
        }
        $user->update($payload);
        $payload['id'] = $id;
        return Response($this->payloadFormat(200, "User updated successfully!", $payload), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = $this->getUserById($id);
        if (!$user) {
            return Response($this->payloadFormat(404, "User Not Found!", $id), 404);
        }
        $user->account_status = "inactive";
        $user->save();
        return Response($this->payloadFormat(200, "User deleted successfully!", $id), 200);
    }

    public function login($id)
    {
        $user = $this->getUserById(39);
        if (!$user) {
            return Response($this->payloadFormat(404, "User Not Found!", $id), 404);
        }

        // Creating a token without scopes...
        $token = $user->createToken('accessToken')->accessToken;
        $payload = $user;
        $payload['token'] = $token;
        return Response($this->payloadFormat(200, [$user, 'token' => $token]), 200);
    }

    private function payloadFormat($status, $message, $data = null)
    {
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];
        if ($data == null) unset($response['data']);
        return $response;
    }

    private function validateInput($data = [], $id = "")
    {
        return validator($data, [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'required|max:100|min:8',
            'description' => 'max:150',
        ]);
    }

    private function getUserById($id, $accountStatus = "active")
    {
        return User::ofType($accountStatus)->find($id);
    }

    private function getAllUser($accountStatus = "active")
    {
        return User::ofType($accountStatus)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function login(Request $request)
    // {
    //     try {
    //         $payload = $request->input();
    //         $validator = $this->validateInput($payload);
    //         if ($validator->fails()) {
    //             return Response($this->payloadFormat(400, "Validation Failed!", $validator->errors()), 400);
    //         }

    //         $user = new User();
    //         $payload["id"] = $user->create($payload)->id;
    //         return Response($this->payloadFormat(201, "User created successfully!", $payload), 201);
    //     } catch (Throwable $th) {
    //         return Response($this->payloadFormat(400, "Something went wrong", ["error" => $th]), 400);
    //     }
    // }
}
