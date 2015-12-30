<?php

namespace Gamify\Http\Controllers\Admin;

use Gamify\Http\Requests\UserCreateRequest;
use Gamify\Http\Requests\UserDeleteRequest;
use Gamify\Http\Requests\UserUpdateRequest;
use Gamify\User;
use Gamify\UserProfile;
use Illuminate\Support\Facades\Gate;
use yajra\Datatables\Datatables;

class AdminUserController extends AdminController {

    public function __construct()
    {
        if (Gate::denies('manage-users')) {
            abort(403);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/user/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin/user/show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        return view('admin/user/delete', compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserDeleteRequest $request, User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', trans('admin/user/messages.delete.success'));
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data(Datatables $dataTable)
    {
        // TODO: Disable this query if isn't AJAX

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
