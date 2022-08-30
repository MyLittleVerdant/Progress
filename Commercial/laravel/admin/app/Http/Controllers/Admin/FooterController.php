<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FooterEditRequest;
use App\Models\Footer;
use App\Services\FooterService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    /**
     * @var FooterService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param FooterService $service
     */
    public function __construct(FooterService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $footer = Footer::find(1);

        return view('admin.footer.index', [
            'footer' => $footer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param FooterEditRequest $request
     * @param Footer $footer
     * @return RedirectResponse
     */
    public function update(FooterEditRequest $request, Footer $footer)
    {
        $result = $this->service->update($footer, $request);
        if (!$result) {
            return redirect()->route('admin.footer.index', $footer)->with('alerts',
                ['error' => 'Не удалось обновить футер']);
        }
        return redirect()->route('admin.footer.index', $footer)->with('alerts',
            ['success' => 'Футер успешно обновлен']);
    }

}
