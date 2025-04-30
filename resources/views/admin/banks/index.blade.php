@extends('admin.layouts.app')
@section('content')
    <bank-list
    title="{{ trans('Danh sách ngân hàng') }}"
    :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </bank-list>
@endsection
