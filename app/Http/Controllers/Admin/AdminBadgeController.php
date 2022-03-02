<?php
/**
 * Gamify - Gamification platform to implement any serious game mechanic.
 *
 * Copyright (c) 2018 by Paco Orozco <paco@pacoorozco.info>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * Some rights reserved. See LICENSE and AUTHORS files.
 *
 * @author             Paco Orozco <paco@pacoorozco.info>
 * @copyright          2018 Paco Orozco
 * @license            GPL-3.0 <http://spdx.org/licenses/GPL-3.0>
 *
 * @link               https://github.com/pacoorozco/gamify-laravel
 */

namespace Gamify\Http\Controllers\Admin;

use Gamify\Enums\BadgeActuators;
use Gamify\Http\Requests\BadgeCreateRequest;
use Gamify\Http\Requests\BadgeUpdateRequest;
use Gamify\Models\Badge;
use Gamify\Presenters\BadgePresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AdminBadgeController extends AdminController
{
    public function index(): View
    {
        return view('admin.badge.index');
    }

    public function create(): View
    {
        return view('admin.badge.create', [
            'actuators_list' => BadgePresenter::actuatorsSelect(),
            'selected_actuators' => null,
        ]);
    }

    public function store(BadgeCreateRequest $request): RedirectResponse
    {
        try {
            $badge = new Badge([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'required_repetitions' => $request->input('required_repetitions'),
                'active' => $request->input('active'),
                'actuators' => BadgeActuators::fromValue($request->input('actuators')),
            ]);
            $badge->saveOrFail();
        } catch (\Throwable $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/badge/messages.create.error'));
        }

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.create.success'));
    }

    public function show(Badge $badge): View
    {
        return view('admin.badge.show', compact('badge'));
    }

    public function edit(Badge $badge): View
    {
        return view('admin.badge.edit', [
            'badge' => $badge,
            'actuators_list' => BadgePresenter::actuatorsSelect(),
            'selected_actuators' => Arr::pluck($badge->present()->actuators, 'value'),
        ]);
    }

    public function update(BadgeUpdateRequest $request, Badge $badge): RedirectResponse
    {
        try {
            $badge->fill([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'required_repetitions' => $request->input('required_repetitions'),
                'active' => $request->input('active'),
                'actuators' => BadgeActuators::fromValue($request->input('actuators')),
            ])
                ->saveOrFail();
        } catch (\Throwable $exception) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('admin/badge/messages.update.error'));
        }

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.update.success'));
    }

    public function delete(Badge $badge): View
    {
        return view('admin.badge.delete', compact('badge'));
    }

    public function destroy(Badge $badge): RedirectResponse
    {
        try {
            $badge->delete();
        } catch (\Exception $exception) {
            return redirect()->back()
                ->with('error', __('admin/badge/messages.delete.error'));
        }

        return redirect()->route('admin.badges.index')
            ->with('success', __('admin/badge/messages.delete.success'));
    }

    public function data(Datatables $dataTable): JsonResponse
    {
        $badges = Badge::select([
            'id',
            'name',
            'required_repetitions',
            'active',
            'image_url',
        ])->orderBy('name', 'ASC');

        return $dataTable->eloquent($badges)
            ->addColumn('image', function (Badge $badge) {
                return $badge->present()->imageTableThumbnail;
            })
            ->editColumn('active', function (Badge $badge) {
                return $badge->present()->status;
            })
            ->addColumn('actions', function (Badge $badge) {
                return view('admin.partials.actions_dd')
                    ->with('model', 'badges')
                    ->with('id', $badge->id)
                    ->render();
            })
            ->rawColumns(['actions', 'image'])
            ->removeColumn('id', 'image_url')
            ->toJson();
    }
}
