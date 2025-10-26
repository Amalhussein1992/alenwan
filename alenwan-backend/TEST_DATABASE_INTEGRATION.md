# Database Integration Test Guide

## ✅ What Was Updated

### 1. MoviesController (app/Http/Controllers/Admin/MoviesController.php)
- ✅ **index()** - Fetches movies from database with pagination, search, and filters
- ✅ **store()** - Saves new movies to database with file upload
- ✅ **show()** - Retrieves single movie from database
- ✅ **edit()** - Gets movie for editing from database
- ✅ **update()** - Updates movie in database with file management
- ✅ **destroy()** - Deletes movie from database with file cleanup
- ✅ **bulkAction()** - Bulk operations (publish, draft, delete)

### 2. Index View (resources/views/admin/movies/index.blade.php)
- ✅ Updated to show real database statistics
- ✅ Fixed poster display to use `poster_path`
- ✅ Fixed duration to use `duration_minutes`
- ✅ Fixed views count to use `views_count`
- ✅ Already has pagination support

## 🧪 How to Test

### Step 1: Start Laravel Server
```bash
cd C:\Users\HP\Desktop\flutter\alenwan-backend
php artisan serve
```

### Step 2: Visit Movie Index
Open browser: http://localhost:8000/admin/movies

**Expected Results:**
- Should show 4 existing movies from database:
  - Test Movie - Inception (Rating: 8.8)
  - The Dark Knight (Rating: 9.0)
  - Interstellar (Rating: 8.6)
  - Tenet (Rating: 7.5)
- Statistics cards showing real counts
- Search and filter working

### Step 3: Create New Movie
1. Visit: http://localhost:8000/admin/movies/create
2. Fill form with:
   - Title: Oppenheimer
   - Description: The story of American scientist J. Robert Oppenheimer
   - Genre: Drama, Biography
   - Duration: 180
   - Year: 2023
   - Rating: 8.3
   - Status: published
3. Submit form
4. Should redirect to index with new movie shown

### Step 4: Verify in Database
```bash
php artisan tinker
```

```php
// Count all movies
App\Models\Movie::count();
// Should return 5

// Get latest movie
App\Models\Movie::latest()->first();
// Should show Oppenheimer

// Search movies
App\Models\Movie::where('title', 'like', '%Open%')->get();
```

## 📝 Database Fields Mapping

| Form Field | Database Column | Type | Notes |
|------------|----------------|------|-------|
| title | title | string | Required |
| description | description | text | Required |
| genre | genres | json | Converted to array |
| duration | duration_minutes | integer | In minutes |
| year | release_year | integer | Required |
| rating | rating | decimal | 0-10 scale |
| poster | poster_path | string | File upload |
| trailer_url | trailer_url | string | URL |
| video_url | video_path | string | URL |
| status | status | enum | draft/published/archived |
| category_id | category_id | foreign key | Optional |
| language_id | language_id | foreign key | Optional |

## 🔍 Test Checklist

- [ ] Index page loads without errors
- [ ] Shows movies from database
- [ ] Statistics show correct counts
- [ ] Search functionality works
- [ ] Status filter works
- [ ] Pagination works
- [ ] Create form saves to database
- [ ] Edit form updates database
- [ ] Delete removes from database
- [ ] Bulk actions work
- [ ] File uploads work for posters

## 🚨 Troubleshooting

### Issue: "Column not found" errors
**Solution:** Check that Movie model has correct $fillable array

### Issue: "Storage link not found"
**Solution:** Run:
```bash
php artisan storage:link
```

### Issue: Images not showing
**Solution:** Make sure storage is linked and files are in `storage/app/public/posters`

### Issue: Genres showing as JSON
**Solution:** Check Movie model has `$casts = ['genres' => 'array']`

## 🎉 Success Criteria

All these should work:
1. ✅ Movies display from database
2. ✅ Statistics are accurate
3. ✅ Create form saves successfully
4. ✅ Search filters results
5. ✅ Edit updates records
6. ✅ Delete removes records
7. ✅ Pagination works
8. ✅ File uploads work
