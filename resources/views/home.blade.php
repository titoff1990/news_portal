@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card shadow rounded-sm mt-3 mb-4 w-50 border-light">
            <div class="card-header">{{ __('auth.home') }}</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                {{ __('auth.welcome') . Auth::user()?->name }}
            </div>
        </div>
    </div>
@endsection
