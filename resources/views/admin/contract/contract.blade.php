@extends('admin.layouts.app')
@section('content')
    @php
        $requestUrl = [
            'code' => $code
        ];
    @endphp
    <Contract :statuses="{{ $statuses}}" :types="{{ $contractTypes}}"
     :permissionadd="{{ @json_encode($canExistsPermissionAddContract) }}"
     :requestparams="{{ @json_encode($requestUrl) }}"
      />
@endsection
