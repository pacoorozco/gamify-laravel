<div class="box box-warning">
    <div class="box-header with-border">
        <i class="fa fa-users"></i>
        <h3 class="box-title">Latest registered users</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-sm" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('admin/user/model.username')</th>
                <th>@lang('admin/user/model.name')</th>
                <th>@lang('admin/user/model.email')</th>
                <th>@lang('admin/user/model.created_at')</th>
            </tr>
            </thead>
            @foreach($latest_users as $user)
                <tr>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <!-- /.box-body -->
</div>
