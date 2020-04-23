@switch($type)
    @case('multi')
    <i class="fa fa-tags" data-toggle="tooltip" title="@lang('admin/question/model.type_list.multi')"></i>
    <span class="hidden">multi</span>
    @break

    @default
    <i class="fa fa-tag" data-toggle="tooltip" title="@lang('admin/question/model.type_list.single')"></i>
    <span class="hidden">single</span>
@endswitch
