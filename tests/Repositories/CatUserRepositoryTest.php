<?php namespace Tests\Repositories;

use App\Models\CatUser;
use App\Repositories\CatUserRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CatUserRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CatUserRepository
     */
    protected $catUserRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->catUserRepo = \App::make(CatUserRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_cat_user()
    {
        $catUser = factory(CatUser::class)->make()->toArray();

        $createdCatUser = $this->catUserRepo->create($catUser);

        $createdCatUser = $createdCatUser->toArray();
        $this->assertArrayHasKey('id', $createdCatUser);
        $this->assertNotNull($createdCatUser['id'], 'Created CatUser must have id specified');
        $this->assertNotNull(CatUser::find($createdCatUser['id']), 'CatUser with given id must be in DB');
        $this->assertModelData($catUser, $createdCatUser);
    }

    /**
     * @test read
     */
    public function test_read_cat_user()
    {
        $catUser = factory(CatUser::class)->create();

        $dbCatUser = $this->catUserRepo->find($catUser->id);

        $dbCatUser = $dbCatUser->toArray();
        $this->assertModelData($catUser->toArray(), $dbCatUser);
    }

    /**
     * @test update
     */
    public function test_update_cat_user()
    {
        $catUser = factory(CatUser::class)->create();
        $fakeCatUser = factory(CatUser::class)->make()->toArray();

        $updatedCatUser = $this->catUserRepo->update($fakeCatUser, $catUser->id);

        $this->assertModelData($fakeCatUser, $updatedCatUser->toArray());
        $dbCatUser = $this->catUserRepo->find($catUser->id);
        $this->assertModelData($fakeCatUser, $dbCatUser->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_cat_user()
    {
        $catUser = factory(CatUser::class)->create();

        $resp = $this->catUserRepo->delete($catUser->id);

        $this->assertTrue($resp);
        $this->assertNull(CatUser::find($catUser->id), 'CatUser should not exist in DB');
    }
}
