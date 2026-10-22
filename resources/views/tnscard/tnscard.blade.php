@extends('tnscard.layout')

@section('content')
    @push('tnscard-head')
        @include('tnscard.modules.meta')
        @include('tnscard.modules.assets')
    @endpush

    @push('tnscard-head-end')
        @foreach($information as $info)
            @include('tnscard.modules.theme')
        @endforeach
    @endpush

    @push('tnscard-body-start')
        @include('tnscard.modules.admin-bar')
        @include('tnscard.modules.share-button')
        @include('tnscard.modules.report-icon')
    @endpush

    @push('tnscard-content')
        @foreach($information as $info)
            @include('tnscard.elements.avatar')
            @include('tnscard.elements.heading')
            @include('tnscard.elements.bio')
        @endforeach
        @include('tnscard.elements.icons')
        @include('tnscard.elements.buttons')
        @yield('content')
        @include('tnscard.modules.footer')
    @endpush
@endsection