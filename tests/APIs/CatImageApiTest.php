<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CatImage;

class CatImageApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_cat_image()
    {
        $catImage = factory(CatImage::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cat_images', $catImage
        );

        $this->assertApiResponse($catImage);
    }

    /**
     * @test
     */
    public function test_read_cat_image()
    {
        $catImage = factory(CatImage::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/cat_images/'.$catImage->id
        );

        $this->assertApiResponse($catImage->toArray());
    }

    /**
     * @test
     */
    public function test_update_cat_image()
    {
        $catImage = factory(CatImage::class)->create();
        $editedCatImage = factory(CatImage::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cat_images/'.$catImage->id,
            $editedCatImage
        );

        $this->assertApiResponse($editedCatImage);
    }

    /**
     * @test
     */
    public function test_delete_cat_image()
    {
        $catImage = factory(CatImage::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cat_images/'.$catImage->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cat_images/'.$catImage->id
        );

        $this->response->assertStatus(404);
    }
}
