@extends('admin.layouts.app')
@section('content')
    <user-list :btn-add="{{ @json_encode($btnAdd) }} "></user-list>
@endsection
