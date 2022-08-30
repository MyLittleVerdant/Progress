<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ValueEditRequest;
use App\Http\Requests\Admin\ValueStoreRequest;
use App\Models\Values;
use App\Services\ValuesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ValuesController extends Controller
{
    /**
     * @var ValuesService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param ValuesService $service
     */
    public function __construct(ValuesService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        return view('admin.careers.values.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ValueStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ValueStoreRequest $request)
    {
        $value = $this->service->create($request);

        if (!$value) {
            return redirect()->route('admin.careers.values.create', $value)->with('alerts',
                ['error' => 'Не удалось создать ценность']);
        }
        return redirect()->route('admin.careers.values.edit', $value)->with('alerts',
            ['success' => 'Ценность успешно создана']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Values $value
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Values $value)
    {
        return view('admin.careers.values.edit', ['value' => $value]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ValueEditRequest $request
     * @param Values $value
     * @return RedirectResponse
     */
    public function update(ValueEditRequest $request, Values $value)
    {
        $result = $this->service->update($value, $request);
        if (!$result) {
            return redirect()->route('admin.careers.values.edit', $value)->with('alerts',
                ['error' => 'Не удалось обновить ценность']);
        }
        return redirect()->route('admin.careers.values.edit', $value)->with('alerts',
            ['success' => 'Ценность успешно обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Values $value
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Values $value)
    {
        $result = $this->service->delete($value);
        if (!$result) {
            return redirect()->route('admin.careers.index', $value)->with('alerts',
                ['error' => 'Не удалось удалить ценность']);
        }
        return redirect()->route('admin.careers.index')->with('alerts',
            ['success' => 'Ценность успешно удален']);
    }
}
