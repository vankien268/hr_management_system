@extends('admin.layouts.app')
@section('content')
    <payment-detail-project-report
    title="{{ trans('Báo cáo chi tiết doanh thu dự án') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </payment-detail-project-report>
@endsection
