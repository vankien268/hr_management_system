@extends('admin.layouts.app')
@section('content')
    <deployment-record-list
    title="{{ trans('Danh sách biên bản triển khai') }}"
    :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </deployment-record-list>
@endsection
