<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * usersTable用テストデータ
     * 
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'test',
            'email' => 'dummy@email.com',
            'password' => bcrypt('test1234'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2345@email.com',
            'password' => bcrypt('test2345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $user = DB::table('users')->skip(1)->first();

        $titles = ['サンプルフォルダ01（test2）', 'サンプルフォルダ02（test2）', 'サンプルフォルダ03（test2）'];

         foreach ($titles as $title) {
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}