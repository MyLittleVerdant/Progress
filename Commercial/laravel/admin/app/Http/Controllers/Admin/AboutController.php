<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AboutEditRequest;
use App\Http\Requests\Admin\AboutStoreRequest;
use App\Models\About;
use App\Services\AboutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * @var AboutService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param AboutService $service
     */
    public function __construct(AboutService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $about = About::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.about.index',
            [
                'about' => $about,
            ]
        );
    }

    public function create()
    {
        return view('admin.about.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AboutStoreRequest $request
     * @return RedirectResponse
     */
    public function store(AboutStoreRequest $request)
    {
        $aboutBlock = $this->service->create($request);

        if (!$aboutBlock) {
            return redirect()->route('admin.about.create', $aboutBlock)->with(
                'alerts',
                ['error' => 'Не удалось создать блок']
            );
        }
        return redirect()->route('admin.about.edit', $aboutBlock)->with(
            'alerts',
            ['success' => 'Блок успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\About $aboutBlock
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(About $aboutBlock)
    {
        return view('admin.about.edit', ['aboutBlock' => $aboutBlock]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AboutEditRequest $request
     * @param About $aboutBlock
     * @return RedirectResponse
     */
    public function update(AboutEditRequest $request, About $aboutBlock)
    {
        $result = $this->service->update($aboutBlock, $request);
        if (!$result) {
            return redirect()->route('admin.about.edit', $aboutBlock)->with(
                'alerts',
                ['error' => 'Не удалось обновить блок']
            );
        }
        return redirect()->route('admin.about.edit', $aboutBlock)->with(
            'alerts',
            ['success' => 'Блок успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\About $aboutBlock
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(About $aboutBlock)
    {
        $result = $this->service->delete($aboutBlock);
        if (!$result) {
            return redirect()->route('admin.about.index', $aboutBlock)->with(
                'alerts',
                ['error' => 'Не удалось удалить блок']
            );
        }
        return redirect()->route('admin.about.index')->with('alerts', ['success' => 'Блок успешно удален']);
    }
}
