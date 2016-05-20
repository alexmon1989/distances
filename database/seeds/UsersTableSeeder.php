<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        $user = new User();
        $user->name = 'Александр';
        $user->email = 'alex.mon1989@gmail.com';
        $user->password = bcrypt('admin1234');
        $user->save();
    }
}
