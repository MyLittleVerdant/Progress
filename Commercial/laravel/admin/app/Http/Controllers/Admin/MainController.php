<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MainEditRequest;
use App\Models\Main;
use App\Services\MainService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * @var MainService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $main = Main::find(1);
        return view('admin.main.index', [
            'main' => $main,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MainEditRequest $request
     * @param Main $main
     * @return RedirectResponse
     */
    public function update(MainEditRequest $request, Main $main)
    {
        $result = $this->service->update($main, $request);
        if (!$result) {
            return redirect()->route('admin.main.index', $main)->with('alerts',
                ['error' => 'Не удалось обновить видео']);
        }
        return redirect()->route('admin.main.index', $main)->with('alerts',
            ['success' => 'Видео успешно обновлено']);
    }

}
