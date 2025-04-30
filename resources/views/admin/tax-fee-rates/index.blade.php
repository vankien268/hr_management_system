@extends('admin.layouts.app')
@section('content')
    <tax-fee-rate-list
    title="{{ trans('Danh sách tỷ lệ thuế phí') }}"
    :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </tax-fee-rate-list>
@endsection
