<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MemberEditRequest;
use App\Http\Requests\Admin\MemberStoreRequest;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @var TeamService $service
     */
    private $service;

    /**
     * UserController constructor.
     * @param TeamService $service
     */
    public function __construct(TeamService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $team = team::orderBy('sort','ASC' )
            ->paginate(config('database.paginator.count'));

        return view(
            'admin.team.index',
            [
                'team' => $team,
            ]
        );
    }

    public function create(Request $request)
    {
        return view('admin.team.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MemberStoreRequest $request
     * @return RedirectResponse
     */
    public function store(MemberStoreRequest $request)
    {
        $member = $this->service->create($request);

        if (!$member) {
            return redirect()->route('admin.team.create', $member)->with(
                'alerts',
                ['error' => 'Не удалось создать сотрудника']
            );
        }
        return redirect()->route('admin.team.edit', $member)->with(
            'alerts',
            ['success' => 'Сотрудник успешно создан']
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Team $member
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Team $member)
    {
        return view('admin.team.edit', ['member' => $member]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MemberEditRequest $request
     * @param Team $member
     * @return RedirectResponse
     */
    public function update(MemberEditRequest $request, Team $member)
    {
        $result = $this->service->update($member, $request);
        if (!$result) {
            return redirect()->route('admin.team.edit', $member)->with(
                'alerts',
                ['error' => 'Не удалось обновить сотрудника']
            );
        }
        return redirect()->route('admin.team.edit', $member)->with(
            'alerts',
            ['success' => 'Сотрудник успешно обновлен']
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Team $member
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Team $member)
    {
        $result = $this->service->delete($member);
        if (!$result) {
            return redirect()->route('admin.team.index', $member)->with(
                'alerts',
                ['error' => 'Не удалось удалить сотрудника']
            );
        }
        return redirect()->route('admin.team.index')->with('alerts', ['success' => 'Сотрудник успешно удален']);
    }
}
