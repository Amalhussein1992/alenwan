@extends('admin.layouts.app')

@section('title', 'View User')

@section('content')
<div class="container-fluid p-0">
    <div class="mb-4 animate-fade-in">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0" style="color: var(--text-primary); font-weight: 700;">User Details</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-modern btn-primary me-2">
                    <i class="fas fa-edit me-2"></i>Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card-modern mb-4 animate-slide-in">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-user me-2 text-primary"></i>User Information
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Full Name</label>
                        <p class="fw-bold mb-0">{{ $user->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Email Address</label>
                        <p class="fw-bold mb-0">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Role</label>
                        <p class="mb-0">
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-primary">User</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Email Verified</label>
                        <p class="mb-0">
                            @if($user->email_verified_at)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning">Not Verified</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label class="text-muted small">Member Since</label>
                        <p class="fw-bold mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Last Updated</label>
                        <p class="fw-bold mb-0">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card-modern mb-4 animate-slide-in">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                    <i class="fas fa-bolt me-2 text-warning"></i>Quick Actions
                </h5>

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection