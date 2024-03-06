<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     *  ホームページを表示するコントローラー
     *  
     *  GET /
     *  @return \Illuminate\View\View
     */
    public function index()
    {
        // ログインユーザーを取得する
        /** @var App\Models\User **/
        $user = Auth::user();

        // ログインユーザーに紐づくフォルダを一つ取得する
        $folder = $user->folders()->first();

        // まだ一つもフォルダを作っていなければホームページをレスポンスする
        if (is_null($folder)) {
            // ホーム画面のPathを渡した結果を返す
            // view('遷移先のbladeファイル名');
            return view('home');
        }

        /* フォルダがあればそのフォルダに紐づくタスク一覧ページにリダイレクトする */
        // indexテンプレートにフォルダーIDを渡した結果を返す
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
}
