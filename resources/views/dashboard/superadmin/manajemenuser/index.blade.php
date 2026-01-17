@extends('dashboard.layouts.app')

@section('content')
    <div class="content-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Manajemen User & Hak Akses</h5>
                <p class="small text-muted mb-0">
                    Atur pengguna, peranan (role), dan batasan akses data lembaga.
                </p>
            </div>
            <button class="btn btn-success fw-bold px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalUser"
                onclick="resetForm()">
                <i class="fas fa-plus me-2"></i> Tambah User
            </button>
        </div>

        {{-- TABLE --}}
        <div class="module-card shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr style="font-size:12px;color:#64748b;text-transform:uppercase;">
                            <th class="ps-3">Nama Pengguna</th>
                            <th>Role / Peran</th>
                            <th>Hak Akses Data</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody style="font-size:14px;">
                        @forelse ($users as $user)
                            <tr>
                                {{-- NAMA --}}
                                <td class="ps-3">
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                    <div class="text-muted" style="font-size:11px">{{ $user->email }}</div>
                                </td>

                                {{-- ROLE --}}
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-info-subtle text-info px-3 py-2 rounded-pill mb-1">
                                            {{ $role->label ?? $role->name }}
                                        </span>
                                    @endforeach
                                </td>

                                {{-- AKSES --}}
                                <td>
                                    @if ($user->userSekolah)
                                        <div class="fw-bold small">
                                            <i class="fas fa-school me-1"></i>
                                            {{ $user->userSekolah->sekolah->nama_sekolah }}
                                        </div>
                                    @endif

                                    @foreach ($user->userPondoks as $p)
                                        <div class="fw-bold small mt-1">
                                            <i class="fas fa-mosque me-1"></i>
                                            {{ $p->pondok->nama_pondok }}
                                        </div>
                                    @endforeach
                                </td>

                                {{-- STATUS --}}
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox"
                                            {{ $user->is_aktif ? 'checked' : '' }} disabled>
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-end pe-3">
                                    <button class="btn btn-light btn-sm text-primary"
                                        onclick='editUser(@json($user))' data-bs-toggle="modal"
                                        data-bs-target="#modalUser">
                                        <i class="fas fa-key"></i>
                                    </button>

                                    <form action="{{ route('superadmin.manajemenuser.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-light btn-sm text-danger"
                                            onclick="return confirm('Hapus user ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data user
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

                <form method="POST" id="userForm" action="{{ route('superadmin.manajemenuser.store') }}">
                    @csrf
                    <input type="hidden" id="formMethod">
                    <div class="modal-body p-4">
                        <div class="row g-3">

                            <input type="hidden" id="user_id">

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Role</label>
                                <select name="role_id" id="roleSelect" class="form-select" onchange="handleRoleChange()"
                                    required>
                                    <option value="">Pilih Role</option>
                                    @foreach ($roles as $r)
                                        <option value="{{ $r->id }}">{{ $r->label ?? $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6" id="aksesSekolahWrapper" style="display:none">
                                <label class="form-label small fw-bold">Sekolah</label>
                                <select name="sekolah_id" id="sekolah_id" class="form-select">
                                    <option value="">Pilih Sekolah</option>
                                    @foreach ($sekolahs as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama_sekolah }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6" id="aksesPondokWrapper" style="display:none">
                                <label class="form-label small fw-bold">Pondok</label>
                                <select name="pondok_id" id="pondok_id" class="form-select">
                                    <option value="">Pilih Pondok</option>
                                    @foreach ($pondoks as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_pondok }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
        function resetForm() {
            document.getElementById('userForm').action = "{{ route('superadmin.manajemenuser.store') }}"
            document.getElementById('formMethod').remove()
            document.getElementById('userForm').reset()
            document.getElementById('modalTitle').innerText = 'Tambah User'
            handleRoleChange()
        }

        function editUser(user) {
            resetForm()
            document.getElementById('modalTitle').innerText = 'Edit Hak Akses'

            document.getElementById('name').value = user.name
            document.getElementById('email').value = user.email

            document.getElementById('userForm').action =
                `/superadmin/manajemen-user/${user.id}`

            let method = document.createElement('input')
            method.type = 'hidden'
            method.name = '_method'
            method.value = 'PUT'
            method.id = 'formMethod'
            document.getElementById('userForm').appendChild(method)

            if (user.roles.length) {
                document.getElementById('roleSelect').value = user.roles[0].id
            }

            handleRoleChange()

            if (user.user_sekolah) {
                document.getElementById('sekolah_id').value = user.user_sekolah.sekolah_id
            }

            if (user.user_pondoks.length) {
                document.getElementById('pondok_id').value = user.user_pondoks[0].pondok_id
            }
        }

        function handleRoleChange() {
            let role = document.getElementById('roleSelect').value
            document.getElementById('aksesSekolahWrapper').style.display =
                (role == 2 || role == 4) ? 'block' : 'none'
            document.getElementById('aksesPondokWrapper').style.display =
                (role == 3) ? 'block' : 'none'
        }
    </script>
@endsection
