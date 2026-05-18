#!/bin/bash
echo "🚀 Memulai proses deployment..."

# 1. Tarik kode terbaru dari GitHub
echo "📦 Menarik kode terbaru dari branch main..."
git pull origin main

# 2. Install dependensi PHP (Abaikan jika tidak ada perubahan composer.json)
echo "⚙️ Menginstall dependensi PHP (Composer)..."
composer install --optimize-autoloader --no-dev

# 3. Jalankan Migrasi Database secara paksa (tanpa prompt)
echo "🗄️ Menjalankan migrasi database..."
php artisan migrate --force

# 4. Bersihkan cache lama dan optimalkan Laravel
echo "🧹 Membersihkan dan mengoptimalkan cache framework..."
php artisan optimize:clear
php artisan optimize

echo "✅ Deployment selesai! Website sudah diperbarui."
