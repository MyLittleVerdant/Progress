<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PatronageEditRequest;
use App\Http\Requests\Admin\PatronageStoreRequest;
use App\Models\Patronages;
use App\Services\PatronagesService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PatronagesController extends Controller
{
    /**
     * @var PatronagesService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param PatronagesService $service
     */
    public function __construct(PatronagesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $patronages = Patronages::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.patronages.index',
            [
                'patronages' => $patronages,
            ]
        );
    }

    public function create()
    {
        return view('admin.patronages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PatronageStoreRequest $request
     * @return RedirectResponse
     */
    public function store(PatronageStoreRequest $request)
    {
        $patronage = $this->service->create($request);

        if (!$patronage) {
            return redirect()->route('admin.patronages.create', $patronage)->with(
                'alerts',
                ['error' => 'Не удалось создать мецената']
            );
        }
        return redirect()->route('admin.patronages.edit', $patronage)->with(
            'alerts',
            ['success' => 'Меценат успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Patronages $patronage
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Patronages $patronage)
    {
        return view('admin.patronages.edit', ['patronage' => $patronage]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param PatronageEditRequest $request
     * @param Patronages $patronage
     * @return RedirectResponse
     */
    public function update(PatronageEditRequest $request, Patronages $patronage)
    {
        $result = $this->service->update($patronage, $request);
        if (!$result) {
            return redirect()->route('admin.patronages.edit', $patronage)->with(
                'alerts',
                ['error' => 'Не удалось обновить мецената']
            );
        }
        return redirect()->route('admin.patronages.edit', $patronage)->with(
            'alerts',
            ['success' => 'Меценат успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Patronages $patronage
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Patronages $patronage)
    {
        $result = $this->service->delete($patronage);
        if (!$result) {
            return redirect()->route('admin.patronages.index', $patronage)->with(
                'alerts',
                ['error' => 'Не удалось удалить мецената']
            );
        }
        return redirect()->route('admin.patronages.index')->with('alerts', ['success' => 'Меценат успешно удален']);
    }

    public function deleteDetailPicture(Patronages $patronage)
    {
        $result = $this->service->deleteDetailPicture($patronage);
        if (!$result) {
            return response()->json([
                'error' => true,
                'msg' => 'Не удалось удалить файл'
            ]);
        }

        return response()->json([
            'error' => false,
            'msg' => 'Файл успешно удален'
        ]);
    }
}
