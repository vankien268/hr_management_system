@extends('admin.layouts.app')
@section('content')
    <product-list :btn-add="{{ @json_encode($btnAdd) }}"></product-list>
@endsection
