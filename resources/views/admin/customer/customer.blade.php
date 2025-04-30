@extends('admin.layouts.app')
@section('content')
    <customer :banks="{{ $banks }}" :cities="{{ $cities }}" :districts="{{ $districts }}"
        :wards="{{ $wards }}" :statuses="{{ $statuses }}" :btn-add="{{ @json_encode($btnAdd) }}"
        :users="{{ $users }}"
        :btn-customer-vip="{{ @json_encode($btnAddVIP) }}" :view-customer-contact="{{ @json_encode($viewCustomerContact) }}" :view-customer-phone="{{ @json_encode($viewCustomerPhone) }}"></customer>
@endsection
