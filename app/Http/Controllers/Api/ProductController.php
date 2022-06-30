<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $respository;

    public function __construct(ProductRepositoryInterface $respository)
    {
        $this->respository = $respository;
    }

    public function index()
    {
        $products = $this->respository->get(['category']);
        return response()->json($products);
    }

    public function show($id)
    {
        $product = $this->respository->find($id , ['category']);
        return response()->json($product);
    }
}
