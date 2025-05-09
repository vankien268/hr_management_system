@extends('admin.layouts.app')
@section('content')
    <request-ticket-list
        title="{{ trans('Danh sách phiếu yêu cầu') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </request-ticket-list>
@endsection

