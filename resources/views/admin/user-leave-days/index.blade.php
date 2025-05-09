@extends('admin.layouts.app')
@section('content')
    <user-leave-days
        title="{{ trans('Cấu hình nghỉ phép') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </user-leave-days>
@endsection

