@echo off
echo 🚀 Memulai proses pengiriman update...

echo 📦 1/3: Merakit tampilan (NPM Build)...
call npm run build

echo 💾 2/3: Menyimpan perubahan...
git add .
git commit -m "Update sistem otomatis"

echo 🛰️ 3/3: Mengirim ke server (GitHub)...
git push origin main

echo ✅ BERHASIL! Sekarang tinggal ngetik "git pull" di terminal cPanel kamu.
pause
