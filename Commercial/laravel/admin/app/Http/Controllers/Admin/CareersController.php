<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Careers;
use App\Models\Values;
use App\Services\CareersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    /**
     * @var CareersService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param CareersService $service
     */
    public function __construct(CareersService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $career = Careers::find(1);
        $values = Values::orderBy('sort', 'ASC')
            ->paginate(config('database.paginator.count'));
        return view(
            'admin.careers.index',
            [
                'career' => $career,
                'values' => $values
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Careers $career
     * @return RedirectResponse
     */
    public function update(Request $request, Careers $career)
    {
        $result = $this->service->update($career, $request);
        if (!$result) {
            return redirect()->route('admin.careers.index', $career)->with(
                'alerts',
                ['error' => 'Не удалось обновить описание']
            );
        }
        return redirect()->route('admin.careers.index', $career)->with(
            'alerts',
            ['success' => 'Описание успешно обновлен']
        );
    }
}
