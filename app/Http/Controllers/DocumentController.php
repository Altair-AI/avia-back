<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    /**
     * Create a new DocumentController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $documents = [];
        if (auth()->user()->role == User::SUPER_ADMIN_ROLE)
            $documents = Document::all();
        if (auth()->user()->role == User::ADMIN_ROLE)
            $documents = Document::all();
        return response()->json($documents);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDocumentRequest $request
     * @return JsonResponse|null
     */
    public function store(StoreDocumentRequest $request)
    {
        $validated = $request->validated();
        $document = Document::create($validated);
        return response()->json($document);
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     * @return JsonResponse
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDocumentRequest $request
     * @param Document $document
     * @return JsonResponse|null
     */
    public function update(UpdateDocumentRequest $request, Document $document)
    {
        $validated = $request->validated();
        $document->fill($validated);
        $document->save();
        return response()->json($document);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Document $document
     * @return JsonResponse|null
     */
    public function destroy(Document $document)
    {
        $document->delete();
        return response()->json(['id' => $document->id], 200);
    }
}
