<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_page_loads_and_displays_products(): void
    {
        $category = Category::create(['name' => 'التفسير']);
        $product = Product::create([
            'category_id' => $category->id,
            'title' => 'تفسير ابن كثير',
            'author' => 'ابن كثير',
            'price' => 1500,
            'available' => true,
        ]);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('تفسير ابن كثير');
        $response->assertSee('ابن كثير');
    }

    public function test_products_index_filters_by_category(): void
    {
        $category1 = Category::create(['name' => 'التفسير']);
        $category2 = Category::create(['name' => 'الحديث']);

        $product1 = Product::create([
            'category_id' => $category1->id,
            'title' => 'تفسير ابن كثير',
            'author' => 'ابن كثير',
            'price' => 1500,
            'available' => true,
        ]);

        $product2 = Product::create([
            'category_id' => $category2->id,
            'title' => 'صحيح البخاري',
            'author' => 'البخاري',
            'price' => 2000,
            'available' => true,
        ]);

        $response = $this->get(route('products.index', ['category' => $category1->id]));

        $response->assertStatus(200);
        $response->assertSee('تفسير ابن كثير');
        $response->assertDontSee('صحيح البخاري');
    }

    public function test_products_index_filters_by_title(): void
    {
        $category = Category::create(['name' => 'التفسير']);

        $product1 = Product::create([
            'category_id' => $category->id,
            'title' => 'تفسير ابن كثير',
            'author' => 'ابن كثير',
            'price' => 1500,
            'available' => true,
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'title' => 'زاد المعاد',
            'author' => 'ابن القيم',
            'price' => 1800,
            'available' => true,
        ]);

        $response = $this->get(route('products.index', ['title' => 'ابن كثير']));

        $response->assertStatus(200);
        $response->assertSee('تفسير ابن كثير');
        $response->assertDontSee('زاد المعاد');
    }

    public function test_products_index_filters_by_author(): void
    {
        $category = Category::create(['name' => 'التفسير']);

        $product1 = Product::create([
            'category_id' => $category->id,
            'title' => 'تفسير ابن كثير',
            'author' => 'ابن كثير',
            'price' => 1500,
            'available' => true,
        ]);

        $product2 = Product::create([
            'category_id' => $category->id,
            'title' => 'زاد المعاد',
            'author' => 'ابن القيم',
            'price' => 1800,
            'available' => true,
        ]);

        $response = $this->get(route('products.index', ['author' => 'ابن القيم']));

        $response->assertStatus(200);
        $response->assertSee('زاد المعاد');
        $response->assertDontSee('تفسير ابن كثير');
    }
}
