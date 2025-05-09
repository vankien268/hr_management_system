@extends('admin.layouts.app')
@section('content')
    <workflow-list
        title="{{ trans('Danh sách quy trình duyệt') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </workflow-list>
@endsection

