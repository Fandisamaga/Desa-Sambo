# TODO: Perbaikan URL dokumen publik (PPID)

- [x] 1. Perbaiki `documentUrl()` di `app/Http/Controllers/PublicPageController.php` agar memakai domain aktif (`url()`) bukan `Storage::url()` / `APP_URL`
- [x] 2. Perbaiki link file di `resources/views/admin/resources/show.blade.php` (`asset('storage/...')` → `url('storage/...')`)
- [x] 3. Perbaiki link file di `resources/views/admin/resources/form.blade.php` (`asset('storage/...')` → `url('storage/...')`)
- [x] 4. (Opsional) Update `APP_URL` di environment Railway & `php artisan config:clear` — tidak wajib lagi karena link kini memakai domain aktif (`url()`); tetap disarankan agar konsisten dengan URL lain seperti email/asset

