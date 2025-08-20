<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'پیتزا مارگاریتا', 'description' => 'پیتزای ساده و خوشمزه', 'price' => 180000],
            ['name' => 'برگر مخصوص', 'description' => 'برگر با پنیر و سس ویژه', 'price' => 150000],
            ['name' => 'چلوکباب کوبیده', 'description' => 'دو سیخ کوبیده با برنج ایرانی', 'price' => 220000],
        ];

        foreach ($items as $i) {
            Menu::firstOrCreate(['name' => $i['name']], $i);
        }
    }
}
