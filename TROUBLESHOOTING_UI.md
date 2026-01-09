# 🔧 Troubleshooting UI Website

## ✅ **Perbaikan yang Sudah Dilakukan:**

### 1. **Base URL Configuration** ✅
File: `application/config/config.php`

**Sebelum:**
```php
$config['base_url'] = 'http://localhost/ecommerce-furniture';
```

**Sesudah (Auto-detect):**
```php
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
```

Sekarang base URL akan **otomatis menyesuaikan** dengan path server Anda.

---

## 🌐 **URL Path yang Benar:**

| Akses | URL |
|-------|-----|
| **Homepage** | http://localhost/furniture/ecommerce-furniture/ |
| **Login** | http://localhost/furniture/ecommerce-furniture/auth/login |
| **Register** | http://localhost/furniture/ecommerce-furniture/auth/register |
| **Admin** | http://localhost/furniture/ecommerce-furniture/dashboard |

---

## 🔄 **Langkah Clear Cache:**

### 1. **Clear Browser Cache**
```
Press: Ctrl + Shift + Delete
atau
Hard Refresh: Ctrl + F5
```

### 2. **Clear CodeIgniter Cache**
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture
Remove-Item -Recurse -Force application\cache\*
```

### 3. **Restart Apache/Laragon**
- Stop Laragon
- Start Laragon kembali

---

## 📂 **Verifikasi File Assets:**

### Cek apakah file berikut ada:

✅ `assets/frontend/js/slick.min.js`  
✅ `assets/frontend/js/scripts.js`  
✅ `assets/frontend/js/jquery-1.12.4.min.js`  
✅ `assets/all/sweetalert2/sweetalert2.all.min.js`  
✅ `assets/all/sweetalert2/sweetalert2.min.css`

---

## 🚨 **Common Errors & Solutions:**

### Error: "404 Not Found - JS/CSS Files"
**Cause:** Base URL tidak match dengan path server  
**Solution:** ✅ **SUDAH DIPERBAIKI** - Auto-detect base URL aktif

### Error: "Swal is not defined"
**Cause:** SweetAlert2 belum ter-load  
**Solution:** 
1. Pastikan file ada di `assets/all/sweetalert2/`
2. Clear cache browser (Ctrl + F5)
3. Cek console browser untuk error lainnya

### Error: "Headers already sent"
**Cause:** Output sebelum CodeIgniter load  
**Solution:** ✅ **SUDAH DIPERBAIKI** - `ob_start()` sudah ada di `index.php`

### Error: "Blank Page / White Screen"
**Cause:** PHP Error tidak ditampilkan  
**Solution:**
```php
// Edit index.php
define('ENVIRONMENT', 'development'); // Change to development
```

---

## 🧪 **Test Base URL:**

Buka file: `application/views/frontend/template.php` atau view lainnya

Tambahkan di bagian atas:
```php
<?php
echo "Base URL: " . base_url();
echo "<br>";
echo "Site URL: " . site_url();
?>
```

---

## 🔍 **Check Console Browser:**

1. Buka browser (Chrome/Firefox/Edge)
2. Tekan **F12** untuk buka Developer Tools
3. Tab **Console** - Lihat error JavaScript
4. Tab **Network** - Lihat file mana yang 404

---

## ⚡ **Quick Fix Commands:**

### Clear All Cache
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture
Remove-Item -Recurse -Force application\cache\sessions\*
Remove-Item -Recurse -Force application\cache\*
```

### Check File Permissions (jika perlu)
```powershell
# Set write permission untuk cache folder
icacls "application\cache" /grant Users:F /T
icacls "assets\uploads" /grant Users:F /T
```

### Restart PHP-FPM (Laragon)
1. Klik kanan icon Laragon
2. Stop All
3. Start All

---

## 📝 **Checklist Setelah Perbaikan:**

- [ ] Refresh browser dengan **Ctrl + F5**
- [ ] Cek console browser (F12) - Tidak ada error 404
- [ ] UI website tampil dengan benar
- [ ] CSS ter-load sempurna
- [ ] JavaScript berfungsi (slider, modal, dll)
- [ ] SweetAlert2 berfungsi
- [ ] Gambar produk tampil

---

## 🎯 **Expected Result:**

Setelah refresh browser, website seharusnya:
- ✅ UI tampil sempurna dengan CSS
- ✅ Semua JavaScript library ter-load
- ✅ Slider/carousel berfungsi
- ✅ Modal/popup berfungsi
- ✅ Tidak ada error 404 di console

---

**Last Updated:** January 9, 2026  
**Status:** ✅ **FIXED** - Auto-detect base URL enabled
