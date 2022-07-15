@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> {{ __('general.success') }}</h4>
        {{ session()->get('success') }}
    </div>
@endif

@if (session()->has('warning'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i> {{ __('general.warning') }}</h4>
        {{ session()->get('warning') }}
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> {{ __('general.error') }}</h4>
        {{ session()->get('error') }}
    </div>
@endif

@if (session()->has('info'))
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-info"></i> Info</h4>
        {{ session()->get('info') }}
    </div>
@endif

@if (session()->has('message'))
    <div class="callout callout-info">
        {{ session()->get('message') }}
    </div>
@endif

@if ($errors->any())
    <div class="callout callout-danger">
        <h4>{{ __('general.validation_error') }}</h4>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
