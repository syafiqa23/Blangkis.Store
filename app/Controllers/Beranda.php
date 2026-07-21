<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Beranda extends BaseController
{
    public function index(): string
    {
        $productModel = new ProductModel();
        $products = $productModel->getWithCategory(); // atau ->findAll() jika tidak punya getWithCategory()

        return view('home', ['product' => $products]);
    }
}
