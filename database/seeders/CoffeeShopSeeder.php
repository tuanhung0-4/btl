<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CoffeeShopSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories
        $categories = ['Cà phê', 'Trà trái cây', 'Đá xay', 'Bánh ngọt'];
        foreach ($categories as $cat) {
            $category = Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
                'description' => "Các loại $cat thơm ngon tuyệt vời."
            ]);

            // 2. Products
            if ($cat == 'Cà phê') {
                $category->products()->create([
                    'name' => 'Cà phê Đen',
                    'slug' => Str::slug('Cà phê Đen'),
                    'price' => 25000,
                    'status' => 'available',
                    'description' => 'Cà phê đen nguyên chất pha phin.'
                ]);
                $category->products()->create([
                    'name' => 'Cà phê Sữa',
                    'slug' => Str::slug('Cà phê Sữa'),
                    'price' => 29000,
                    'status' => 'available',
                    'description' => 'Cà phê sữa pha phin đậm đà.'
                ]);
            } elseif ($cat == 'Trà trái cây') {
                $category->products()->create([
                    'name' => 'Trà Đào Cam Sả',
                    'slug' => Str::slug('Trà Đào Cam Sả'),
                    'price' => 45000,
                    'status' => 'available',
                ]);
            }
        }

        // 3. Tables
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'name' => "Bàn $i",
                'status' => 'empty',
                'description' => "Bàn khu vực tầng " . ($i <= 5 ? '1' : '2')
            ]);
        }
    }
}
