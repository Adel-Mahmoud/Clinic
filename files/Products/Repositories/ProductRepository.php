<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Products\Models\Product;

class ProductRepository
{
    public function all() { return Product::all(); }
    public function find($id) { return Product::find($id); }
    public function create(array $data) { return Product::create($data); }
    public function update(Product $model, array $data) { return $model->update($data); }
    public function delete(Product $model) { return $model->delete(); }
}
