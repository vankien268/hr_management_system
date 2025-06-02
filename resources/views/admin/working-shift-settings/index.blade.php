@extends('admin.layouts.app')
@section('content')
    <working-shift-setting-list
        title="{{ trans('Danh sách thiết lập ca chấm công') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >
    </working-shift-setting-list>

@endsection

