<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\{Order,OrderProduct,Product};
use App\Http\Resources\OrderResource;
use App\Http\Requests\OrderRequest;
use App\Mail\NewOrderCreatedEmail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth;

class OrderController extends Controller
{
	public function index(Request $request) : JsonResource {
        try {

            $data = Order::with('products')->select('id','order_number','total_price','product_count','status')
            	->orderBy('orders.id','DESC')
            	->paginate(10);

        } catch (\Exception $e) { 
            return response()->json(["error" => true , "message" => $e->getMessage()] , JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return OrderResource::collection($data);
    }

    public function store(OrderRequest $request) : JsonResource{
    	
    	try {
    		
            DB::beginTransaction();

    		$products = [];
    		$total_price = 0;
    	
    		foreach (collect($request->products) as $product) {

    			$total_price += $product['price'] * $product['quantity'];

    			$products[] = [
    				'product_id' => $product['product_id'],
    				'product_quantity' => $product['quantity']
    			];

                Product::where('id',$product['product_id'])->decrement('quantity', $product['quantity']);
    		}
    		
			$order = Order::create([
    			'order_number' => 'OR'.strtotime(date('h:m:i')),
    			'status' => 'pending',
    			'product_count' => count($request->products),
    			'total_price' => $total_price,
                'user_id' => Auth::user()->id
    		]);

    		$order->products()->sync($products);
            
            DB::commit();

            Mail::to('test@yahoo.com')->send(new NewOrderCreatedEmail($order));

    	} catch (\Exception $e) {
    		DB::rollback();
    		return response()->json(["error" => true , "message" => $e->getMessage()] , JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
    	}

    	return new OrderResource($order);
    }
}
