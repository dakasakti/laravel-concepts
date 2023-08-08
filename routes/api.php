<?php

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Rules\Lowercase;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as ValidationValidator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('users', function (Request $request) {
    return $request->user();
});

Route::post('users', function (RegisterRequest $request) {
    $validateData = $request->validated();

    $user = User::create($validateData);
    return response($user, Response::HTTP_CREATED);
});

Route::post('test/login', function (Request $request) {
    $rules = [
        'email' => 'required|email|lowercase',
        'password' => ['required', new Lowercase, Password::min(8)->letters()->numbers()->symbols()],
    ];

    $messages = [
        'required' => ':attribute harus diisi!',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);
    // dd($validator->passes()); // success => bool
    // dd($validator->fails()); // failed => bool

    $validator->after(function (ValidationValidator $validator) {
        $data = $validator->getData();
        if ($data['password'] == 'password') {
            $validator->errors()->add('password', "The password field must not be 'password'.");
        }
    });

    // first
    // dd($validator->validate()); // success => array
    // dd($validator->getMessageBag()); // error messages => array

    // second
    try {
        dd($validator->validate());
    } catch (ValidationException $e) {
        dd($e->validator->errors());
    }
});

Route::post('login', function (LoginRequest $request) {
    $validateData = $request->validated();

    if (!auth()->attempt($validateData)) {
        return response(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    $token = $request->user()->createToken($validateData['email']);
    return response(['token_type' => 'Bearer', 'access_token' => $token->plainTextToken]);
});
