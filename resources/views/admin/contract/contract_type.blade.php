@extends('admin.layouts.app')
@section('content')
    <contract-type :btn-add="{{ @json_encode($btnAdd)}}" />
@endsection
