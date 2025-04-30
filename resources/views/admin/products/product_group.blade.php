@extends('admin.layouts.app')
@section('content')
    <product-group :product-groups="{{ $productGroup}}" :tax-list="{{ $taxRate }}" :fee-list="{{ $feeRate }}" :btn-add="{{ @json_encode($btnAdd)}}" ></product-group>
@endsection
