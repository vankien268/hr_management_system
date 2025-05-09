@extends('admin.layouts.app')
@section('content')
    <hrm-contract-list
        title="{{ trans('Danh sách hợp đồng') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </hrm-contract-list>
@endsection

