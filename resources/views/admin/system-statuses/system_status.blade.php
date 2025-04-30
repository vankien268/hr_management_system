@extends('admin.layouts.app')
@section('content')
    {{-- @dd(array_search( Route::current()->getName(), Config::get('project.route_uri')['declare'])) --}}
    {{-- @dd($btnAdd, $btnEdit, $btnDelete) --}}
    <system-status :status-type="{{ $statusTypeList }}" :btn-add="{{ @json_encode($btnAdd) }}" :btn-edit="{{ @json_encode($btnEdit) }} " :btn-delete="{{ @json_encode($btnDelete) }}" />
@endsection
