<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function getEntityByCategory($category){
        $entities = Entity::with(['category'])->where('category_id', $category)->get();

        return response()->json([
            'success' => true,
            'data' => $entities,
        ]);
    }
}
