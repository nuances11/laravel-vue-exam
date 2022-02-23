<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $users = Http::get('https://jsonplaceholder.typicode.com/users');
        $data = [];
        $password = Hash::make('password');
        foreach ($users->json() as $key => $user) {
            $data[] = [
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $password,
                'created_at' => Carbon::now()
            ];
        }

        User::insert($data);
    }
}
