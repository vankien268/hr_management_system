@extends('admin.layouts.app')
@section('content')
    <salary-contact-list
        title="{{ trans('Danh sách bảng lương nhân viên') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </salary-contact-list>
@endsection

