<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // 1. Simulasi data (biasanya data ini diambil dari Model / Database)
        $products = [
            ['name' => 'Laptop Asus ROG', 'price' => 15000000, 'stock' => 5],
            ['name' => 'Mouse Logitech', 'price' => 250000, 'stock' => 20],
            ['name' => 'Keyboard Mechanical', 'price' => 750000, 'stock' => 12],
        ];

        // 2. Kirim data ke View menggunakan fungsi view() dan helper compact()
        return view('products.index', compact('products'));
    }
}