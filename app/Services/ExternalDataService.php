<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Entity;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class ExternalDataService{
    private $url;
    private $type;

    public function __construct()
    {
        $this->url = env('EXTERNAL_URL');
        $this->type = env('EXTERNAL_TYPE');
    }

    public function getExternalData(){

        if($this->type == 'json_file'){
            $this->storageDataFromJsonFile($this->url);
        }
        if($this->type == 'web_service'){
            $this->getDataFromWebService($this->url);
        }
    }

    private function  storageDataFromJsonFile($fileUrl){
        $jsonFile = File::get($fileUrl);
        $fileData = json_decode($jsonFile, true);
        if(!$fileData['entries']){
            throw new Exception('No data found in the JSON file');
        }
        foreach ($fileData['entries'] as $fileItem) {
            $currentCategoryId = $this->getCategoryId($fileItem['Category']);
            if($currentCategoryId > 0){
                Entity::create([
                    'api' => $fileItem['API'],
                    'description' => $fileItem['Description'],
                    'link' => $fileItem['Link'],
                    'category_id' => $currentCategoryId,
                ]);
            }

        }
    }

    private function getDataFromWebService($webServiceUrl){
        $webService = Http::get($webServiceUrl);
        $webData = json_decode($webService, true);
        if(!$webData['entries']){
            throw new Exception('No data found in the web service');
        }
        foreach ($webData['entries'] as $webItem) {
            $currentCategoryId = $this->getCategoryId($webItem['Category']);
            if($currentCategoryId > 0){
                Entity::create([
                    'api' => $webItem['API'],
                    'description' => $webItem['Description'],
                    'link' => $webItem['Link'],
                    'category_id' => $currentCategoryId,
                ]);
            }

        }
    }

    private function getCategoryId($categoryName){
        $category = Category::where('category', $categoryName)->first();
        if (!$category) {
            return 0;
        }
        return $category->id;
    }
}
