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
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body rounded border border-extreme">
                                    <div class="d-flex align-items-center">
                                        <div class="numbers flex-grow-1 pe-3">
                                            <p class="fw-600 mb-1 text-muted">Total Newses</p>
                                            <h4 class="fw-700 mb-0 text-dark-black">{{ $nws_sum }}</h4>
                                        </div>
                                        <div class="icon-shape bg-extreme ">
                                            <i class="ti ti-news"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body rounded border border-extreme">
                                    <div class="d-flex align-items-center">
                                        <div class="numbers flex-grow-1 pe-3">
                                            <p class="fw-600 mb-1 text-muted">Total Obituaries</p>
                                            <h4 class="fw-700 mb-0 text-dark-black">{{ $obs_sum }}</h4>
                                        </div>
                                        <div class="icon-shape bg-extreme ">
                                            <i class="ti ti-list"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body  rounded border border-extreme">
                                    <div class="d-flex align-items-center">
                                        <div class="numbers flex-grow-1 pe-3">
                                            <p class="fw-600 mb-1 text-muted">Total Remembrances</p>
                                            <h4 class="fw-700 mb-0 text-dark-black">{{ $rems_sum }}</h4>
                                        </div>
                                        <div class="icon-shape bg-extreme ">
                                            <i class="ti ti-heart"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card">
                                <div class="card-body rounded border border-extreme">
                                    <div class="d-flex align-items-center">
                                        <div class="numbers flex-grow-1">
                                            <p class="fw-600 mb-1 text-muted">Total Advertisements</p>
                                            <h4 class="fw-700 mb-0 text-dark-black">{{ $ads_sum }}</h4>
                                        </div>
                                        <div class="icon-shape bg-extreme ">
                                            <i class="ti ti-bookmark"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xxl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Latest Advertisements</h4>
                                </div>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="10px">#</th>
                                                <th>Title</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ads as $ad)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $ad->title }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Latest Obituaries</h4>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10px">#</th>
                                            <th>Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obs as $ob)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $ob->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-xxl-4 col-lg-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Latest Remembrances</h4>
                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="10px">#</th>
                                            <th>Title</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($obs as $ob)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $ob->name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card table-card">
                                <div class="card-header">
                                    <h4>Latest News</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th width="70px">#</th>
                                                    <th>News</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($newses as $news)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $news->name }}</td>
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
@endsection
