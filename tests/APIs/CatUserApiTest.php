<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CatUser;

class CatUserApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_cat_user()
    {
        $catUser = factory(CatUser::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/cat_users', $catUser
        );

        $this->assertApiResponse($catUser);
    }

    /**
     * @test
     */
    public function test_read_cat_user()
    {
        $catUser = factory(CatUser::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/cat_users/'.$catUser->id
        );

        $this->assertApiResponse($catUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_cat_user()
    {
        $catUser = factory(CatUser::class)->create();
        $editedCatUser = factory(CatUser::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/cat_users/'.$catUser->id,
            $editedCatUser
        );

        $this->assertApiResponse($editedCatUser);
    }

    /**
     * @test
     */
    public function test_delete_cat_user()
    {
        $catUser = factory(CatUser::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/cat_users/'.$catUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/cat_users/'.$catUser->id
        );

        $this->response->assertStatus(404);
    }
}
