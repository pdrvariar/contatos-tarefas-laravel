<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Http\Requests\Api\v1\StoreContactRequest;
use App\Http\Requests\Api\v1\UpdateContactRequest;
use App\Http\Resources\Api\v1\ContactResource;
use App\Services\ContactService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    use ApiResponse;

    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'tags']);
        $contacts = $this->contactService->getAllContactsForUser(Auth::user(), 10, $filters);

        return ContactResource::collection($contacts)->additional([
            'status' => 'success',
            'message' => 'Lista de contatos recuperada'
        ]);
    }

    public function store(StoreContactRequest $request)
    {
        $contact = $this->contactService->createContactForUser(Auth::user(), $request->validated());

        return $this->successResponse(
            new ContactResource($contact),
            'Contato criado com sucesso',
            201
        );
    }

    public function show(Contact $contact)
    {
        Gate::authorize('view', $contact);

        return (new ContactResource($contact->load('tags')))->additional([
            'status' => 'success',
            'message' => 'Contato recuperado com sucesso'
        ]);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        Gate::authorize('update', $contact);

        $this->contactService->updateContact($contact, $request->validated());

        return $this->successResponse(
            new ContactResource($contact->load('tags')),
            'Contato atualizado com sucesso'
        );
    }

    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);

        $this->contactService->deleteContact($contact);

        return $this->successResponse(null, 'Contato excluído com sucesso', 204);
    }
}
