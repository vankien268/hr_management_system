@extends('admin.layouts.app')
@section('content')
    <internal-fund-list
        title="{{ trans('Qũy nội bộ') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </internal-fund-list>
@endsection

