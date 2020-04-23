@isset($prepend){{ $prepend }}@endisset

@switch($status)
    @case('draft')
    <span class="label label-default">@lang('admin/question/model.status_list.draft')</span>
    @break

    @case('publish')
    <span class="label label-success">@lang('admin/question/model.status_list.publish')</span>
    @break

    @default
    <span class="label label-warning">@lang('admin/question/model.status_list.unpublish')</span>
@endswitch

@isset($append){{ $append }}@endisset
