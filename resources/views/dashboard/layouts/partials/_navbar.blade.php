<header class="navbar navbar-expand">
    <button class="btn btn-light d-lg-none me-3" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <h6 class="mb-0 fw-800 text-dark">
        @if(auth()->user()->hasRole('super-admin'))
            Global System Control
        @elseif(auth()->user()->hasRole('admin-sekolah'))
            School Management System
        @else
            Staff Dashboard
        @endif
    </h6>

    <div class="ms-auto">
        <div class="dropdown profile-dropdown">
            <div class="d-flex align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="text-end me-3 d-none d-sm-block">
                    <p class="mb-0 small fw-bold text-dark text-uppercase">{{ auth()->user()->name }}</p>
                    
                    <span class="badge bg-success-subtle text-success" style="font-size: 10px; text-transform: uppercase;">
                        {{ auth()->user()->roles->first()->label ?? 'STAFF' }}
                    </span>
                </div>
                
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=198754&color=fff"
                     class="rounded-circle border border-2 border-success-subtle" width="40"
                     alt="Admin Profile">
            </div>
            
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <h6 class="dropdown-header">Pengaturan Akun</h6>
                </li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Profil Saya</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-key me-2"></i> Ganti Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>