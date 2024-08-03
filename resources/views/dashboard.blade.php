@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body bg-extreme rounded-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-12">
                                <div class="d-lg-flex justify-content-between align-items-center ">
                                    <div class="d-md-flex align-items-center">
                                        @if(!empty($setting->profile) && file_exists(public_path('storage/' . $setting->profile)))
                                            <img src="{{ asset('storage/' . $setting->profile) }}" alt="Image" width="60px" class="rounded-circle avatar avatar-xl">
                                        @else
                                            <img src="https://raw.githubusercontent.com/abisanthm/abisanthm.github.io/main2/profile-girl.png" alt="Default Image" width="60px" class="rounded-circle border border-light border-3 avatar avatar-xl">
                                        @endif
                                        <div class="ms-md-4 mt-3">
                                            <h3 class="text-white fw-600 mb-1">Welcome, {{ auth()->user()->name }}!</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container">
    <!-- Date Range Filter Form -->
    <form method="GET" action="{{ route('dashboard') }}" id="dateRangeForm">
        <div class="row mb-3">

            <div class="col-3">
                <input type="date" name="start_date" id="startDate" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
            </div>
            <div class="col-3">
                <input type="date" name="end_date" id="endDate" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
            </div>
            <div class="col-3">
                <div class="dropdown">
                    <button class="btn btn-sm btn-block btn-primary dropdown-toggle" type="button" id="dateRangeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Select Date Range
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dateRangeDropdown">
                        <li><a class="dropdown-item" href="#" onclick="setDateRange('today')">Today</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setDateRange('yesterday')">Yesterday</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setDateRange('last_week')">Last Week</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setDateRange('last_month')">Last Month</a></li>
                        <li><a class="dropdown-item" href="#" onclick="setDateRange('custom')">Custom Range</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-block btn-sm btn-primary">Filter</button>
            </div>
        </div>
    </form>
    <!-- Order Status Summary -->
    <h3>Order Status Summary</h3>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Status</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orderStatuses as $statusKey => $statusName)
                                <tr>
                                    <td>{{ $statusName }}</td>
                                    <td>{{ $orderCounts[$statusKey] }}</td>
                                    <td>LKR {{ number_format($orderAmounts[$statusKey], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sales Status Summary -->
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales Status</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesStatuses as $statusKey => $statusName)
                                <tr>
                                    <td>{{ $statusName }}</td>
                                    <td>{{ $salesCounts[$statusKey] }}</td>
                                    <td>LKR {{ number_format($salesAmounts[$statusKey], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setDateRange(range) {
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');
        const today = new Date();
        let start, end;

        switch (range) {
            case 'today':
                start = new Date(today);
                end = new Date(today);
                break;
            case 'yesterday':
                start = new Date(today);
                start.setDate(start.getDate() - 1);
                end = new Date(start);
                break;
            case 'last_week':
                start = new Date(today);
                start.setDate(start.getDate() - 7);
                end = new Date(today);
                break;
            case 'last_month':
                start = new Date(today);
                start.setMonth(start.getMonth() - 1);
                end = new Date(today);
                break;
            case 'custom':
                start = null;
                end = null;
                break;
        }

        if (start && end) {
            startDate.value = start.toISOString().split('T')[0];
            endDate.value = end.toISOString().split('T')[0];
        } else {
            startDate.value = '';
            endDate.value = '';
        }
    }
</script>
@endsection
