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
        // 0. Users
        \App\Models\User::create([
            'name' => 'Admin Coffee',
            'username' => 'admin',
            'email' => 'admin@coffee.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Staff Coffee',
            'username' => 'staff',
            'email' => 'staff@coffee.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'staff',
        ]);

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
                    'image' => 'https://images.unsplash.com/photo-1595981267035-7b04ca84a82d?auto=format&fit=crop&q=80&w=400',
                    'description' => 'Cà phê đen nguyên chất pha phin.'
                ]);
                $category->products()->create([
                    'name' => 'Cà phê Sữa',
                    'slug' => Str::slug('Cà phê Sữa'),
                    'price' => 29000,
                    'status' => 'available',
                    'image' => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&q=80&w=400',
                    'description' => 'Cà phê sữa pha phin đậm đà.'
                ]);
            } elseif ($cat == 'Trà trái cây') {
                $category->products()->create([
                    'name' => 'Trà Đào Cam Sả',
                    'slug' => Str::slug('Trà Đào Cam Sả'),
                    'price' => 45000,
                    'status' => 'available',
                    'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?auto=format&fit=crop&q=80&w=400',
                ]);
            } elseif ($cat == 'Bánh ngọt') {
                $category->products()->create([
                    'name' => 'Croissant',
                    'slug' => Str::slug('Croissant'),
                    'price' => 35000,
                    'status' => 'available',
                    'image' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=400',
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
