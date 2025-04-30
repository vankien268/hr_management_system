@extends('admin.layouts.app')
@section('content')
    <project-report
    title="{{ trans('Báo cáo dự án') }}"
    :name="{{ @json_encode(auth()->user()->name) }}"
    >
    </project-report>
@endsection
