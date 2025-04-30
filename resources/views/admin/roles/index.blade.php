@extends('admin.layouts.app')
@section('content')
    <role-list
    title="{{ trans('Danh sách nhóm quyền') }}" :btn-add="{{ @json_encode($btnAdd)}}">
    </role-list>
@endsection
