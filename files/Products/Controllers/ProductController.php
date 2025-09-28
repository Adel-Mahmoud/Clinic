<?php

namespace App\Domains\Products\Controllers;

use App\Domains\Products\Models\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function index() {}
    public function create() {}
    public function store(Request $request) {}
    public function edit(Product $Product) {}
    public function update(Request $request, Product $Product) {}
    public function destroy(Product $Product) {}
}
