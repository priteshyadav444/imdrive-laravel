<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\storeUserRequest;
use App\Models\User\User;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success($this->getAllUser(), "All users lists", 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         $payload = $request->input();
    //         $validator = $this->validateInput($payload);
    //         if ($validator->fails())
    //             return Response($this->payloadFormat(400, "Validation Failed!", $validator->errors()), 400);

    //         // hashing password
    //         $payload['password'] = Hash::make($request->input('password'));
    //         // creating User 
    //         $user = new User();
    //         $payload["id"] = $user->create($payload)->id;
    //         // $user = Auth::user();
    //         //generating token

    //         $payload['token'] = $user->createToken("authToken")->accessToken;
    //         unset($payload['password']);

    //         return Response($this->payloadFormat(201, "User created successfully!", $payload), 201);
    //     } catch (Throwable $th) {
    //         return Response($this->payloadFormat(400, "Something went wrong", ["error" => $th]), 400);
    //     }
    // }



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

    public function login(Request $request)
    {

        $validator = $this->validateLoginInput($request->only('email', 'password'));
        // validating input
        if ($validator->fails()) {
            return Response($this->payloadFormat(400, "Validation Failed!", $validator->errors()), 400);
        }

        ['email' => $email, 'password' => $password] = $request->only('email', 'password');


        // checking is user exists or not
        if (!$this->getUserByEmail($email)) {
            return Response($this->payloadFormat(404, "User Not Found!. Enter Registered Email", compact('email')), 404);
        }

        // checking user credentials
        if (Auth::attempt(compact('email', 'password'))) {
            $user = Auth::user();
            $user['token'] = $user->createToken('accessToken')->plainTextToken;
            unset($user['password'], $user['account_status']);
            return Response($this->payloadFormat(200, "User Logged In Successfully!", [$user]), 200);
        }

        return Response($this->payloadFormat(400, "Password Mismatch!", ['email' => $email]), 400);
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

    private function validateInput($payload = [], $id = "")
    {
        return validator($payload, [
            'firstname' => 'required|string|max:60',
            'lastname' => 'required|string|max:60',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'required|max:100|min:8',
            'description' => 'max:150',
        ]);
    }

    private function validateLoginInput($payload = [])
    {
        return validator($payload, [
            'email' => 'required|email|max:100',
            'password' => 'required|max:100|min:8',
        ]);
    }

    private function getUserById($id, $accountStatus = "active")
    {
        return User::ofType($accountStatus)->find($id);
    }

    private function getUserByEmail($email, $accountStatus = "active")
    {
        return User::ofType($accountStatus)->where("email", $email)->first();
    }

    private function getAllUser($accountStatus = "active")
    {
        return User::ofType($accountStatus)->get();
    }

    public function register(storeUserRequest $request)
    {
        try {
            $request->validated($request->all());
            $payload = $request->input();
            // $validator = $this->validate();
            // if ($validator->fails())
            //     return $this->error($validator->errors(),  "All field required!", 400);

            // hashing password
            $payload['password'] = bcrypt($request->input('password'));

            // creating User 
            $user = User::create($payload);
            $payload['id'] = $user->id;

            // generating token
            $payload['token'] = $user->createToken("access token {$payload['id']}", ['users:view'])->plainTextToken;
            unset($payload['password']);

            return $this->success($payload,  "User created successfully!", 201);
        } catch (Throwable $th) {
            dd($th);
            return Response($this->payloadFormat(400, "Something went wrong", ["error" => $th]), 400);
        }
    }

    public function logout(Request $request)
    {
        dd($request->user()->tokens()->delete());
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
