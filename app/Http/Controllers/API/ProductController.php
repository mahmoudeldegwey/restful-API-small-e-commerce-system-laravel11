<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pipeline\Pipeline;
use App\Http\Resources\ProductResource;
use App\Filters\{ProductNameFilter,PriceRangeFilter};
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    // Cache key for the product list
    protected $cacheKey = 'products_list';

    public function index(Request $request) : JsonResource {
        try {
            // Check if the product list is already cached
            $data = Cache::remember($this->cacheKey, 60 * 60, function () use ($request) {
                $query = Product::select('id','name','price','quantity');

                // Apply the filters through the pipeline
                return app(Pipeline::class)
                    ->send($query)
                    ->through([
                        ProductNameFilter::class,
                        PriceRangeFilter::class,
                    ])
                    ->thenReturn()
                    ->paginate(10);
            });
        } catch (\Exception $e) {
            return response()->json(["error" => true, "message" => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ProductResource::collection($data);
    }

    public function show(Product $product) : JsonResource {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request) { 
        try { 
            // Create a new product
            $product = Product::create($request->validated());

            // Clear the cache after adding a new product
            Cache::forget($this->cacheKey);
        } catch (\Exception $e) { 
            return response()->json(['error' => true, "message" => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ProductResource($product);
    }

    public function update(Product $product, ProductRequest $request) : JsonResponse { 
        try {
            // Update the product
            $product->update($request->validated());

            // Clear the cache after updating the product
            Cache::forget($this->cacheKey);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['error' => false, 'message' => 'Updated Successfully'], JsonResponse::HTTP_OK);
    }

    public function destroy(Product $product) : JsonResponse {
        try {
            // Delete the product
            $product->delete();

            // Clear the cache after deleting the product
            Cache::forget($this->cacheKey);
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['error' => false, 'message' => 'Deleted Successfully'], JsonResponse::HTTP_OK);
    }
}
