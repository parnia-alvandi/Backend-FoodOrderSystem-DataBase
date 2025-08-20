<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Menu, Discount};
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //صدا زدن Seederهای جدا
        $this->call([
            AdminUserSeeder::class,
            MenuSeeder::class,
        ]);

        // داده های اولیه به صورت پیش فرض
        User::updateOrCreate(['email'=>'admin@example.com'], [
            'name'=>'Admin',
            'password'=>Hash::make('password'),
            'role'=>'admin'
        ]);

        Menu::firstOrCreate(['name'=>'Pizza Margherita'], [
            'description'=>'Classic',
            'price'=>250000
        ]);

        Menu::firstOrCreate(['name'=>'Chicken Burger'], [
            'description'=>'Crispy',
            'price'=>180000
        ]);

        Discount::firstOrCreate(['code'=>'OFF20'], [
            'type'=>'percent',
            'value'=>20,
            'usage_limit'=>100,
            'active'=>true
        ]);
    }
}
