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
    All Packages
@endsection
@section('bage-header')
    All Packages
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
                                                <th class="border-bottom-0">To - Phone</th>
                                                <th class="border-bottom-0">To - Phone 2</th>
                                                <th class="border-bottom-0">Area</th>
                                                <th class="border-bottom-0">Village</th>
                                                <th class="border-bottom-0">Street</th>
                                                <th class="border-bottom-0">Discount %</th>
                                                <th class="border-bottom-0">Delivery Cost Discount</th>
                                                <th class="border-bottom-0">Total Cost</th>
                                                <th class="border-bottom-0">Shipping State</th>
                                                <th class="border-bottom-0">Driver</th>
                                                <th class="border-bottom-0">Invoice State</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (App\Models\Package::all() as $package)
                                                <tr>
                                                    <td>{{ $package->user->fname }} {{$package->user->lname}}</td>
                                                    <td>{{ $package->to_phone }}</td>
                                                    <td>{{ $package->alter_phone }}</td>
                                                    <td>{{ $package->area->area_name }}</td>
                                                    <td>{{ $package->village->village_name }}</td>
                                                    <td>{{ $package->street }}</td>
                                                    <td>{{ $package->user->delivery_cost_discount }}</td>
                                                    <td>{{ $package->delivery_cost}}</td>
                                                    <td>{{ $package->total_cost}}</td>
                                                    <td>
                                                        @if ($package->shipping_state == 'ready')
                                                            <span class="badge bg-secondary">جاهز للشحن</span>
                                                        @elseif($package->shipping_state == 'processing')
                                                        <span class="badge bg-primary">قيد الانشاء</span>
                                                        @elseif($package->shipping_state == 'shipped')
                                                        <span class="badge bg-success">مشحون</span>
                                                        @elseif($package->shipping_state == 'closed')
                                                        <span class="badge bg-dark">منتهي</span>
                                                        @elseif($package->shipping_state == 'stuck')
                                                        <span class="badge bg-warning">عالق</span>
                                                        @elseif($package->shipping_state == 'returns')
                                                        <span class="badge bg-warning">راجع</span>
                                                        @elseif($package->shipping_state == 'delivered')
                                                        <span class="badge bg-success">واصل</span>
                                                        @endif
                                                    </td>
                                                    @if(isset($package->driver_id))
                                                    <td>{{$package->driver->fname}} {{$package->driver->lname}}</td>
                                                    @else
                                                    <td>{{$package->package_location}}</td>
                                                    @endif
                                                    
                                                    <td>
                                                        @if (!isset($package->invoice_state))
                                                            <span class="badge bg-success">لم يتم فتح فاتورة بعد</span>
                                                        @else
                                                            <span class="badge bg-danger">تم الانتهاء من الطرد عن طريق إنشاء فاتورة للعميل</span>
                                                        @endif
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
