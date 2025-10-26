@extends('admin.layouts.app')

@section('title', 'Create New User')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">Create New User</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.users.index') }}" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>Back to Users
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        <div class="row">
            <div class="col-xl-8">
                <div class="card-modern mb-4 animate-slide-in">
                    <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                        <i class="fas fa-user me-2 text-primary"></i>User Information
                    </h5>

                    <div class="mb-3">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required style="border-radius: 10px;" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address *</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required style="border-radius: 10px;" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required style="border-radius: 10px;">
                        <small class="text-muted">Minimum 8 characters</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" style="border-radius: 10px;">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card-modern">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-success-modern">
                            <i class="fas fa-check me-2"></i>Create User
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection