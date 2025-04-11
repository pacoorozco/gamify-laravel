<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="bi bi-people-fill"></i>
            Latest registered users
        </h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="bi bi-caret-up-fill"></i>
            </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('admin/user/model.username') }}</th>
                <th>{{ __('admin/user/model.name') }}</th>
                <th>{{ __('admin/user/model.email') }}</th>
                <th>{{ __('admin/user/model.created_at') }}</th>
            </tr>
            </thead>
            @foreach($latest_users as $user)
                <tr>
                    <td>
                        <a href="{{ route('admin.users.show', $user) }}">
                            {{ $user->username }}
                            {{ $user->present()->adminLabel() }}
                        </a>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
