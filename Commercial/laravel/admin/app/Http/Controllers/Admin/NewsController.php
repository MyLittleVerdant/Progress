<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsEditRequest;
use App\Http\Requests\Admin\NewsStoreRequest;
use App\Models\News;
use App\Services\NewsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * @var NewsService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param NewsService $service
     */
    public function __construct(NewsService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $news = News::orderBy('date', 'desc')
            ->paginate(config('database.paginator.count'));

        return view('admin.news.index', [
            'news' => $news,
        ]);
    }

    public function create(Request $request)
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsStoreRequest $request
     * @return RedirectResponse
     */
    public function store(NewsStoreRequest $request)
    {
        $news = $this->service->create($request);

        if (!$news) {
            return redirect()->route('admin.news.create', $news)->with('alerts',
                ['error' => 'Не удалось создать новость']);
        }
        return redirect()->route('admin.news.edit', $news)->with('alerts',
            ['success' => 'Новость успешно создана']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\News $news
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NewsEditRequest $request
     * @param News $news
     * @return RedirectResponse
     */
    public function update(NewsEditRequest $request, News $news)
    {
        $result = $this->service->update($news, $request);
        if (!$result) {
            return redirect()->route('admin.news.edit', $news)->with('alerts',
                ['error' => 'Не удалось обновить новость']);
        }
        return redirect()->route('admin.news.edit', $news)->with('alerts',
            ['success' => 'Новость успешно обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\News $news
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(News $news)
    {
        $result =$this->service->delete($news);
        if (!$result) {
            return redirect()->route('admin.news.index', $news)->with('alerts',
                ['error' => 'Не удалось удалить новость']);
        }
        return redirect()->route('admin.news.index')->with('alerts', ['success' => 'Новость успешно удалена']);

    }

}
