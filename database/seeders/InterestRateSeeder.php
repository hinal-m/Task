<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Interest_rate;
use Illuminate\Database\Seeder;

class InterestRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $interest = [
            [
                'amount' => '500',
                'interest_rate' => '5'
            ],
            [
                'amount' => '1000',
                'interest_rate' => '10'
            ],
            [
                'amount' => '1001',
                'interest_rate' => '15'
            ],
        ];
        Interest::insert($interest);
    }
}
