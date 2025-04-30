@extends('admin.layouts.app')
@section('content')
    <dashboard :user="{{ @json_encode(Auth::user())}}"></dashboard>
    {{-- @dd(Auth::user()->permission)
    <span>{{  }}</span> --}}
@endsection
