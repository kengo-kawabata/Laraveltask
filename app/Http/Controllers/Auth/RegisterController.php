<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /* Validator::make(検証データ, [ルール定義], [メッセージ定義], [項目名定義]); */
        return Validator::make($data, [
            /* ユーザー名の入力欄を下記のように定義する */
            // required：入力必須
            // string：値を文字列形式に指定
            // max:255：入力最大値を255文字に指定
            'name' => ['required', 'string', 'max:255'],

            /* メールアドレスの入力欄を下記のように定義する */
            // required：入力必須
            // string：値を文字列形式に指定
            // email：値をEmailアドレス形式に指定
            // max:255：入力最大値を255文字に指定
            // unique:users：DBのusersテーブルで使用済みか確認する
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],

            /* ユーザー名の入力欄を下記のように定義する */
            // required：入力必須
            // string：値を文字列形式に指定
            // min:8：入力最小値を8文字に指定
            // confirmed：confirmed バリデーションルールを指定（「名目_confirmationの入力欄と一致する」に指定）
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ], [], [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}