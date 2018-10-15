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
    	DB::table('user_login_sep')->truncate();

		$admin = App\User::create([
            'kd_pegawai' => 'virusphp',
            'nama_pegawai' => 'Slamet Sugandi',
            'role' => 'Developer',
            'password' => bcrypt('password'),
		]);	 
    }
}
