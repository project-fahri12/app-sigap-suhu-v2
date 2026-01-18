@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manajemen User & Hak Akses</h5>
            <p class="small text-muted mb-0">
                Kelola status akun pengguna dan batasan akses unit Sekolah atau Pondok secara terpusat.
            </p>
        </div>
        <button class="btn btn-success fw-bold px-4 rounded-pill"
                data-bs-toggle="modal"
                data-bs-target="#modalUser"
                onclick="resetForm()">
            <i class="fas fa-plus me-2"></i> Tambah User
        </button>
    </div>

    {{-- TABLE --}}
    <div class="card border-0 shadow-sm" style="border-radius:15px;">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr style="font-size:12px;color:#64748b;text-transform:uppercase;">
                        <th class="ps-4">Nama Pengguna</th>
                        <th>Role / Peran</th>
                        <th>Hak Akses Unit</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>

                <tbody style="font-size:14px;">
                @forelse ($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark text-uppercase">{{ $user->name }}</div>
                            <div class="text-muted" style="font-size:11px">{{ $user->email }}</div>
                        </td>

                        <td>
                            @foreach ($user->roles as $role)
                                <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                    {{ $role->label ?? $role->name }}
                                </span>
                            @endforeach
                        </td>

                        <td>
                            {{-- Akses Sekolah --}}
                            @foreach ($user->sekolah ?? [] as $s)
                                <div class="small fw-bold text-primary mb-1">
                                    <i class="fas fa-school me-1"></i> {{ $s->nama_sekolah }}
                                </div>
                            @endforeach

                            {{-- Akses Pondok --}}
                            @foreach ($user->pondok ?? [] as $p)
                                <div class="small fw-bold text-warning mb-1">
                                    <i class="fas fa-mosque me-1"></i> {{ $p->nama_pondok }}
                                </div>
                            @endforeach

                            @if(($user->sekolah?->isEmpty() ?? true) && ($user->pondok?->isEmpty() ?? true))
                                <span class="text-muted small">Akses Global (Full)</span>
                            @endif
                        </td>

                        {{-- TOGGLE AKTIF / OFF --}}
                        <td>
                            <form action="{{ route('superadmin.manajemen-user.toggle', $user->id) }}" method="POST" id="status-form-{{ $user->id }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           onchange="document.getElementById('status-form-{{ $user->id }}').submit()"
                                           {{ $user->is_aktif ? 'checked' : '' }}>
                                    <label class="form-check-label {{ $user->is_aktif ? 'text-success' : 'text-danger' }} fw-bold" style="font-size: 12px">
                                        {{ $user->is_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </label>
                                </div>
                            </form>
                        </td>

                        <td class="text-end pe-4">
                            <button class="btn btn-light btn-sm text-primary rounded-circle me-1"
                                    onclick='editUser(@json($user))'
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalUser">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('superadmin.manajemen-user.destroy', $user->id) }}"
                                  method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-sm text-danger rounded-circle"
                                        onclick="return confirm('Hapus user ini selamanya?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">Belum ada data user.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL FORM --}}
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0" id="modalTitle">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="userForm" action="{{ route('superadmin.manajemen-user.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control bg-light border-0" placeholder="Masukkan nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Email</label>
                            <input type="email" name="email" id="email" class="form-control bg-light border-0" placeholder="user@example.com" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-dark">Role / Peran</label>
                            <select name="role_id" id="roleSelect" class="form-select bg-light border-0" onchange="handleRoleChange()" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->id }}">{{ $r->label ?? $r->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SELECTION UNIT --}}
                        <div class="col-md-12" id="aksesSekolahWrapper" style="display:none">
                            <label class="form-label small fw-bold text-primary">Unit Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id" class="form-select border-primary-subtle">
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach ($sekolahs as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12" id="aksesPondokWrapper" style="display:none">
                            <label class="form-label small fw-bold text-warning">Unit Pondok</label>
                            <select name="pondok_id" id="pondok_id" class="form-select border-warning-subtle">
                                <option value="">-- Pilih Pondok --</option>
                                @foreach ($pondoks as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pondok }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-dark">Password</label>
                            <input type="password" name="password" id="password" class="form-control bg-light border-0" placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Data Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function resetForm() {
    const form = document.getElementById('userForm');
    form.reset();
    form.action = "{{ route('superadmin.manajemen-user.store') }}";
    
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    document.getElementById('modalTitle').innerText = 'Tambah User';
    handleRoleChange();
}

function editUser(user) {
    resetForm();
    document.getElementById('modalTitle').innerText = 'Update User & Hak Akses';
    document.getElementById('name').value = user.name;
    document.getElementById('email').value = user.email;
    document.getElementById('userForm').action = `/superadmin/manajemen-user/${user.id}`;

    // Tambah Method PUT
    let method = document.createElement('input');
    method.type = 'hidden'; 
    method.name = '_method'; 
    method.value = 'PUT';
    document.getElementById('userForm').appendChild(method);

    // Set Role
    if (user.roles && user.roles.length > 0) {
        document.getElementById('roleSelect').value = user.roles[0].id;
    }

    handleRoleChange();

    // Set Unit Sekolah/Pondok
    if (user.sekolah && user.sekolah.length > 0) {
        document.getElementById('sekolah_id').value = user.sekolah[0].id;
    }
    if (user.pondok && user.pondok.length > 0) {
        document.getElementById('pondok_id').value = user.pondok[0].id;
    }
}

function handleRoleChange() {
    let role = document.getElementById('roleSelect').value;
    
    // Sesuaikan dengan ID di tabel 'roles' Anda
    // Contoh: 2 = Admin Sekolah, 3 = Admin Pondok, 4 = Panitia
    const isSekolah = (role == 2 || role == 4);
    const isPondok = (role == 3);

    document.getElementById('aksesSekolahWrapper').style.display = isSekolah ? 'block' : 'none';
    document.getElementById('aksesPondokWrapper').style.display = isPondok ? 'block' : 'none';
}
</script>
@endsection