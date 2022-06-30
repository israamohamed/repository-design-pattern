<?php 
namespace App\Repository\Eloquent;

use App\Repository\OrderRepositoryInterface;
use App\Models\Order;
use DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface {

    protected $model;
    protected $product_repository;

    public function __construct(Order $model , ProductRepository $product_repository) {
        $this->model = $model;
        $this->product_repository = $product_repository;
    }

    //override store method
    public function store(array $data) {

        DB::beginTransaction();

        $order = Order::create($data);
        foreach($data['products'] as $item)
        {
            //find product
            $product = $this->product_repository->find($item['id']);
            //check quantity
            if($product->quantity <  $item['quantity']) //stock < required
            {
                DB::rollBack();
                return  $product->name . ' has only ' . $product->quantity . ' in the stock';
            }
            //attach product to order
            $order->products()->attach($item['id'] , [
                'price' => $product->selling_price,
                'quantity' => $item['quantity'],
            ]);
            //update product quantity in stock
            $this->product_repository->update( $item['id'],  ['quantity' => $product->quantity - $item['quantity']   ]);
        }

        DB::commit();
        return $this->find($order->id, ['customer' , 'products']);

    }

}