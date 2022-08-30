<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientEditRequest;
use App\Http\Requests\Admin\ClientStoreRequest;
use App\Models\Clients;
use App\Services\ClientsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * @var ClientsService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param ClientsService $service
     */
    public function __construct(ClientsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $clients = Clients::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.clients.index',
            [
                'clients' => $clients,
            ]
        );
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClientStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ClientStoreRequest $request)
    {
        $client = $this->service->create($request);

        if (!$client) {
            return redirect()->route('admin.clients.create', $client)->with(
                'alerts',
                ['error' => 'Не удалось создать клиента']
            );
        }
        return redirect()->route('admin.clients.edit', $client)->with(
            'alerts',
            ['success' => 'Клиент успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Clients $client
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Clients $client)
    {
        return view('admin.clients.edit', ['client' => $client]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ClientEditRequest $request
     * @param Clients $client
     * @return RedirectResponse
     */
    public function update(ClientEditRequest $request, Clients $client)
    {
        $result = $this->service->update($client, $request);
        if (!$result) {
            return redirect()->route('admin.clients.edit', $client)->with(
                'alerts',
                ['error' => 'Не удалось обновить клиента']
            );
        }
        return redirect()->route('admin.clients.edit', $client)->with(
            'alerts',
            ['success' => 'Клиент успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Clients $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Clients $client)
    {
        $result = $this->service->delete($client);
        if (!$result) {
            return redirect()->route('admin.clients.index', $client)->with(
                'alerts',
                ['error' => 'Не удалось удалить клиента']
            );
        }
        return redirect()->route('admin.clients.index')->with('alerts', ['success' => 'Клиент успешно удален']);
    }
}
