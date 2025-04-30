@extends('admin.layouts.app')
@section('content')
    <deployment-record-report
    title="{{ trans('Báo cáo tiến độ triển khai') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </deployment-record-report>
@endsection
