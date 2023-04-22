@extends('layouts.app')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('footer')
    @include('layouts.footer')
@endsection
@section('title')
    User Information
@endsection
@section('bage-header')
    About User
@endsection
@section('content')
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    @if ($user->role->role_name == 'admin')
                        hi admin
                    @endif
                    @if ($user->role->role_name == 'client')
                        hi client
                    @endif
                    @if ($user->role->role_name == 'driver')
                        hi driver
                    @endif

                    @if ($user->role->role_name == 'employee')
                        hi employee
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
