@extends('admin.layouts.app')
@section('content')
    {{-- @dd(array_search( Route::current()->getName(), Config::get('project.route_uri')['declare'])) --}}
    {{-- @foreach ($funcs as $item)
        <p>const {{ $item['code']}} = {{ $item['id']}} ; /* {{$item['name']}} */</p>
    @endforeach --}}
    {{-- @foreach ($funcs_menu as $item)
        <p>const {{ $item['code']}} = {{ $item['id']}} ; /* {{$item['name']}} */</p>
    @endforeach --}}
    {{-- @php
        $a = '[';
        foreach ($funcs_menu as $item) {
            $a .= '[' . " 'id' => " . $item['id'] . ", 'code' => '" . $item['code'] . "', 'route_name' =>" . " '". $item['route_name']."'],";
        }
        echo($a . ']')
    @endphp --}}
    <system-function />
@endsection
