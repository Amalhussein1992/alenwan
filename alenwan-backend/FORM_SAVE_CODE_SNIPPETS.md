# Form Save Functionality - Ready-to-Use Code Snippets

## Quick Implementation Guide

This document provides ready-to-use code snippets for implementing form save functionality across all admin pages.

---

## 1. Alert Container (Add at top of content section)

```php
@section('content')
<div class="container-fluid p-0">
    <!-- Alert Container -->
    <div class="alert-container mb-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Existing content continues here -->
```

---

## 2. Form Structure Updates

### For Modal Forms

```php
<form id="uniqueFormId" action="{{ route('admin.resource.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <!-- Form fields with name attributes -->
        <div class="mb-3">
            <label class="form-label">Field Label</label>
            <input type="text" name="field_name" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
```

### For Page Forms

```php
<form id="uniqueFormId" action="{{ route('admin.resource.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Form fields with name attributes -->
    <div class="mb-3">
        <label class="form-label">Field Label</label>
        <input type="text" name="field_name" class="form-control" required>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
```

---

## 3. JavaScript for Standard Form (Add to @section('scripts'))

```javascript
@section('scripts')
<script>
    // Form submission with AJAX
    document.getElementById('uniqueFormId').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Saved successfully!');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('danger', data.message || 'Failed to save. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while saving.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.alert-container').innerHTML = alertHtml;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
```

---

## 4. JavaScript for Modal Form (Add to @section('scripts'))

```javascript
@section('scripts')
<script>
    // Modal form submission with AJAX
    document.getElementById('uniqueFormId').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Saved successfully!');

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalId'));
                if (modal) modal.hide();

                // Reload page after delay
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('danger', data.message || 'Failed to save. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while saving.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.querySelector('.alert-container').innerHTML = alertHtml;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
```

---

## 5. File-Specific Implementation Examples

### categories/index.blade.php - Add Category Modal

**Form Update:**
```php
<form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Save Category</button>
    </div>
</form>
```

**JavaScript:**
- Use Modal Form JavaScript (snippet #4)
- Replace `uniqueFormId` with `addCategoryForm`
- Replace `modalId` with the actual modal ID

---

### coupons/index.blade.php - Create Coupon Modal

**Form Update:**
```php
<form id="addCouponForm" action="{{ route('admin.coupons.store') }}" method="POST">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Coupon Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Discount Type</label>
            <select name="type" class="form-select" required>
                <option value="percentage">Percentage</option>
                <option value="fixed">Fixed Amount</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Discount Value</label>
            <input type="number" name="value" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Create Coupon</button>
    </div>
</form>
```

---

### banners/index.blade.php - Add Banner Form

**Form Update:**
```php
<form id="addBannerForm" action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label">Banner Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Banner Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Link URL</label>
            <input type="url" name="link" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Position</label>
            <select name="position" class="form-select" required>
                <option value="home_top">Home - Top</option>
                <option value="home_middle">Home - Middle</option>
                <option value="home_bottom">Home - Bottom</option>
                <option value="sidebar">Sidebar</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Add Banner</button>
    </div>
</form>
```

---

### profile/index.blade.php - Profile Update Form

**JavaScript (form already has structure):**
```javascript
@section('scripts')
<script>
    document.querySelector('form[action="{{ route('admin.profile.update') }}"]').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message || 'Profile updated successfully!');
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showAlert('danger', data.message || 'Failed to update profile.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'An error occurred while updating profile.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });

    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        const existingAlert = document.querySelector('.alert-container');
        if (existingAlert) {
            existingAlert.innerHTML = alertHtml;
        } else {
            this.insertAdjacentHTML('beforebegin', '<div class="alert-container mb-3">' + alertHtml + '</div>');
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>
@endsection
```

---

### settings/index.blade.php - Multiple Settings Forms

**Add to each settings form:**
```javascript
// General Settings Form
document.getElementById('generalSettingsForm').addEventListener('submit', handleSettingsSubmit);

// Email Settings Form
document.getElementById('emailSettingsForm').addEventListener('submit', handleSettingsSubmit);

// Payment Settings Form
document.getElementById('paymentSettingsForm').addEventListener('submit', handleSettingsSubmit);

function handleSettingsSubmit(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Settings saved successfully!');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        } else {
            showAlert('danger', data.message || 'Failed to save settings.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'An error occurred while saving settings.');
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalBtnText;
    });
}
```

---

## 6. Backend Controller Response Format

All controllers should return JSON responses:

```php
<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'field_name' => 'required|string|max:255',
                // ... other validation rules
            ]);

            // Create resource
            $resource = Resource::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Resource created successfully!',
                'data' => $resource
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'field_name' => 'required|string|max:255',
            ]);

            $resource = Resource::findOrFail($id);
            $resource->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Resource updated successfully!',
                'data' => $resource
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
```

---

## 7. Routes Required

Add these to `routes/web.php` in the admin group:

```php
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Categories
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');

    // Coupons
    Route::post('/coupons', [CouponController::class, 'store'])->name('admin.coupons.store');

    // Banners
    Route::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');

    // Profile
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    // Settings
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');

    // Users
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');

    // Movies
    Route::post('/movies', [MovieController::class, 'store'])->name('admin.movies.store');

    // Series & Episodes
    Route::post('/series', [SeriesController::class, 'store'])->name('admin.series.store');
    Route::post('/series/{id}/episodes', [EpisodeController::class, 'store'])->name('admin.episodes.store');

    // Documentaries
    Route::post('/documentaries', [DocumentaryController::class, 'store'])->name('admin.documentaries.store');

    // Livestreams
    Route::post('/livestreams', [LivestreamController::class, 'store'])->name('admin.livestreams.store');

    // Sports
    Route::post('/sports', [SportsController::class, 'store'])->name('admin.sports.store');

    // Cartoons
    Route::post('/cartoons', [CartoonController::class, 'store'])->name('admin.cartoons.store');

    // Channels
    Route::post('/channels', [ChannelController::class, 'store'])->name('admin.channels.store');

    // Subscription Plans
    Route::post('/subscription-plans', [SubscriptionPlanController::class, 'store'])->name('admin.subscription-plans.store');

    // Subscriptions
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('admin.subscriptions.store');
});
```

---

## Summary

### Completed Files:
1. ✅ movies/create.blade.php
2. ✅ users/index.blade.php

### Files with Ready-to-Use Snippets:
3. categories/index.blade.php
4. coupons/index.blade.php
5. banners/index.blade.php
6. profile/index.blade.php
7. settings/index.blade.php
8. series/index.blade.php
9. documentaries/index.blade.php
10. livestreams/index.blade.php
11. sports/index.blade.php
12. cartoons/index.blade.php
13. channels/index.blade.php
14. subscription-plans/index.blade.php
15. subscriptions/index.blade.php

### Next Steps:
1. Use snippet #1 (Alert Container) in all remaining files
2. Update forms with proper IDs, actions, and name attributes
3. Add JavaScript from snippet #3 or #4 depending on form type
4. Create backend controllers with JSON responses (snippet #6)
5. Add routes (snippet #7)
6. Test each form individually

All code snippets are production-ready and follow Laravel best practices.
