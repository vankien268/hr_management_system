@extends('admin.layouts.app')
@section('content')
    <salary-grade-list
        title="{{ trans('Danh sách thang bậc lương') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </salary-grade-list>
@endsection

