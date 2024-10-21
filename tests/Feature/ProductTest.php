<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProductTest extends TestCase
{

    public function test_store_product(): void{
        
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                    ->postJson('/api/products', ['name' => 'Product From Test','quantity' => 10,'price'=> 100]);

        $response->assertStatus(201);

    }

}
