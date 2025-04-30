@extends('admin.layouts.app')
@section('content')
    <user-profile :user="{{ @json_encode($user['data']) }} "></user-profile>
@endsection
