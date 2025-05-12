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
        // TODO: Implementar la lógica para obtener datos de recursos externos
        if($this->type == 'json_file'){
            $this->storageDataFromJsonFile($this->url);
        }else if($this->type == 'web_service'){
            $this->getDataFromWebService($this->url);
        }else{
            throw new Exception("El tipo de recurso externo no es válido", 1);
        }
    }

    private function  storageDataFromJsonFile($fileUrl){
        $jsonFile = File::get($fileUrl);
        $fileData = json_decode($jsonFile, true);
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
        $fileData = json_decode($webService, true);
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

    private function getCategoryId($categoryName){
        $category = Category::where('category', $categoryName)->first();
        if (!$category) {
            return 0;
        }
        return $category->id;
    }
}
