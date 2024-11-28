<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        $token  = $user->currentAccessToken()->delete();
        // $user->tokens()->where('id', $tokenId)->delete();
        return response()->json(['message'=> 'Logout Successfully']);
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $userLogData = $request->validate([
            'email' => 'required|string|email',
            'password'=> 'required',
        ]);
        if(!Auth::attempt($userLogData)) 
        {
            return response()->json(['message'=>'ivalid password']);
            
        }
        $user = Auth::user();
        // $token = $user->createToken('API Token')->plainTextToken;
        $token  = $user->createToken('API Token')->plainTextToken;
        // dd($request);
        return response()->json(['message'=> $token]);
    }
    public function register(Request $request)
    {
        $userData = $request->validate([
            'email' => 'required|string|email',
            'first_name' => 'required|string',
            'last_name'=> 'required|string',
            'password'=> 'required|string|min:8',
        ]);
        // dd($userData);
        User::create([
            'first_name'=> $userData['first_name'],
            'last_name'=> $userData['last_name'],
            'email'=> $userData['email'],
            'password'=> Hash::make ($userData['password']),
        ]);

        return response()->json(['message'=>'account successfully created']);


    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
