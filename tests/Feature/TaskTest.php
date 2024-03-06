<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * タスクのバリデーションテスト用のクラス
 * 用途：期限のバリデーションをテストする
 * 
 */
class TaskTest extends TestCase
{
    // テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
    use RefreshDatabase;

    /**
     * 各テストメソッドの実行前に呼ばれるメソッド
     * 用途：タスクのテストに必要な FoldersTableSeeder を実行する
     * 
     */
    public function setUp():void
    {
        // 親クラスの抽象クラスにアクセスして自身のsetUp()を実行する
        parent::setUp();

        // テストケース実行前にフォルダデータを作成（実行）する
        $this->seed('FoldersTableSeeder');
    }

    /**
     * 期限日が日付ではない場合はバリデーションエラーにするメソッド
     * 用途：期限日に日付以外のデータを入力してエラーをテストする
     * 
     * @test
     */
    public function due_date_should_be_date()
    {
        // タスクを新規作成する -> post(アクセスURL, 入力値);
        $response = $this->post('/folders/1/tasks/create', [
            // タイトルを入力する
            'title' => 'Sample task',
            // 期限日を入力する（不正なデータ（数値））
            'due_date' => 123,
        ]);

        /* LaravelのphpUnit で TestCase からエラーメッセージを確認するためセッションの中身を確認する（TestCase からはセッションの中身を見ないとエラーメッセージを確認できない） */
        // assertSessionHasErrors()：セッションが指定したエラーバッグの中に、指定した$keysのエラーを持っていることを宣言する
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

    /**
     * 期限日が過去日付の場合はバリデーションエラーにするメソッド
     * 用途：期限日にバリデーションルール違反の過去日付を入力してエラーをテストする
     * 
     * @test
     */
    public function due_date_should_not_be_past()
    {
        // タスクを新規作成する -> post(アクセスURL, 入力値);
        $response = $this->post('/folders/1/tasks/create', [
            // タイトルを入力する
            'title' => 'Sample task',
            // 期限日を入力する（不正なデータ（昨日の日付））
            'due_date' => Carbon::yesterday()->format('Y/m/d'),
        ]);

        /* LaravelのphpUnit で TestCase からエラーメッセージを確認するためセッションの中身を確認する */
        $response->assertSessionHasErrors([
            'due_date' => '期限日 には今日以降の日付を入力してください。',
        ]);
    }

        /**
        * 状態（セレクトボックスの値）が定義された値ではない場合はバリデーションエラーにするメソッド
        * 用途：状態（'status'）に不正な値（1,2,3以外）を入力してエラーをテストする
        * 
        * @test
        */
        public function status_should_be_within_defined_numbers()
        {
            // テストケース実行前にフォルダデータを作成（実行）する
            $this->seed('TasksTableSeeder');
        
                // タスクを編集（更新）する -> post(アクセスURL, 入力値);
            $response = $this->post('/folders/1/tasks/1/edit', [
                // タイトルを入力する
                'title' => 'Sample task',
                // 期限日を入力する
                'due_date' => Carbon::today()->format('Y/m/d'),
                // 状態を入力する
                'status' => 999, // 不正なデータ（数値）
            ]);
        
            /* LaravelのphpUnit で TestCase からエラーメッセージを確認するためセッションの中身を確認する */
            // assertSessionHasErrors()：セッションが指定したエラーバッグの中に、指定した$keysのエラーを持っていることを宣言する
            $response->assertSessionHasErrors([
                'status' => '状態 には 未着手、着手中、完了 のいずれかを指定してください。',
            ]);
        }
}