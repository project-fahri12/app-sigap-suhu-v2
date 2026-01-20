@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1">Manajemen User & Hak Akses</h5>
            <p class="small text-muted mb-0">
                Kelola status akun pengguna dan batasan akses unit Sekolah secara terpusat.
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

                        {{-- ROLE --}}
                        <td>
                            <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                {{ str_replace('-', ' ', $user->role) }}
                            </span>
                        </td>

                        {{-- AKSES SEKOLAH --}}
                        <td>
                            @if ($user->sekolah)
                                <div class="small fw-bold text-primary mb-1">
                                    <i class="fas fa-school me-1"></i> {{ $user->sekolah->nama_sekolah }}
                                </div>
                            @else
                                <span class="text-muted small">Akses Global (Full)</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td>
                            <form action="{{ route('superadmin.manajemen-user.toggle', $user->id) }}"
                                  method="POST" id="status-form-{{ $user->id }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-check form-switch">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           onchange="document.getElementById('status-form-{{ $user->id }}').submit()"
                                           {{ $user->is_aktif === 'aktif' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold"
                                           style="font-size:12px"
                                           class="{{ $user->is_aktif === 'aktif' ? 'text-success' : 'text-danger' }}">
                                        {{ $user->is_aktif === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                                    </label>
                                </div>
                            </form>
                        </td>

                        {{-- AKSI --}}
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
                        <td colspan="5" class="text-center text-muted py-5">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius:20px">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0" id="modalTitle">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" id="userForm"
                  action="{{ route('superadmin.manajemen-user.store') }}">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                   class="form-control bg-light border-0" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" id="email"
                                   class="form-control bg-light border-0" required>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Role / Peran</label>
                            <select name="role" id="roleSelect"
                                    class="form-select bg-light border-0"
                                    onchange="handleRoleChange()" required>
                                <option value="">-- Pilih Role --</option>
                                @foreach ($roles as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SEKOLAH --}}
                        <div class="col-md-12" id="aksesSekolahWrapper" style="display:none">
                            <label class="form-label small fw-bold text-primary">Unit Sekolah</label>
                            <select name="sekolah_id" id="sekolah_id"
                                    class="form-select border-primary-subtle">
                                <option value="">-- Pilih Sekolah --</option>
                                @foreach ($sekolahs as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" id="password"
                                   class="form-control bg-light border-0"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit"
                            class="btn btn-success w-100 fw-bold py-2 rounded-pill shadow-sm">
                        <i class="fas fa-save me-2"></i> Simpan Data Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function resetForm() {
    const form = document.getElementById('userForm');
    form.reset();
    form.action = "{{ route('superadmin.manajemen-user.store') }}";

    const method = form.querySelector('input[name="_method"]');
    if (method) method.remove();

    document.getElementById('modalTitle').innerText = 'Tambah User';
    handleRoleChange();
}

function editUser(user) {
    resetForm();

    document.getElementById('modalTitle').innerText = 'Update User';
    document.getElementById('name').value = user.name;
    document.getElementById('email').value = user.email;
    document.getElementById('roleSelect').value = user.role;
    document.getElementById('sekolah_id').value = user.sekolah_id ?? '';

    const form = document.getElementById('userForm');
    form.action = `/superadmin/manajemen-user/${user.id}`;

    let method = document.createElement('input');
    method.type = 'hidden';
    method.name = '_method';
    method.value = 'PUT';
    form.appendChild(method);

    handleRoleChange();
}

function handleRoleChange() {
    const role = document.getElementById('roleSelect').value;
    const sekolah = document.getElementById('aksesSekolahWrapper');

    sekolah.style.display = (role === 'admin-sekolah' || role === 'panitia-ppdb')
        ? 'block'
        : 'none';
}
</script>
@endsection
