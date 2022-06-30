<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Repository\OrderRepositoryInterface;

class OrderController extends Controller
{
    protected $repository;

    public function __construct(OrderRepositoryInterface $repository) 
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $orders = $this->repository->get();
        
        return response()->json($orders);
    }

    public function store(OrderRequest $request)
    {
        $request->merge(['date' => date("Y-m-d")]);

        $order = $this->repository->store($request->all());
        
        return response()->json($order);
    }

    public function show($id)
    {
        $order = $this->repository->find($id , ['customer' , 'products']);
        
        return response()->json($order);
    }

    public function destroy($id)
    {
        return response()->json( $this->repository->destroy($id));
    }
}
