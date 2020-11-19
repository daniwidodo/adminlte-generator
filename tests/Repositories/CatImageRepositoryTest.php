<?php namespace Tests\Repositories;

use App\Models\CatImage;
use App\Repositories\CatImageRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CatImageRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CatImageRepository
     */
    protected $catImageRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->catImageRepo = \App::make(CatImageRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_cat_image()
    {
        $catImage = factory(CatImage::class)->make()->toArray();

        $createdCatImage = $this->catImageRepo->create($catImage);

        $createdCatImage = $createdCatImage->toArray();
        $this->assertArrayHasKey('id', $createdCatImage);
        $this->assertNotNull($createdCatImage['id'], 'Created CatImage must have id specified');
        $this->assertNotNull(CatImage::find($createdCatImage['id']), 'CatImage with given id must be in DB');
        $this->assertModelData($catImage, $createdCatImage);
    }

    /**
     * @test read
     */
    public function test_read_cat_image()
    {
        $catImage = factory(CatImage::class)->create();

        $dbCatImage = $this->catImageRepo->find($catImage->id);

        $dbCatImage = $dbCatImage->toArray();
        $this->assertModelData($catImage->toArray(), $dbCatImage);
    }

    /**
     * @test update
     */
    public function test_update_cat_image()
    {
        $catImage = factory(CatImage::class)->create();
        $fakeCatImage = factory(CatImage::class)->make()->toArray();

        $updatedCatImage = $this->catImageRepo->update($fakeCatImage, $catImage->id);

        $this->assertModelData($fakeCatImage, $updatedCatImage->toArray());
        $dbCatImage = $this->catImageRepo->find($catImage->id);
        $this->assertModelData($fakeCatImage, $dbCatImage->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_cat_image()
    {
        $catImage = factory(CatImage::class)->create();

        $resp = $this->catImageRepo->delete($catImage->id);

        $this->assertTrue($resp);
        $this->assertNull(CatImage::find($catImage->id), 'CatImage should not exist in DB');
    }
}
