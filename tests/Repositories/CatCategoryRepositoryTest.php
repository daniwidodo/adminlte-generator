<?php namespace Tests\Repositories;

use App\Models\CatCategory;
use App\Repositories\CatCategoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CatCategoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CatCategoryRepository
     */
    protected $catCategoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->catCategoryRepo = \App::make(CatCategoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_cat_category()
    {
        $catCategory = factory(CatCategory::class)->make()->toArray();

        $createdCatCategory = $this->catCategoryRepo->create($catCategory);

        $createdCatCategory = $createdCatCategory->toArray();
        $this->assertArrayHasKey('id', $createdCatCategory);
        $this->assertNotNull($createdCatCategory['id'], 'Created CatCategory must have id specified');
        $this->assertNotNull(CatCategory::find($createdCatCategory['id']), 'CatCategory with given id must be in DB');
        $this->assertModelData($catCategory, $createdCatCategory);
    }

    /**
     * @test read
     */
    public function test_read_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();

        $dbCatCategory = $this->catCategoryRepo->find($catCategory->id);

        $dbCatCategory = $dbCatCategory->toArray();
        $this->assertModelData($catCategory->toArray(), $dbCatCategory);
    }

    /**
     * @test update
     */
    public function test_update_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();
        $fakeCatCategory = factory(CatCategory::class)->make()->toArray();

        $updatedCatCategory = $this->catCategoryRepo->update($fakeCatCategory, $catCategory->id);

        $this->assertModelData($fakeCatCategory, $updatedCatCategory->toArray());
        $dbCatCategory = $this->catCategoryRepo->find($catCategory->id);
        $this->assertModelData($fakeCatCategory, $dbCatCategory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_cat_category()
    {
        $catCategory = factory(CatCategory::class)->create();

        $resp = $this->catCategoryRepo->delete($catCategory->id);

        $this->assertTrue($resp);
        $this->assertNull(CatCategory::find($catCategory->id), 'CatCategory should not exist in DB');
    }
}
