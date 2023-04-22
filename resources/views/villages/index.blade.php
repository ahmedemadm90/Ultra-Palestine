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
    All Villages
@endsection
@section('bage-header')
    All Villages
@endsection
@section('content')
    @include('layouts.sessions')
    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('villages.create') }}" class="btn btn-primary">Create New Village</a>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="file-datatable"
                                        class="table table-bordered text-nowrap key-buttons border-bottom">
                                        <thead>
                                            <tr>
                                                <th class="border-bottom-0">Village Name</th>
                                                <th class="border-bottom-0">Area Name</th>
                                                <th class="border-bottom-0">Delivery Cost</th>
                                                <th class="border-bottom-0">Packages Count</th>
                                                <th class="border-bottom-0">Tools</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Village::all() as $village)
                                                <tr>
                                                    <td>{{ $village->village_name }}</td>
                                                    <td>{{ $village->area->area_name }}</td>
                                                    <td>{{ $village->delivery_cost }}</td>
                                                    <td>{{ $village->packages->count() }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary" type="button"
                                                                id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                                <li><a class="dropdown-item text-success"
                                                                        href="{{ route('villages.show', $village->id) }}">Show</a>
                                                                </li>
                                                                <li><a class="dropdown-item text-primary"
                                                                        href="{{ route('villages.edit', $village->id) }}">Edit</a>
                                                                </li>
                                                                <li><a class="dropdown-item text-danger"
                                                                        href="{{ route('villages.destroy', $village->id) }}">Delete</a>
                                                                </li>
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
