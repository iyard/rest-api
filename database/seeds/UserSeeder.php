<?php

use App\Models\Email;
use App\Models\Phone;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 10)->create()->each(function ($user) {
            $user->phones()->saveMany(factory(Phone::class, rand(0, 5))->make());
            $user->emails()->saveMany(factory(Email::class, rand(0, 5))->make());
        });
    }
}
