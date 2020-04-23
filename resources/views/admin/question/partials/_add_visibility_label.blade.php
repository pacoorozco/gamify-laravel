@isset($prepend){{ $prepend }}@endisset

@if($hidden)<span class="label label-default">@lang('admin/question/model.hidden_yes')</span>@endif

@isset($append){{ $append }}@endisset
