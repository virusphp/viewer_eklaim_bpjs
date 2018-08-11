<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
    	//reset tabel user
    	DB::table('user_akunting')->truncate();

		$admin = App\User::create([
            'username' => 'admin',
            'nama' => 'Admin',
            'password' => bcrypt('password'),
		]);	 
    }
}
