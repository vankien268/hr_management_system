@extends('admin.layouts.app')
@section('content')
    <timekeeping-user-list
        title="{{ trans('Danh sách nhân viên chấm công theo ca') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </timekeeping-user-list>
@endsection

