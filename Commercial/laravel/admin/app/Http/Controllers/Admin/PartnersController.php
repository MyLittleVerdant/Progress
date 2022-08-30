<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PartnerEditRequest;
use App\Http\Requests\Admin\PartnerStoreRequest;
use App\Models\Partners;
use App\Services\PartnersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    /**
     * @var PartnersService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param PartnersService $service
     */
    public function __construct(PartnersService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $partners = Partners::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.partners.index',
            [
                'partners' => $partners,
            ]
        );
    }

    public function create(Request $request)
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PartnerStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PartnerStoreRequest $request)
    {
        $partner = $this->service->create($request);

        if (!$partner) {
            return redirect()->route('admin.partners.create', $partner)->with(
                'alerts',
                ['error' => 'Не удалось создать партнёра']
            );
        }
        return redirect()->route('admin.partners.edit', $partner)->with(
            'alerts',
            ['success' => 'Партнёр успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Partners $partner
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Partners $partner)
    {
        return view('admin.partners.edit', ['partner' => $partner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PartnerEditRequest $request
     * @param Partners $partner
     * @return RedirectResponse
     */
    public function update(PartnerEditRequest $request, Partners $partner)
    {
        $result = $this->service->update($partner, $request);
        if (!$result) {
            return redirect()->route('admin.partners.edit', $partner)->with(
                'alerts',
                ['error' => 'Не удалось обновить партнёра']
            );
        }
        return redirect()->route('admin.partners.edit', $partner)->with(
            'alerts',
            ['success' => 'Партнёр успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Partners $partner
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Partners $partner)
    {
        $result = $this->service->delete($partner);
        if (!$result) {
            return redirect()->route('admin.partners.index', $partner)->with(
                'alerts',
                ['error' => 'Не удалось удалить партнёра']
            );
        }
        return redirect()->route('admin.partners.index')->with('alerts', ['success' => 'Партнёр успешно удален']);
    }
}
