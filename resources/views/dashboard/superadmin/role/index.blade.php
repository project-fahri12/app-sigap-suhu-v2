@extends('dashboard.layouts.app')

@section('content')
<div class="content-body">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-800 mb-1">Master Role</h5>
            <p class="small text-muted mb-0">
                Kelola role sesuai kebutuhan yayasan / lembaga
            </p>
        </div>
        <button
            class="btn btn-success btn-sm px-4 fw-bold shadow-sm rounded-pill"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahRole">
            + Tambah Role
        </button>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- CARD TABLE --}}
    <div class="module-card shadow-sm p-0 overflow-hidden border-0 bg-white">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="bg-light">
                    <tr style="font-size: 11px; color: #64748b; text-transform: uppercase; letter-spacing: 1px;">
                        <th class="ps-4 py-3">Role (System)</th>
                        <th>Label</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px;">
                    @forelse ($roles as $role)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-800 text-muted">{{ $role->name }}</span>
                            </td>
                            <td>{{ $role->label }}</td>
                            <td class="text-end pe-4">

                                {{-- EDIT --}}
                                <button
                                    class="btn btn-light btn-sm text-primary rounded-3 me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditRole{{ $role->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                {{-- DELETE --}}
                                <form action="{{ route('superadmin.role.destroy', $role->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus role ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-light btn-sm text-danger rounded-3">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        {{-- MODAL EDIT ROLE --}}
                        <div class="modal fade" id="modalEditRole{{ $role->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                    <div class="modal-header border-0 p-4 pb-0">
                                        <h5 class="fw-800 mb-0">Edit Role</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form action="{{ route('superadmin.role.update', $role->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-body p-4">
                                            <div class="row g-3 mb-3">
                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">
                                                        Role
                                                    </label>
                                                    <input type="text"
                                                           name="role"
                                                           value="{{ $role->name }}"
                                                           class="form-control bg-light border-light py-2"
                                                           style="border-radius: 12px;"
                                                           required>
                                                </div>

                                                <div class="col-6">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">
                                                        Label
                                                    </label>
                                                    <input type="text"
                                                           name="label"
                                                           value="{{ $role->label }}"
                                                           class="form-control bg-light border-light py-2"
                                                           style="border-radius: 12px;"
                                                           required>
                                                </div>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit"
                                                        class="btn btn-primary fw-800 py-3 shadow"
                                                        style="border-radius: 15px;">
                                                    Update Role
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Belum ada data role
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH ROLE --}}
<div class="modal fade" id="modalTambahRole" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-800 mb-0">Form Tambah Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('superadmin.role.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">
                                Role (System)
                            </label>
                            <input type="text"
                                   name="role"
                                   class="form-control bg-light border-light py-2"
                                   style="border-radius: 12px;"
                                   placeholder="contoh: admin_lembaga"
                                   required>
                        </div>

                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">
                                Label
                            </label>
                            <input type="text"
                                   name="label"
                                   class="form-control bg-light border-light py-2"
                                   style="border-radius: 12px;"
                                   placeholder="Admin Lembaga"
                                   required>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4">
                        <small class="text-muted" style="font-size: 11px;">
                            <i class="fas fa-info-circle me-1 text-primary"></i>
                            Gunakan snake_case untuk role (tanpa spasi)
                        </small>
                    </div>

                    <div class="d-grid">
                        <button type="submit"
                                class="btn btn-success fw-800 py-3 shadow"
                                style="border-radius: 15px;">
                            Simpan Role
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
