@if(file_exists(base_path("/assets/tnscard/images/avatar.png" )))
    <img class="mb-5" src="{{ asset('/assets/tnscard/images/avatar.png') }}"  style="width: 150px;">
@else
    <img class="mb-5" src="{{ asset('/assets/tnscard/images/avatar@2x.png') }}">
@endif
