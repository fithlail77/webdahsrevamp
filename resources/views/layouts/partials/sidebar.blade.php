<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i> <img src="{{ asset('adminpage/img/gum.png') }}" alt="" style="max-width: 100%; height: auto;"> </i>
                </div>
                <div class="sidebar-brand-text mx-3">Dashboard  PT GUM</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>
           
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            @php
                $isPengaturanActive = request()->routeIs('user.index') || request()->routeIs('comp.index');
            @endphp
             @role('admin')
            <li class="nav-item">
                <a class="nav-link {{ $isPengaturanActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="{{ $isPengaturanActive ? 'true' : 'false' }}" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
                <div id="collapseTwo" class="collapse {{ $isPengaturanActive ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sub Menu:</h6>
                        <a class="collapse-item {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">{{ __('Pengguna') }}</a>
                        <a class="collapse-item {{ request()->routeIs('comp.index') ? 'active' : '' }}" href="{{ route('comp.index') }}">{{ __('Perusahaan') }}</a>
                    </div>
                </div>
            </li>
            @endrole
            <!-- Nav Item - Utilities Collapse Menu -->
           <!-- @php
                $isTransaksiActive = request()->routeIs('areal.index') || request()->routeIs('curah.index') || request()->routeIs('airsungai.index') || request()->routeIs('ffbinternal.index') || request()->routeIs('ffbeksternal.index') || request()->routeIs('produksicpo.index') || request()->routeIs('contractcpo.index') || request()->routeIs('contractpk.index')
                || request()->routeIs('tbsinternal.index') || request()->routeIs('penen.index') || request()->routeIs('pupuk.index') || request()->routeIs('perawatan.index') || request()->routeIs('payroll.index') || request()->routeIs('lho.index') || request()->routeIs('depre.index') || request()->routeIs('spartlho.index') || request()->routeIs('lhounit.index')
                || request()->routeIs('awsinput.index');
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isTransaksiActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="{{ $isPengaturanActive ? 'true' : 'false' }}" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Transaksi</span>
                </a>
            
                <div id="collapseUtilities" class="collapse {{ $isTransaksiActive ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sub Menu:</h6>
            @if(auth()->user()->hasAnyRole(['manager','admin']))
                        <a class="collapse-item {{ request()->routeIs('areal.index') ? 'active' : '' }}" href="{{ route('areal.index') }}">{{ __('Areal Statement') }}</a>
            @endif
            @if(auth()->user()->hasAnyRole(['manager','admin','user']))
                        <a class="collapse-item {{ request()->routeIs('curah.index') ? 'active' : '' }}" href="{{ route('curah.index') }}">{{ __('Curah Hujan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('airsungai.index') ? 'active' : '' }}" href="{{ route('airsungai.index') }}">{{ __('Air Sungai') }}</a>
                        <a class="collapse-item {{ request()->routeIs('airsungai.index') ? 'active' : '' }}" href="{{ route('airsungai.index') }}">{{ __('Air Sungai') }}</a>
                        <a class="collapse-item {{ request()->routeIs('ffbinternal.index') ? 'active' : '' }}" href="{{ route('ffbinternal.index') }}">{{ __('FFB Internal') }}</a>
                        <a class="collapse-item {{ request()->routeIs('ffbeksternal.index') ? 'active' : '' }}" href="{{ route('ffbeksternal.index') }}">{{ __('FFB Eksternal') }}</a>
                        <a class="collapse-item {{ request()->routeIs('produksicpo.index') ? 'active' : '' }}" href="{{ route('produksicpo.index') }}">{{ __('Produksi CPO') }}</a>
                        <a class="collapse-item {{ request()->routeIs('contractcpo.index') ? 'active' : '' }}" href="{{ route('contractcpo.index') }}">{{ __('Kontrak CPO') }}</a>
                        <a class="collapse-item {{ request()->routeIs('contractpk.index') ? 'active' : '' }}" href="{{ route('contractpk.index') }}">{{ __('Kontrak Kernel') }}</a>
                        <a class="collapse-item {{ request()->routeIs('pupuk.index') ? 'active' : '' }}" href="{{ route('pupuk.index') }}">{{ __('Pemupukan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('perawatan.index') ? 'active' : '' }}" href="{{ route('perawatan.index') }}">{{ __('Perawatan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('payroll.index') ? 'active' : '' }}" href="{{ route('payroll.index') }}">{{ __('Payroll') }}</a>
                        <a class="collapse-item {{ request()->routeIs('lho.index') ? 'active' : '' }}" href="{{ route('lho.index') }}">{{ __('LHO BBM') }}</a>
                        <a class="collapse-item {{ request()->routeIs('depre.index') ? 'active' : '' }}" href="{{ route('depre.index') }}">{{ __('Depresiasi Alat') }}</a>
                        <a class="collapse-item {{ request()->routeIs('spartlho.index') ? 'active' : '' }}" href="{{ route('spartlho.index') }}">{{ __('Sparepart LHO') }}</a>
                        <a class="collapse-item {{ request()->routeIS('lhounit.index') ? 'active' : '' }}" href="{{ route('lhounit.index') }} ">{{ __('LHO Unit') }}</a>
                        <a class="collapse-item {{ request()->routeIS('awsinput.index') ? 'active' : '' }}" href="{{ route('awsinput.index') }} ">{{ __('AWS') }}</a>
                    </div>
                </div>
            </li>
            @endif -->

            @php
                $isTransaksiActive = request()->routeIs('areal.index') 
                    || request()->routeIs('curah.index') 
                    || request()->routeIs('airsungai.index') 
                    || request()->routeIs('ffbinternal.index') 
                    || request()->routeIs('ffbeksternal.index') 
                    || request()->routeIs('produksicpo.index') 
                    || request()->routeIs('contractcpo.index') 
                    || request()->routeIs('contractpk.index')
                    || request()->routeIs('tbsinternal.index') 
                    || request()->routeIs('penen.index') 
                    || request()->routeIs('pupuk.index') 
                    || request()->routeIs('perawatan.index') 
                    || request()->routeIs('payroll.index') 
                    || request()->routeIs('lho.index') 
                    || request()->routeIs('depre.index') 
                    || request()->routeIs('spartlho.index') 
                    || request()->routeIs('lhounit.index')
                    || request()->routeIs('awsinput.index')
                    || request()->routeIs('realisasipanen.index');;

                $isCurahActive = request()->routeIs('curah.index') || request()->routeIs('airsungai.index');
                $isPKSActive = request()->routeIs('ffbinternal.index') || request()->routeIs('ffbeksternal.index') || request()->routeIs('produksicpo.index') || request()->routeIs('contractcpo.index') || request()->routeIs('contractpk.index');
                $isUpkeepActive = request()->routeIs('pupuk.index') || request()->routeIs('perawatan.index') || request()->routeIs('payroll.index');
                $isUnitActive = request()->routeIs('lho.index') || request()->routeIs('depre.index') || request()->routeIs('spartlho.index') || request()->routeIs('lhounit.index');
                $isKebunActive = request()->routeIs('realisasipanen.index');
            @endphp

            <li class="nav-item">
                <a class="nav-link {{ $isTransaksiActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseTransaksi" aria-expanded="{{ $isTransaksiActive ? 'true' : 'false' }}" aria-controls="collapseTransaksi">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Transaksi</span>
                </a>

                <div id="collapseTransaksi" class="collapse {{ $isTransaksiActive ? 'show' : '' }}" aria-labelledby="headingTransaksi" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Menu:</h6>

                        {{-- contoh jika role tertentu --}}
                        @if(auth()->user()->hasAnyRole(['manager','admin']))
                            <a class="collapse-item {{ request()->routeIs('areal.index') ? 'active' : '' }}" href="{{ route('areal.index') }}">
                                {{ __('Areal Statement') }}
                            </a>
                        @endif

                        @if(auth()->user()->hasAnyRole(['manager','admin','user']))
                            {{-- MENU CURAH HUJAN dengan SUBMENU --}}
                            <a class="collapse-item {{ $isCurahActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseCurah" aria-expanded="{{ $isCurahActive ? 'true' : 'false' }}" aria-controls="collapseCurah">
                                {{ __('Curah Hujan') }}
                            </a>
                            <div id="collapseCurah" class="collapse {{ $isCurahActive ? 'show' : '' }}" data-parent="#collapseTransaksi">
                                <div class="bg-light py-2 collapse-inner rounded ml-3">
                                    <a class="collapse-item {{ request()->routeIs('curah.index') ? 'active' : '' }}" href="{{ route('curah.index') }}">
                                        {{ __('Input Curah Hujan') }}
                                    </a>
                                    <a class="collapse-item {{ request()->routeIs('airsungai.index') ? 'active' : '' }}" href="{{ route('airsungai.index') }}">
                                        {{ __('Input Air Sungai') }}
                                    </a>
                                </div>
                            </div>

                            {{-- MENU DATA KEBUN dengan SUBMENU --}}
                            <a class="collapse-item {{ $isKebunActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseKebun" aria-expanded="{{ $isKebunActive ? 'true' : 'false' }}" aria-controls="collapseKebun">
                                {{ __('Kebun') }}
                            </a>
                            <div id="collapseKebun" class="collapse {{ $isKebunActive ? 'show' : '' }}" data-parent="#collapseTransaksi">
                                <div class="bg-light py-2 collapse-inner rounded ml-3">
                                    <a class="collapse-item {{ request()->routeIs('realisasipanen.index') ? 'active' : '' }}" href="{{ route('realisasipanen.index') }}">{{ __('Input Realisasi Panen') }}</a>
                                </div>
                            </div>

                            {{-- MENU DATA PKS dengan SUBMENU --}}
                            <a class="collapse-item {{ $isPKSActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapsePKS" aria-expanded="{{ $isPKSActive ? 'true' : 'false' }}" aria-controls="collapsePKS">
                                {{ __('Pabrik') }}
                            </a>
                            <div id="collapsePKS" class="collapse {{ $isPKSActive ? 'show' : '' }}" data-parent="#collapseTransaksi">
                                <div class="bg-light py-2 collapse-inner rounded ml-3">
                                    <a class="collapse-item {{ request()->routeIs('ffbinternal.index') ? 'active' : '' }}" href="{{ route('ffbinternal.index') }}">{{ __('Input FFB Internal') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('ffbeksternal.index') ? 'active' : '' }}" href="{{ route('ffbeksternal.index') }}">{{ __('Input FFB Eksternal') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('produksicpo.index') ? 'active' : '' }}" href="{{ route('produksicpo.index') }}">{{ __('Input Produksi PKS') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('contractcpo.index') ? 'active' : '' }}" href="{{ route('contractcpo.index') }}">{{ __('Input Kontrak CPO') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('contractpk.index') ? 'active' : '' }}" href="{{ route('contractpk.index') }}">{{ __('Input Kontrak PK') }}</a>
                                </div>
                            </div>

                            {{-- MENU DATA UPKEEP dengan SUBMENU --}}
                            <a class="collapse-item {{ $isUpkeepActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUpkeep" aria-expanded="{{ $isUpkeepActive ? 'true' : 'false' }}" aria-controls="collapseUpkeep">
                                {{ __('Upkeep') }}
                            </a>
                            <div id="collapseUpkeep" class="collapse {{ $isUpkeepActive ? 'show' : '' }}" data-parent="#collapseTransaksi">
                                <div class="bg-light py-2 collapse-inner rounded ml-3">
                                    <a class="collapse-item {{ request()->routeIs('pupuk.index') ? 'active' : '' }}" href="{{ route('pupuk.index') }}">{{ __('Input Pupuk') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('perawatan.index') ? 'active' : '' }}" href="{{ route('perawatan.index') }}">{{ __('Input Perawatan') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('payroll.index') ? 'active' : '' }}" href="{{ route('payroll.index') }}">{{ __('Input HK') }}</a>
                                </div>
                            </div>

                            {{-- MENU DATA KENDERAAN & ALAT BERAT dengan SUBMENU --}}
                            <a class="collapse-item {{ $isUnitActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUnit" aria-expanded="{{ $isUnitActive ? 'true' : 'false' }}" aria-controls="collapseUnit">
                                {{ __('Kenderaan') }}
                            </a>
                            <div id="collapseUnit" class="collapse {{ $isUnitActive ? 'show' : '' }}" data-parent="#collapseTransaksi">
                                <div class="bg-light py-2 collapse-inner rounded ml-3">
                                    <a class="collapse-item {{ request()->routeIs('lho.index') ? 'active' : '' }}" href="{{ route('lho.index') }}">{{ __('Input BBM') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('depre.index') ? 'active' : '' }}" href="{{ route('depre.index') }}">{{ __('Input Depresiasi') }}</a>
                                    <a class="collapse-item {{ request()->routeIs('spartlho.index') ? 'active' : '' }}" href="{{ route('spartlho.index') }}">{{ __('Input Sparepart') }}</a>
                                    <a class="collapse-item {{ request()->routeIS('lhounit.index') ? 'active' : '' }}" href="{{ route('lhounit.index') }}">{{ __('Input Aktifitas') }}</a>
                                </div>
                            </div>
                            {{-- Menu lain tetap seperti biasa --}}
                            <a class="collapse-item {{ request()->routeIS('awsinput.index') ? 'active' : '' }}" href="{{ route('awsinput.index') }}">{{ __('Weather Station') }}</a>
                        @endif
                    </div>
                </div>
            </li>

            @if(auth()->user()->hasAnyRole(['manager','admin']))
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Dashboard
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('aresta.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('Areal Statement') }}</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('curahhujan.index') }}">
                    <i class="fas fa-fw fa-cloud-rain"></i>
                    <span>{{ __('Curah Hujan') }}</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('aws.index') }}">
                    <i class="fas fa-fw fa-cloud-rain"></i>
                    <span>{{ __('AWS') }}</span></a>
            </li>
            
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('produksi.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>{{ __('Produksi') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('pr.index') }}">
                    <i class="fas fa-fw fa-layer-group"></i>
                    <span>{{ __('Pemupukan & Perawatan') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('vra.index') }}">
                    <i class="fas fa-fw fa-truck-monster"></i>
                    <span>{{ __('Operasional Unit') }}</span>
                </a>
            </li>
            
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('road.index') }}">
                    <i class="fas fa-fw fa-road"></i>
                    <span>{{ __('Infrastruktur Jalan') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('legal.index') }}">
                    <i class="fas fa-fw fa-gavel"></i>
                    <span>{{ __('Legal') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('lsu.index') }}">
                    <i class="fas fa-fw fa-leaf"></i>
                    <span>{{ __('Sampel Daun [LSU]') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('blok.index') }}">
                    <i class="fas fa-fw fa-cube"></i>
                    <span>{{ __('Assessmen Blok') }}</span>
                </a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="{{ route('bibit.index') }}">
                    <i class="fas fa-fw fa-seedling"></i>
                    <span>{{ __('Pembibitan') }}</span>
                </a>
            </li>
            @endif
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>