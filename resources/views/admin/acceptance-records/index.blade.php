@extends('admin.layouts.app')
@section('content')
        @php
        $requestUrl = [
             'id' => $id
        ];
        @endphp
    <acceptance-record-list
    title="{{ trans('Danh sách biên bản nghiệm thu') }}" :btn-add="{{ @json_encode($btnAdd) }}"
    :requesturl="{{ json_encode($requestUrl) }}"
    >
    </acceptance-record-list>
@endsection
