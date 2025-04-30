@extends('admin.layouts.app')
@section('content')
    <project-index :btn-add="{{ @json_encode($btnAdd) }}"
    :users="{{ @json_encode($users) }}"
    :customers="{{ @json_encode($customers) }}"
    ></project-index>
@endsection
