@extends('admin.layouts.app')
@section('content')
    <acceptance-record-report
    title="{{ trans('Báo cáo tiến độ nghiệm thu') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </acceptance-record-report>
@endsection
