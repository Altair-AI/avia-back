<?php

namespace App\Http\Controllers;

use App\Components\Helper;
use App\Models\Document;
use App\Http\Requests\Document\StoreDocumentRequest;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

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
     * Download PDF file from local storage using document ID
     *
     * @param Document $document
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|RedirectResponse|Response|Redirector
     */
    public function download(Document $document)
    {
        if (Storage::disk('local')->exists("pdf/$document->file")) {
            $path = Storage::disk('local')->path("pdf/$document->file");
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type'=>mime_content_type($path)
            ]);
        }
        return redirect('/404');
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $documents = [];
        if (auth()->user()->role === User::SUPER_ADMIN_ROLE)
            $documents = Document::with('technical_systems')->get();
        if (auth()->user()->role === User::ADMIN_ROLE) {
            // Формирование вложенного массива (иерархии) технических систем доступных администратору
            $technical_systems = Helper::get_technical_system_hierarchy(auth()->user()->organization->id);
            // Получение всех id технических систем или объектов для вложенного массива (иерархии) технических систем
            $technical_system_ids = Helper::get_technical_system_ids($technical_systems, []);
            // Получение списка технических систем для документов доступных администратору
            foreach (Document::all() as $document)
                foreach ($technical_system_ids as $technical_system_id)
                    foreach ($document->technical_systems as $technical_system)
                        if ($technical_system->id == $technical_system_id)
                            array_push($documents, array_merge($document->toArray(), [
                                'technical_systems' => $document->technical_systems
                            ]));
        }
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
        return response()->json(array_merge($document->toArray(), [
            'technical_systems' => $document->technical_systems
        ]));
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
