<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Http\Requests\LevelCreateRequest;
use Gamify\Http\Requests\LevelUpdateRequest;
use Gamify\Level;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;


class AdminLevelController extends AdminController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/level/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/level/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LevelCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LevelCreateRequest $request)
    {
        Level::create($request->all());

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Level $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        return view('admin/level/show', compact('level'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Level $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return view('admin/level/edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LevelUpdateRequest $request
     * @param  Level $level
     * @return \Illuminate\Http\Response
     */
    public function update(LevelUpdateRequest $request, Level $level)
    {
        $level->fill($request->all())->save();

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.update.success'));
    }

    /**
     * Remove level page.
     *
     * @param Level $level
     * @return \Illuminate\Http\Response
     */
    public function delete(Level $level)
    {
        return view('admin/level/delete', compact('level'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Level $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        $level->delete();

        return redirect()->route('admin.levels.index')
            ->with('success', trans('admin/level/messages.delete.success'));
    }

    /**
     * Show a list of all the levels formatted for Datatables.
     *
     * @param Request $request
     * @param Datatables $dataTable
     * @return Datatables JsonResponse
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if (!$request->ajax()) {
            abort(400);
        }

        $levels = Level::select([
            'id',
            'name',
            'amount_needed',
            'active'
        ])->orderBy('amount_needed', 'ASC');

        return $dataTable::of($levels)
            ->addColumn('image', function (Level $level) {
                $level = Level::find($level->id);

                return '<img src="' . $level->image->url('small') . '" width="64" class="img-thumbnail" />';
            })
            ->editColumn('active', function (Level $level) {
                return ($level->active) ? trans('general.yes') : trans('general.no');
            })
            ->addColumn('actions', function (Level $level) {
                return view('admin/partials.actions_dd', array(
                    'model' => 'levels',
                    'id' => $level->id
                ))->render();
            })
            ->removeColumn('id')
            ->make(true);

        return View::make()->render();
    }
}
