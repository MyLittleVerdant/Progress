<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContactEditRequest;
use App\Http\Requests\Admin\ContactStoreRequest;
use App\Models\Contacts;
use App\Services\ContactsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * @var ContactsService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param ContactsService $service
     */
    public function __construct(ContactsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $contacts = Contacts::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.contacts.index',
            [
                'contacts' => $contacts,
            ]
        );
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ContactStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ContactStoreRequest $request)
    {
        $contact = $this->service->create($request);

        if (!$contact) {
            return redirect()->route('admin.contacts.create', $contact)->with(
                'alerts',
                ['error' => 'Не удалось создать контакт']
            );
        }
        return redirect()->route('admin.contacts.edit', $contact)->with(
            'alerts',
            ['success' => 'Контакт успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Contacts $contact
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Contacts $contact)
    {
        return view('admin.contacts.edit', ['contact' => $contact]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ContactEditRequest $request
     * @param Contacts $contact
     * @return RedirectResponse
     */
    public function update(ContactEditRequest $request, Contacts $contact)
    {
        $result = $this->service->update($contact, $request);
        if (!$result) {
            return redirect()->route('admin.contacts.edit', $contact)->with(
                'alerts',
                ['error' => 'Не удалось обновить контакт']
            );
        }
        return redirect()->route('admin.contacts.edit', $contact)->with(
            'alerts',
            ['success' => 'Контакт успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Contacts $contact
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Contacts $contact)
    {
        $result = $this->service->delete($contact);
        if (!$result) {
            return redirect()->route('admin.contacts.index', $contact)->with(
                'alerts',
                ['error' => 'Не удалось удалить клиента']
            );
        }
        return redirect()->route('admin.contacts.index')->with('alerts', ['success' => 'Клиент успешно удален']);
    }
}
