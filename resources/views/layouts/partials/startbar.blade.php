<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ route('any', 'home') }}" class="logo">
            <span>
                <img src="/images/kabelat3.png" alt="logo-small" class="logo-sm">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    @if(Auth::user()->role === 'superAdmin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="iconoir-home-simple menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('komunitas.members') ? 'active' : '' }}"
                            href="{{ route('second', ['Komunitas', 'komunitas']) }}">
                            <i class="iconoir-group menu-icon"></i>
                            <span>Member Komunitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('penduduk.create', 'penduduk.edit') ? 'active' : '' }}" href="{{ route('penduduk') }}">
                            <i class="iconoir-user-bag menu-icon"></i>
                            <span>Kelola User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('kelolaKomunitas.create', 'detailStruktur', 'editStruktur') ? 'active' : '' }}" href="#sidebarKomunitas" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarKomunitas">
                            <i class="iconoir-community menu-icon"></i>
                            <span>Komunitas</span>
                        </a>
                        <div class="collapse {{ Route::is('kelolaKomunitas.create', 'detailStruktur','editStruktur') ? 'show' : '' }}" area id="sidebarKomunitas">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('kelolaKomunitas.create') ? 'active' : '' }}"
                                        href="{{ route('second', ['kelolaKomunitas', 'komunitas']) }}">Kelola
                                        Komunitas</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('detailStruktur', 'editStruktur') ? 'active' : '' }}" href="{{ route('kelolaStruktur') }}">Kelola
                                        Struktur</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ Route::is('programDispusip.edit','programDispusip.create') ? 'active' : '' }}" href="{{ route('programDispusip') }}">
                            <i class="iconoir-calendar menu-icon"></i>
                            <span>Kelola Program Dispusip</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('kelolaKegiatan.create', 'kelolaKegiatan2.create') ? 'active' : '' }}" href="#sidebarKegiatan" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarKegiatan">
                            <i class="iconoir-running menu-icon"></i>
                            <span>Kelola Kegiatan</span>
                        </a>
                        <div class="collapse {{ Route::is('kelolaKegiatan.create', 'kelolaKegiatan2.create') ? 'show' : '' }}" area id="sidebarKegiatan">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('kelolaKegiatan.index', 'kelolaKegiatan.create') ? 'active' : '' }}"
                                        href="{{ route('kelolaKegiatan.index') }}">
                                        Program</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('kelolaKegiatan2.index', 'kelolaKegiatan2.create') ? 'active' : '' }}" href="{{ route('kelolaKegiatan2.index') }}">
                                        Komunitas</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kategori.index') }}">
                            <i class="iconoir-activity menu-icon"></i>
                            <span>Kelola Kategori Kegiatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('informasiBerita.create', 'informasiBerita.edit', 'informasiPengumuman.create', 'informasiPengumuman.edit') ? 'active' : '' }}" href="#sidebarInformasi" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarInformasi">
                            <i class="iconoir-info-circle menu-icon"></i>
                            <span>Kelola Informasi</span>
                        </a>
                        <div class="collapse {{ Route::is('informasiBerita.create', 'informasiBerita.edit', 'informasiPengumuman.create', 'informasiPengumuman.edit') ? 'show' : '' }}" area id="sidebarInformasi">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('informasiBerita' ,'informasiBerita.create', 'informasiBerita.edit') ? 'active' : '' }}"
                                        href="{{ route('informasiBerita') }}">
                                        Kelola Berita</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('informasiPengumuman', 'informasiPengumuman.create', 'informasiPengumuman.edit') ? 'active' : '' }}" href="{{ route('informasiPengumuman') }}">
                                        Kelola Pengumuman</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboardLokal') }}">
                            <i class="iconoir-home-simple menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('memberLokal.detail', 'memberLokal.edit', 'memberLokal.create') ? 'active' : '' }}"
                            href="{{ route('memberLokal') }}">
                            <i class="iconoir-group menu-icon"></i>
                            <span>Kelola Member</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('laporanLokal') ? 'active' : '' }}"
                            href="{{ route('laporanLokal') }}">
                            <i class="iconoir-book menu-icon"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    @endif
                </ul><!--end navbar-nav--->
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
