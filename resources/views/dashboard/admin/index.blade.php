@extends('dashboard.main')

@section('content')

            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Manajemen Klinik</h1>
            </div>
            <div class="row">
                @can('isAdmin')
                <!-- Dokter -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('dokter') }}" class="text-decoration-none">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Total Dokter</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dokter }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-user-doctor fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                @endcan
            <!-- Riwayat Rekmed -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('rekmed') }}" class="text-decoration-none">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Riwayat Pasien Perminggu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekmed }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-book-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        @can('isDokter')
                        <div class="col-xl-4 col-md-6 mb-4">
                            {{-- <a href="{{ route('ketdok') }}" class="text-decoration-none"> --}}
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                               Status Ketersediaan Anda</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $status }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-business-time fa-2x text-success-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- </a> --}}
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('janjitemu') }}" class="text-decoration-none">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                               Janji Temu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $janjiTemu }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><smalla class="text-xs text-secondary text-disable">No caption</smalla></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-business-time fa-2x text-success-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        @endcan
                        @can('isAdmin')
            <!-- Jumlah Dokter Onsite -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('dokter') }}" class="text-decoration-none">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                               Jumlah Dokter Bersedia</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dokTersedia }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-check-to-slot fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
            <!-- Total Jenis Obat -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('obat') }}" class="text-decoration-none">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                               Total Jenis Obat</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obat }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-pills fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        @endcan
            </div>
@endsection
            <hr class="sidebar-divider my-0">
@can('isAdmin')
{{-- CMS --}}
@section('content2')
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Informasi Layanan Klinik</h1>
            </div>
            <div class="row">
                <!-- Jumlah Section -->
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('about') }}" class="text-decoration-none">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Total Section</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">No caption</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-book-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-xl-4 col-md-6 mb-4">
                            <a href="{{ route('janjitemu') }}" class="text-decoration-none">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                               Janji Temu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $janjiTemu }}</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><small class="text-xs text-secondary text-disable">Hari ini</small></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fa-solid fa-book-medical fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
            
            </div>
@endsection
@endcan