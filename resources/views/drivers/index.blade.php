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
    كل السائقين
@endsection
@section('bage-header')
    كل السائقين
@endsection
@section('content')
    @include('layouts.sessions')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
                </div> --}}
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">Name</th>
                                                <th class="border-bottom-0">Phone</th>
                                                <th class="border-bottom-0">Area</th>
                                                <th class="border-bottom-0">Village</th>
                                                <th class="border-bottom-0">Street</th>
                                                <th class="border-bottom-0">Packages Count</th>
                                                <th class="border-bottom-0">Budget</th>
                                                <th class="border-bottom-0">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\User::where('role_id',3)->get() as $user)
                                                <tr>
                                                    <td>{{ $user->fname }} {{ $user->lname }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->area->area_name }}</td>
                                                    <td>{{ $user->village->village_name }}</td>
                                                    <td>{{ $user->street }}</td>
                                                    <td>{{ App\Models\Package::where('driver_id',$user->id)->count() }}</td>
                                                    <td>{{ $user->budget }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary" type="button"
                                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li><a class="dropdown-item text-success"
                                                                        href="{{ route('users.show', $user->id) }}">Show</a>
                                                                </li>
                                                                <li><a class="dropdown-item text-primary"
                                                                        href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                                </li>
                                                                @if ($user->active == 1)
                                                                    <li><a class="dropdown-item text-danger"
                                                                            href="{{ route('users.freeze', $user->id) }}">Freeze</a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item text-danger"
                                                                            href="{{ route('users.unfreeze', $user->id) }}">Un-Freeze</a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->
@endsection
