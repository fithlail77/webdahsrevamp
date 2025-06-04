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

            <!-- Nav Item - Utilities Collapse Menu -->
            @php
                $isTransaksiActive = request()->routeIs('areal.index') || request()->routeIs('curah.index') || request()->routeIs('airsungai.index') || request()->routeIs('ffbinternal.index') || request()->routeIs('ffbeksternal.index') || request()->routeIs('produksicpo.index') || request()->routeIs('contractcpo.index') || request()->routeIs('contractpk.index')
                || request()->routeIs('tbsinternal.index') || request()->routeIs('penen.index') || request()->routeIs('pupuk.index') || request()->routeIs('perawatan.index') || request()->routeIs('payroll.index');
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isTransaksiActive ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="{{ $isPengaturanActive ? 'true' : 'false' }}" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Transaksi</span>
                </a>
                <div id="collapseUtilities" class="collapse {{ $isTransaksiActive ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Sub Menu:</h6>
                        <a class="collapse-item {{ request()->routeIs('areal.index') ? 'active' : '' }}" href="{{ route('areal.index') }}">{{ __('Areal Statement') }}</a>
                        <a class="collapse-item {{ request()->routeIs('curah.index') ? 'active' : '' }}" href="{{ route('curah.index') }}">{{ __('Curah Hujan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('airsungai.index') ? 'active' : '' }}" href="{{ route('airsungai.index') }}">{{ __('Air Sungai') }}</a>
                        <a class="collapse-item {{ request()->routeIs('ffbinternal.index') ? 'active' : '' }}" href="{{ route('ffbinternal.index') }}">{{ __('FFB Internal') }}</a>
                        <a class="collapse-item {{ request()->routeIs('ffbeksternal.index') ? 'active' : '' }}" href="{{ route('ffbeksternal.index') }}">{{ __('FFB Eksternal') }}</a>
                        <a class="collapse-item {{ request()->routeIs('produksicpo.index') ? 'active' : '' }}" href="{{ route('produksicpo.index') }}">{{ __('Produksi CPO') }}</a>
                        <a class="collapse-item {{ request()->routeIs('contractcpo.index') ? 'active' : '' }}" href="{{ route('contractcpo.index') }}">{{ __('Kontrak CPO') }}</a>
                        <a class="collapse-item {{ request()->routeIs('contractpk.index') ? 'active' : '' }}" href="{{ route('contractpk.index') }}">{{ __('Kontrak Kernel') }}</a>
                        <a class="collapse-item {{ request()->routeIs('tbsinternal.index') ? 'active' : '' }}" href="{{ route('tbsinternal.index') }}">{{ __('SPTBS') }}</a>
                        <a class="collapse-item {{ request()->routeIs('panen.index') ? 'active' : '' }}" href="{{ route('panen.index') }}">{{ __('Realisasi Panen') }}</a>
                        <a class="collapse-item {{ request()->routeIs('pupuk.index') ? 'active' : '' }}" href="{{ route('pupuk.index') }}">{{ __('Pemupukan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('perawatan.index') ? 'active' : '' }}" href="{{ route('perawatan.index') }}">{{ __('Perawatan') }}</a>
                        <a class="collapse-item {{ request()->routeIs('payroll.index') ? 'active' : '' }}" href="{{ route('payroll.index') }}">{{ __('Payroll') }}</a>
                    </div>
                </div>
            </li>

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

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>