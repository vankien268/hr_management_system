@extends('admin.layouts.app')
@section('content')
    <department-list
    title="{{ trans('Danh sách bộ phận') }}"
    :btn-add =" {{ @json_encode($btnAdd)}}"
    >

    </department-list>
@endsection
