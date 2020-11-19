<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CatCategory;

class CatCategoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_cat_category()
    {
        $catCategory = factory(CatCategory::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cat_categories', $catCategory
        );

        $this->assertApiResponse($catCategory);
    }

    /**
     * @test
     */
    public function test_read_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/cat_categories/'.$catCategory->id
        );

        $this->assertApiResponse($catCategory->toArray());
    }

    /**
     * @test
     */
    public function test_update_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();
        $editedCatCategory = factory(CatCategory::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cat_categories/'.$catCategory->id,
            $editedCatCategory
        );

        $this->assertApiResponse($editedCatCategory);
    }

    /**
     * @test
     */
    public function test_delete_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cat_categories/'.$catCategory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cat_categories/'.$catCategory->id
        );

        $this->response->assertStatus(404);
    }
}
