@extends('admin.layouts.app')
@section('content')
    @php
        $requestParams = [
            'code' => $code,
            'id' => $id
        ];
    @endphp
    <dispatch-list
    title="{{ trans('Danh sách công văn, thông báo') }}" :btn-add="{{ @json_encode($btnAdd)}}"
    :requestparams="{{ @json_encode($requestParams) }}"
    >
    </dispatch-list>
@endsection
