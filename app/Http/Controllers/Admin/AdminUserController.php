<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Http\Requests\UserCreateRequest;
use Gamify\Http\Requests\UserUpdateRequest;
use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use yajra\Datatables\Datatables;

class AdminUserController extends AdminController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin/user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin/user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     * @return Response
     */
    public function store(UserCreateRequest $request)
    {
        $user = User::create($request->all());

        // Insert related models
        $profile = new UserProfile();
        $user->profile()->save($profile);

        return redirect()->route('admin.users.index')
            ->with('success', trans('admin/user/messages.create.success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('admin/user/show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin/user/edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  User $user
     * @return Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->fill($request->all())->save();

        return redirect()->route('admin.users.edit', $user)
            ->with('success', trans('admin/user/messages.edit.success'));
    }

    /**
     * Remove user.
     *
     * @param User $user
     * @return Response
     */
    public function delete(User $user)
    {
        return view('admin/user/delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        // Can't remove myself
        if ($user->id == Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', trans('admin/user/messages.delete.error'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', trans('admin/user/messages.delete.success'));
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @param Request $request
     * @param Datatables $dataTable
     * @return JsonResponse
     */
    public function data(Request $request, Datatables $dataTable)
    {
        // Disable this query if isn't AJAX
        if ( ! $request->ajax()) {
            abort(400);
        }

        $users = User::select([
            'id', 'name', 'username', 'email', 'role'
        ])->orderBy('username', 'ASC');

        return $dataTable->of($users)
            ->addColumn('actions', function (User $user) {
                return view('admin/partials.actions_dd', array(
                    'model' => 'users',
                    'id'    => $user->id
                ))->render();
            })
            ->removeColumn('id')
            ->make(true);
    }
}
