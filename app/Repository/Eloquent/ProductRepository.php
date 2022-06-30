<?php 
namespace App\Repository\Eloquent;

use App\Repository\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface {
    
    protected $model;

    public function __construct(Product $model) {
        $this->model = $model;

    }
}