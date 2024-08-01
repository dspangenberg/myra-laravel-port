<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentResource;
use App\Models\Document;
use Spatie\QueryBuilder\QueryBuilder;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $documents = QueryBuilder::for(Document::class, $request)
            ->allowedFilters([
            ])
            ->select('*')
            ->with('contact')
            ->with('folder')
            ->orderBy('name')
            ->paginate($this->recordsPerPage, $request->get('page', 1));

        return DocumentResource::collection($documents);
    }
}
