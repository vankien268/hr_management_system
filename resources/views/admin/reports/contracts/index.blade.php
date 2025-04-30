@extends('admin.layouts.app')
@section('content')
    <contract-report
    title="{{ trans('Báo cáo hợp đồng') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </contract-report>
@endsection
