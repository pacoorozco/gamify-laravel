@extends('layouts.master')

{{-- Web site Title --}}
@section('title', __('site.home'))

{{-- Content Header --}}
@section('header', __('site.home'))

{{-- Breadcrumbs --}}
@section('breadcrumbs')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- Welcome -->
            <div class="card">
                <h4 class="card-header"><i class="bi bi-rocket"></i> Welcome to <strong>gamify</strong> v3</h4>

                <div class="card-body">
                    <p>Mauris pulvinar sollicitudin ligula, eu auctor mi iaculis vel. Mauris a nulla eleifend,
                        imperdiet
                        mi at, molestie augue. Cras vulputate dui eget justo tristique imperdiet.</p>
                    <p>Sed posuere nec felis id mattis. Nunc in tempor tortor, vel tristique eros. Praesent eu
                        ligula
                        sapien. Etiam nisl mi, hendrerit nec nibh sit amet, lacinia laoreet risus. <b>Quisque
                            bibendum,
                            felis non tincidunt porttitor, odio dui finibus turpis, ut bibendum urna quam vitae
                            nisi.</b></p>
                    <ul>
                        <li>Nullam semper sed diam eu placerat.</li>
                        <li>Phasellus pharetra rhoncus tristique.</li>
                        <li>Aenean purus quam, porta ac blandit eget,</li>
                    </ul>
                    <p>Nullam condimentum finibus leo, eu bibendum libero dignissim sed. Sed mattis turpis eu dolor
                        auctor, sit amet cursus felis ultricies. Sed ac magna felis. Quisque nisi mi, euismod vel
                        tortor
                        eu, ullamcorper tincidunt eros. Cras vitae vehicula tortor. Curabitur a mi commodo, finibus
                        dolor vel, dictum mauris.</p>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- ./welcome -->

            <!-- Pending questions -->
            <div class="card">
                <h4 class="card-header"><i class="bi bi-controller"></i> Play with us </h4>

                <div class="card-body">
                    @include('home._questions')
                </div>
            </div>
            <!-- ./pending questions -->

        </div>


        <div class="col-md-6">

            <!-- Ranking -->
            <div class="card">
                <h4 class="card-header"><i class="bi bi-trophy"></i> Ranking </h4>

                <div class="card-body">
                    @include('home._ranking')
                </div>
            </div>
            <!-- ./ranking -->

        </div>
    </div>
@endsection
