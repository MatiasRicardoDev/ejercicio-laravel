<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    public function test_category_has_many_entities()
    {
        $category = Category::factory()->create();
        $entity = Entity::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($category->entities->contains($entity));
    }

    public function test_category_fillables()
    {
        $category = new Category([
            'category' => 'test category',
        ]);

        $this->assertEquals('test category', $category->category);
    }

    public function test_categorry_hidden(){
        $category = Category::factory()->make();
        $array = $category->toArray();

        $this->assertArrayNotHasKey('created_at', $array);
        $this->assertArrayNotHasKey('updated_at', $array);
    }

}
