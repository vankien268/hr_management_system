@extends('admin.layouts.app')
@section('content')
    <tax-list
        title="{{ trans('Danh sách thuế thu nhập cá nhân') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </tax-list>
@endsection

