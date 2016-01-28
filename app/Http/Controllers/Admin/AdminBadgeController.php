<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Badge;
use Gamify\Http\Requests\BadgeCreateRequest;
use Gamify\Http\Requests\BadgeUpdateRequest;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;

class AdminBadgeController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/badge/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/badge/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BadgeCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BadgeCreateRequest $request)
    {
        Badge::create($request->all());

        return redirect()->route('admin.badges.index')
            ->with('success', trans('admin/badge/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Badge $badge
     * @return \Illuminate\Http\Response
     */
    public function show(Badge $badge)
    {
        return view('admin/badge/show', compact('badge'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Badge $badge
     * @return \Illuminate\Http\Response
     */
    public function edit(Badge $badge)
    {
        return view('admin/badge/edit', compact('badge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BadgeUpdateRequest $request
     * @param  Badge $badge
     * @return \Illuminate\Http\Response
     */
    public function update(BadgeUpdateRequest $request, Badge $badge)
    {
        $badge->fill($request->all())->save();

        return redirect()->route('admin.badges.index')
            ->with('success', trans('admin/badge/messages.update.success'));
    }

    /**
     * Remove badge page.
     *
     * @param Badge $badge
     * @return \Illuminate\Http\Response
     */
    public function delete(Badge $badge)
    {
        return view('admin/badge/delete', compact('badge'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Badge $badge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Badge $badge)
    {
        $badge->delete();

        return redirect()->route('admin.badges.index')
            ->with('success', trans('admin/badge/messages.delete.success'));
    }

    /**
     * Show a list of all badges formatted for Datatables.
     *
     * @param Request $request
     * @param Datatables $dataTable
     * @return Datatables JsonResponse
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if ( ! $request->ajax()) {
            abort(400);
        }

        $badges = Badge::select([
            'id', 'name', 'amount_needed', 'active'
        ])->orderBy('name', 'ASC');

        return $dataTable->of($badges)
            ->addColumn('image', function (Badge $badge) {
                $badge = Badge::find($badge->id);

                return '<img src="' . $badge->image->url('small') . '" width="64" class="img-thumbnail" />';
            })
            ->editColumn('active', function (Badge $badge) {
                return ($badge->active) ? trans('general.yes') : trans('general.no');
            })
            ->addColumn('actions', function (Badge $badge) {
                return view('admin/partials.actions_dd', array(
                    'model' => 'badges',
                    'id'    => $badge->id
                ))->render();
            })
            ->removeColumn('id')
            ->make(true);
    }
}
