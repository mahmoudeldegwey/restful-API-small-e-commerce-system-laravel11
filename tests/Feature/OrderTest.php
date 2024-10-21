<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\{User,Product};

class OrderTest extends TestCase
{

    public function test_validation_store_order(){
        
        $user    = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/orders', []);

        $response->assertStatus(422);
    }

    public function test_store_order(): void{

        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
                    ->postJson('/api/orders', [
                        'products' => 
                            [
                                [
                                'product_id' => $product->id,
                                'quantity' => 1,
                                'price' => $product->price
                                ]
                            ]   
                        ]
                    );
        //dd($response);
        //dd;
        $response->assertStatus(201);

    }

}
