@extends('admin.layouts.app')
@section('content')
    <unit-list
    title="{{ trans('Danh sách đơn vị tính') }}"
    :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </unit-list>
@endsection
