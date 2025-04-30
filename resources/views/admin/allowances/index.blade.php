@extends('admin.layouts.app')
@section('content')
    <allowance-list
        title="{{ trans('Danh sách phụ cấp') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </allowance-list>
@endsection
<?php
