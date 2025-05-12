<?php

namespace Tests\Unit;


use App\Models\Category;
use App\Models\Entity;
use App\Services\ExternalDataService;
use Tests\TestCase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Mockery;

class ExternalDataServiceTest extends TestCase
{
    protected $entityMock;
    protected function setUp(): void
    {
        parent::setUp();
        $this->entityMock = Mockery::mock(Entity::class);
        $this->entityMock->shouldReceive('create')->andReturn(true);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testStorageDataFromJsonFile()
    {
        $mockJsonFile = [
            'entries' => [
                [
                    'API' => 'Test API',
                    'Description' => 'Test Description',
                    'Link' => 'http://testlink.com',
                    'Category' => 'Test Category'
                ]
            ]
        ];

        File::shouldReceive('get')
            ->with('dummy.json')
            ->once()
            ->andReturn(json_encode($mockJsonFile));

        Category::shouldReceive('where')
            ->with('category', 'Test Category')
            ->once()
            ->andReturnSelf();

        Category::shouldReceive('first')
            ->once()
            ->andReturn(new Category(['id' => 1]));

        config(['app.env' => 'testing']);
        putenv('EXTERNAL_URL=dummy.json');
        putenv('EXTERNAL_TYPE=json_file');

        $service = new ExternalDataService();
        $service->getExternalData();

        $this->assertTrue(true);
    }

    public function testStorageDataFromWebService(){
        $mockWebServiceResponse = [
            'entries' => [
                [
                    'API' => 'Test API',
                    'Description' => 'Test Description',
                    'Link' => 'http://testlink.com',
                    'Category' => 'Test Category'
                ]
            ]
        ];

        Http::shouldReceive('get')
            ->with('https://dummy.com')
            ->once()
            ->andReturn(json_encode($mockWebServiceResponse));

        Category::shouldReceive('where')
            ->with('category', 'Test Category')
            ->once()
            ->andReturnSelf();
        Category::shouldReceive('first')
            ->once()
            ->andReturn(new Category(['id' => 1]));

        config(['app.env' => 'testing']);
        putenv('EXTERNAL_URL=https://dummy.com');
        putenv('EXTERNAL_TYPE=web_service');

        $service = new ExternalDataService();
        $service->getExternalData();

        $this->assertTrue(true);
    }

    public function testNoDataFoundInJsonFile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No data found in the JSON file');

        File::shouldReceive('get')
            ->with('dummy.json')
            ->once()
            ->andReturn(json_encode(['entries' => []]));

        config(['app.env' => 'testing']);
        putenv('EXTERNAL_URL=dummy.json');
        putenv('EXTERNAL_TYPE=json_file');

        $service = new ExternalDataService();
        $service->getExternalData();
    }

    public function testNoDataFoundInWebService()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No data found in the web service');

        Http::shouldReceive('get')
            ->with('https://dummy.com')
            ->once()
            ->andReturn(json_encode(['entries' => []]));

        config(['app.env' => 'testing']);
        putenv('EXTERNAL_URL=https://dummy.com');
        putenv('EXTERNAL_TYPE=web_service');

        $service = new ExternalDataService();
        $service->getExternalData();
    }



}
