@extends('admin.layouts.app')
@section('content')
    <dispatch-report
    title="{{ trans('Báo cáo công văn, thông báo') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </dispatch-report>
@endsection
