@extends('admin.layouts.app')
@section('content')
    <insurance-list
        title="{{ trans('Danh sách bảo hiểm') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </insurance-list>
@endsection

