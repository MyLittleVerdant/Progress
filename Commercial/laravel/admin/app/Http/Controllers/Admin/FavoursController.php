<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FavourEditRequest;
use App\Http\Requests\Admin\FavourStoreRequest;
use App\Models\Favours;
use App\Services\FavoursService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoursController extends Controller
{
    /**
     * @var FavoursService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param FavoursService $service
     */
    public function __construct(FavoursService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $favours = Favours::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.favours.index',
            [
                'favours' => $favours,
            ]
        );
    }

    public function create()
    {
        return view('admin.favours.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FavourStoreRequest $request
     * @return RedirectResponse
     */
    public function store(FavourStoreRequest $request)
    {
        $favour = $this->service->create($request);

        if (!$favour) {
            return redirect()->route('admin.favours.create', $favour)->with(
                'alerts',
                ['error' => 'Не удалось создать услугу']
            );
        }
        return redirect()->route('admin.favours.edit', $favour)->with(
            'alerts',
            ['success' => 'Услуга успешно создана']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Favours $favour
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Favours $favour)
    {
        return view('admin.favours.edit', ['favour' => $favour]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @paramServiceEditRequest $request
     * @param Favours $favour
     * @return RedirectResponse
     */
    public function update(FavourEditRequest $request, Favours $favour)
    {
        $result = $this->service->update($favour, $request);
        if (!$result) {
            return redirect()->route('admin.favours.edit', $favour)->with(
                'alerts',
                ['error' => 'Не удалось обновить услугу']
            );
        }
        return redirect()->route('admin.favours.edit', $favour)->with(
            'alerts',
            ['success' => 'Услуга успешно обновлена']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Favours $favour
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Favours $favour)
    {
        $result = $this->service->delete($favour);
        if (!$result) {
            return redirect()->route('admin.favours.index', $favour)->with(
                'alerts',
                ['error' => 'Не удалось удалить услугу']
            );
        }
        return redirect()->route('admin.favours.index')->with('alerts', ['success' => 'Услуга успешно удалена']);
    }
}
