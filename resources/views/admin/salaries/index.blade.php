@extends('admin.layouts.app')
@section('content')
    <salary-list
        title="{{ trans('Danh sách bảng lương') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </salary-list>
@endsection

