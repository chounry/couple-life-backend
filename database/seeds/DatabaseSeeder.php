<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // <<--------------------------- all types
        // user types
        DB::table('user_types')->insert([
            'name' => 'Admin'
        ]);

        DB::table('user_types')->insert([
            'name' => 'Member'
        ]);

        // media typs
        DB::table('media_types')->insert([
            'name' => 'video',
        ]);
        DB::table('media_types')->insert([
            'name' => 'image',
        ]);
        DB::table('media_types')->insert([
            'name' => 'voice',
        ]);
        DB::table('media_types')->insert([
            'name' => 'other',
        ]);

        // chat type 
        DB::table('chat_types')->insert([
            'name' => 'media'
        ]);
        DB::table('chat_types')->insert([
            'name' => 'text'
        ]);
        DB::table('chat_types')->insert([
            'name' => 'stiker'
        ]);
        // all types ---------------------------->>


        // << --------------------------- create users
        $adminId = DB::table('user_types')->where('name','Admin')->first()->id;
        $memberId = DB::table('user_types')->where('name','Member')->first()->id;
        // admin
        $d = strtotime('-11 Years');
        $dob = date('Y-m-d', $d);
        DB::table('users')->insert([
            'user_type_id' => $adminId,
            'first_name' => 'Chounry',
            'last_name' => 'Oun',
            'dob' =>  $dob,
            'gender' => 'male',
            'email' => 'oun.chounry.dev@gamil.com',
            'profile_img' => 'profile/user_default.png',
            'password' => bcrypt('123456'),
        ]);

        $d = strtotime('-10 Years');
        $dob = date('Y-m-d', $d);
        DB::table('users')->insert([
            'user_type_id' => $memberId,
            'first_name' => 'Jonh',
            'last_name' => 'Kenny',
            'dob' =>  $dob,
            'gender' => 'male',
            'email' => 'oun.chounry.kh@gamil.com',
            'profile_img' => 'profile/user_default.png',
            'password' => bcrypt('123456'),
        ]);

        $d = strtotime('-12 Years');
        $dob = date('Y-m-d', $d);
        DB::table('users')->insert([
            'user_type_id' => $memberId,
            'first_name' => 'Iha',
            'last_name' => 'Men',
            'dob' =>  $dob,
            'gender' => 'female',
            'email' => 'oun.chounry@gamil.com',
            'profile_img' => 'profile/user_default.png',
            'password' => bcrypt('123456'),
        ]);
        //  create user ---------------------------->>
    }
}
