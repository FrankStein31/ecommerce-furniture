# 🚀 Cara Menjalankan Server API

## ⚡ Quick Start

### 1. Aktivasi Virtual Environment & Jalankan Server

**PowerShell:**
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture\cf-ml
c:\laragon\www\furniture\ecommerce-furniture\cf-ml\venv\Scripts\uvicorn.exe main:app --reload --host 0.0.0.0 --port 8000
```

**Atau dengan environment variable:**
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture\cf-ml
$env:PYTHONPATH = "c:\laragon\www\furniture\ecommerce-furniture\cf-ml"
.\venv\Scripts\uvicorn.exe main:app --reload --host 0.0.0.0 --port 8000
```

### 2. Akses API

- **Base URL**: http://localhost:8000
- **Dokumentasi Swagger**: http://localhost:8000/docs
- **Dokumentasi ReDoc**: http://localhost:8000/redoc

---

## 📋 Setup Awal (Hanya Sekali)

### 1. Install Virtual Environment
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture\cf-ml
python -m venv venv
```

### 2. Aktivasi Virtual Environment
```powershell
# PowerShell
.\venv\Scripts\Activate.ps1

# CMD
venv\Scripts\activate.bat
```

### 3. Install Dependencies
```powershell
pip install --upgrade pip
pip install -r requirements.txt
```

### 4. Verifikasi Instalasi
```powershell
pip list
```

---

## 🔧 Command Reference

### Aktivasi Virtual Environment
```powershell
# PowerShell
.\venv\Scripts\Activate.ps1

# CMD
venv\Scripts\activate.bat
```

### Deaktivasi Virtual Environment
```powershell
deactivate
```

### Install Package Baru
```powershell
.\venv\Scripts\pip.exe install nama-package
```

### Update requirements.txt
```powershell
.\venv\Scripts\pip.exe freeze > requirements.txt
```

### Jalankan Server (Development Mode)
```powershell
.\venv\Scripts\uvicorn.exe main:app --reload --host 0.0.0.0 --port 8000
```

### Jalankan Server (Production Mode)
```powershell
.\venv\Scripts\uvicorn.exe main:app --host 0.0.0.0 --port 8000 --workers 4
```

---

## 🧪 Test API Endpoints

### 1. Get Jenis Perbaikan
```powershell
curl http://localhost:8000/jenis-perbaikan
```

### 2. Get Kode Jenis Perbaikan
```powershell
curl http://localhost:8000/kode/jenis-perbaikan
```

### 3. Get Kode Gejala Kerusakan
```powershell
curl http://localhost:8000/kode/gejala-kerusakan
```

### 4. Get Kode Jenis Kerusakan
```powershell
curl http://localhost:8000/kode/jenis-kerusakan
```

### 5. Get Kode Rekomendasi
```powershell
curl http://localhost:8000/kode/rekomendasi
```

### 6. POST Rekomendasi (Forward Chaining + Certainty Factor)
```powershell
curl -X POST http://localhost:8000/rekomendasi -H "Content-Type: application/json" -d '{\"gejala_kerusakan\":\"kain sobek\",\"jenis_kerusakan\":\"rusak\",\"jenis_perbaikan\":\"Sofa\",\"cf_user\":0.8}'
```

---

## 🐛 Troubleshooting

### Error: "Cannot be loaded because running scripts is disabled"
**Solusi:**
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

### Error: "Module not found"
**Solusi:**
```powershell
cd c:\laragon\www\furniture\ecommerce-furniture\cf-ml
pip install -r requirements.txt
```

### Server tidak bisa diakses dari luar
**Solusi:** Gunakan `--host 0.0.0.0` untuk bind ke semua network interfaces

---

## 📊 Struktur Virtual Environment

```
venv/
├── Scripts/           # Executable files (python.exe, pip.exe, uvicorn.exe)
├── Lib/              # Python libraries
│   └── site-packages/ # Installed packages
├── Include/          # C headers
└── pyvenv.cfg        # Virtual environment configuration
```

---

## 💡 Tips

1. **Selalu aktifkan venv** sebelum install package baru
2. **Update requirements.txt** setiap kali install package baru
3. **Gunakan --reload** saat development untuk auto-restart
4. **Gunakan --workers** saat production untuk handle multiple requests
5. **Check logs** di terminal untuk troubleshooting

---

## ⚙️ Environment Variables (Optional)

Buat file `.env` untuk konfigurasi:
```env
API_HOST=0.0.0.0
API_PORT=8000
DEBUG_MODE=True
```

---

**Python Version:** 3.10.6  
**FastAPI Version:** 0.104.1  
**Uvicorn Version:** 0.24.0
