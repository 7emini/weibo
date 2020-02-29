<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = factory(User::class)->times(50)->make();
        //makeVisible: 临时显示 User 模型的隐藏属性
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());
        
        //修改第一个用户
        $user = User::first();
        $user->name = 'Gemini';
        $user->email = '37emini@gmail.com';
        $user->password = bcrypt('123456');
        $user->is_admin = true;
        $user->save();

    }
}
