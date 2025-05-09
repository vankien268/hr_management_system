@extends('admin.layouts.app')
@section('content')
    <hrm-contact-list
        title="{{ trans('Danh sách nhân sự') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </hrm-contact-list>
@endsection

