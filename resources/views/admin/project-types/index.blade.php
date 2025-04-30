@extends('admin.layouts.app')
@section('content')
    <project-type-list  title="{{ trans('Danh sách loại dự án') }}" :btn-add = "{{ @json_encode($btnAdd) }}"></project-type-list>
@endsection
