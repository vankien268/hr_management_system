@extends('admin.layouts.app')
@section('content')
    <customer-report
    title="{{ trans('Báo cáo khách hàng') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </customer-report>
@endsection
