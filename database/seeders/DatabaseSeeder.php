<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $payments = array(1, 2, 4, 12);
        $interests = array(360, 364, 365);
       
        // \App\Models\Bond::factory(10)->create([

        //     'emission_date' => now()->addDay(rand(1,24)),
        //     'last_turnover_date' => now()->addDay(rand(25, 200)),
        //     'nominal_price' => rand(2500.50, 25000),
        //     'frequency_of_payment' => $payments[rand(0,3)],
        //     'period_calc_interest' =>$payments[rand(0,2)],
        //     'coupon_interest' => rand(0, 100),
        // ]);

        for($i = 0; $i < 10; $i++) { 
            DB::table('bonds')->insert([
                'emission_date' => now()->addDay(rand(1,24)),
                'last_turnover_date' => now()->addDay(rand(25, 200)),
                'nominal_price' => rand(2500.50, 25000),
                'frequency_of_payment' => $payments[rand(0,3)],
                'period_calc_interest' =>$interests[rand(0,2)],
                'coupon_interest' => rand(0, 100),
            ]);
        }   
    }
}
