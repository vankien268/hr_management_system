@extends('admin.layouts.app')
@section('content')
    {{-- <quote :types="{{ $contractTypes}}" :users="{{ $users}}" :customers="{{ $customers}}" :projects="{{$projects}}" :products="{{ $products }}"

    /> --}}
    <quote :types="{{ $contractTypes}}" :products="{{ $products }}" :approve-permission="{{ @json_encode($approvePermission) }}"
    :permission-system-edit-quote = {{ @json_encode($canExistsPermissionSystemEditQuote) }}
    :permission-system-delete-quote = {{ @json_encode($canExistsPermissionSystemDeleteQuote) }}
     :permissionadd="{{ @json_encode($canExistsPermissionAddQuote) }}"
    />
@endsection
