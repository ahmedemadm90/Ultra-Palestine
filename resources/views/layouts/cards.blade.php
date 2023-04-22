<!-- ROW-1 -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Clients</h6>
                                <h2 class="mb-0 number-font">{{ App\Models\User::where('role_id', 2)->count() }}</h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="saleschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Open Invoices</h6>
                                <h2 class="mb-0 number-font">{{ App\Models\Invoice::count() }}</h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="leadschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Drivers</h6>
                                <h2 class="mb-0 number-font">{{ App\Models\User::where('role_id', 3)->count() }}</h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="profitchart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @foreach (App\Models\Office::all() as $office)
                <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                    <div class="card overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="mt-2">
                                    <h6 class="">{{ $office->office_name }}</h6>
                                    <h2 class="mb-0 number-font">{{ $office->budget }} <i class="fas fa-shekel-sign"></i></h2>
                                </div>
                                <div class="ms-auto">
                                    <div class="chart-wrapper mt-1">
                                        <canvas id="leadschart" class="h-8 w-9 chart-dropshadow"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- <div class="col-lg-6 col-md-6 col-sm-12 col-xl-3">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mt-2">
                                <h6 class="">Total Cost</h6>
                                <h2 class="mb-0 number-font">$59,765</h2>
                            </div>
                            <div class="ms-auto">
                                <div class="chart-wrapper mt-1">
                                    <canvas id="costchart" class="h-8 w-9 chart-dropshadow"></canvas>
                                </div>
                            </div>
                        </div>
                        <span class="text-muted fs-12"><span class="text-warning"><i
                                    class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                            Last year</span>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
<!-- ROW-1 END -->
