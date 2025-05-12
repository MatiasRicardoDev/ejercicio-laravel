<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EntityTest extends TestCase
{

    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpFaker();
    }

    public function test_entity_belongs_to_category()
    {
        $category = Category::factory()->create();
        $entity = Entity::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $entity->category);
        $this->assertEquals($category->id, $entity->category->id);
    }

    public function test_entity_fillables(){
        $entity = new Entity([
            'api' => 'test api',
            'description' => 'test description',
            'link' => 'https://example.com',
            'category_id' => 1,
        ]);

        $this->assertEquals('test api', $entity->api);
        $this->assertEquals('test description', $entity->description);
        $this->assertEquals('https://example.com', $entity->link);
        $this->assertEquals(1, $entity->category_id);
    }

    public function test_entity_hidden(){
        $entity = Entity::factory()->make();
        $array = $entity->toArray();

        $this->assertArrayNotHasKey('created_at', $array);
        $this->assertArrayNotHasKey('updated_at', $array);
        $this->assertArrayNotHasKey('category_id', $array);
        $this->assertArrayNotHasKey('id', $array);
    }

}
