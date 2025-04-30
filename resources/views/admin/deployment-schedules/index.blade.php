@extends('admin.layouts.app')
@section('content')
    <deployment-schedule :btn-add="{{ @json_encode($btnAdd)}}"></deployment-schedule>
@endsection
