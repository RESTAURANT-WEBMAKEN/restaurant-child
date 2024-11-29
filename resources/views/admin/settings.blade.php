@extends('layouts.app')

@section('content')
    <h1>Settings</h1>

    <form method="POST" action="{{ route('settings') }}">
        @csrf

        @foreach($settings as $setting)
            <div>
                <label>{{ $setting->key }}</label>
                <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}">
            </div>
        @endforeach

        <button type="submit">Save Changes</button>
    </form>
@endsection