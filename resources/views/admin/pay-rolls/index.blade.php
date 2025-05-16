@extends('admin.layouts.app')
@section('content')
    <pay-roll-list
        title="{{ trans('Bậc lương vị trí') }}"
        :btn-add="{{ @json_encode($btnAdd)}}"
    >

    </pay-roll-list>
@endsection

