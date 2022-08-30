<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WhaleEditRequest;
use App\Http\Requests\Admin\WhaleStoreRequest;
use App\Models\Whales;
use App\Services\WhalesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WhalesController extends Controller
{
    /**
     * @var WhalesService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param WhalesService $service
     */
    public function __construct(WhalesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $whales = Whales::query()
            ->paginate(config('database.paginator.count'));

        return view('admin.whales.index', [
            'whales' => $whales,
        ]);
    }

    public function create()
    {
        return view('admin.whales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param WhaleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WhaleStoreRequest $request)
    {
        $whale = $this->service->create($request);

        if (!$whale) {
            return redirect()->route('admin.whales.create', $whale)->with('alerts',
                ['error' => 'Не удалось создать клиента']);
        }
        return redirect()->route('admin.whales.edit', $whale)->with('alerts',
            ['success' => 'Клиент успешно создан']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Whales $whale
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Whales $whale)
    {
        return view('admin.whales.edit', ['whale' => $whale]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param WhaleEditRequest $request
     * @param Whales $whale
     * @return RedirectResponse
     */
    public function update(WhaleEditRequest $request, Whales $whale)
    {
        $result = $this->service->update($whale, $request);
        if (!$result) {
            return redirect()->route('admin.whales.edit', $whale)->with('alerts',
                ['error' => 'Не удалось обновить клиента']);
        }
        return redirect()->route('admin.whales.edit', $whale)->with('alerts',
            ['success' => 'Кит успешно обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Whales $whale
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Whales $whale)
    {
        $result = $this->service->delete($whale);
        if (!$result) {
            return redirect()->route('admin.whales.index', $whale)->with('alerts',
                ['error' => 'Не удалось удалить кита']);
        }
        return redirect()->route('admin.whales.index')->with('alerts', ['success' => 'Кит успешно удален']);
    }
}
