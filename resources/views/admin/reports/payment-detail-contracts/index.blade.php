@extends('admin.layouts.app')
@section('content')
    <payment-detail-contract-report
    title="{{ trans('Báo cáo tiến độ thanh toán hợp đồng') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </payment-detail-contract-report>
@endsection
