<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * リクエストの内容に基づいた権限チェックを行うメソッド
     *
     * @return bool
     */
    public function authorize()
    {
        // 返り値にtrueを指定する（リクエストを受け付ける）
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * バリデーションルールを定義するメソッド
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            /* タイトルの入力欄を入力必須の最大文字数100文字に定義する */
            // required：入力必須
            'title' => 'required|max:100',
            /* 日付の入力欄を入力必須、値を日付形式、入力日以前の入力不可にする */
            // required：入力必須
            // date：値を日付形式に指定
            // after_or_equal：特定の日付（この場合はtoday）以前の日付の入力を不可に（制限）する
            'due_date' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * リクエストのnameなどの値を再定義するメソッド
     *
     * @return array<string>
     */
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    /**
     * FormRequestクラス単位でエラーメッセージを定義するメソッド
     *
     * @return array<string>
     */
    public function messages()
    {
        return [
            /* ルールに違反した場合にエラーメッセージを出力する */
            // 'due_date.after_or_equal':'項目名.ルール内容'
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
