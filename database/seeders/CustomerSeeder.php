<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()
            ->count(5)
            ->hasInvoices(10)
            ->create();

        Customer::factory()
            ->count(3)
            ->hasInvoices(6)
            ->create();

        Customer::factory()
            ->count(8)
            ->hasInvoices(3)
            ->create();

        Customer::factory()
            ->count(4)
            ->create();
    }
}
