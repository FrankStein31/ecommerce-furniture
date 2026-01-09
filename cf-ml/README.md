# SPK Rekomendasi Perbaikan Perabotan Rumah Tangga

Sistem Pendukung Keputusan (SPK) untuk memberikan rekomendasi perbaikan perabotan rumah tangga menggunakan kombinasi tiga metode: **Forward Chaining**, **Certainty Factor**, dan **Decision Tree (Machine Learning)**.

> 🎓 **Skripsi:** Analisis Perbandingan Metode Forward Chaining dan Certainty Factor pada Sistem Pakar Rekomendasi Perbaikan Mebel

---

## 📋 Daftar Isi

1. [Deskripsi Project](#deskripsi-project)
2. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
3. [Struktur Project](#struktur-project)
4. [Instalasi](#instalasi)
5. [Cara Menjalankan](#cara-menjalankan)
6. [Quick Start](#quick-start)
6. [Dokumentasi Modul](#dokumentasi-modul)
7. [API Endpoint](#api-endpoint)
8. [Metodologi](#metodologi)
9. [Contoh Penggunaan](#contoh-penggunaan)

---

## 🎯 Deskripsi Project

Sistem ini menganalisis input berupa:
- **Gejala Kerusakan** - Gejala yang terlihat pada perabotan
- **Jenis Kerusakan** - Tipe kerusakan yang terjadi
- **Jenis Perbaikan** - Kategori perbaikan yang diperlukan

Kemudian memberikan output berupa:
- **Rekomendasi Perbaikan** - Solusi yang disarankan
- **Estimasi Biaya** - Perkiraan biaya perbaikan
- **Estimasi Waktu** - Perkiraan waktu pengerjaan
- **Perbandingan Metode** - Hasil dari 3 metode dengan confidence score

---

## 🛠 Teknologi yang Digunakan

- **Python 3.10+**
- **FastAPI** - Web framework untuk REST API
- **Pandas** - Data processing dan manipulation
- **Scikit-learn** - Machine Learning (Decision Tree)
- **Openpyxl** - Excel file reading
- **Uvicorn** - ASGI server

---

## 📁 Struktur Project

```
cf-ml/
│
├── main.py                 # Entry point FastAPI application
├── data_loader.py          # Module untuk load dan preprocessing data
├── utils.py                # Utility functions (feature extraction, vectorization)
├── ml_model.py             # Decision Tree model class
├── rules_engine.py         # Forward Chaining dan Certainty Factor engine
├── requirements.txt        # Python dependencies
├── data_skripsi.xlsx       # Dataset Excel
└── README.md               # Dokumentasi project
```

### Penjelasan File:

#### 1. **main.py**
File utama yang mengatur FastAPI application dan endpoint API. Melakukan inisialisasi semua modul dan menangani request/response.

#### 2. **data_loader.py**
Module untuk:
- Load data dari file Excel
- Preprocessing dan rename kolom
- Membuat mapping output (biaya dan waktu)

#### 3. **utils.py**
Berisi utility functions:
- `split_phrases()` - Memecah text menjadi list phrases
- `build_feature_vocabulary()` - Membuat vocabulary dari semua fitur
- `row_to_vector()` - Convert data row ke feature vector
- `phrases_to_vector()` - Convert input phrases ke feature vector
- `build_dataset()` - Membuat dataset untuk training

#### 4. **ml_model.py**
Class untuk Decision Tree Classifier:
- `train()` - Training model
- `predict()` - Prediksi rekomendasi
- `get_confidence()` - Mendapatkan confidence score

#### 5. **rules_engine.py**
Class untuk rules-based methods:
- `forward_chaining()` - Implementasi Forward Chaining
- `certainty_factor()` - Implementasi Certainty Factor
- `_build_rules()` - Build rules dari dataset

---

## 💻 Instalasi

### Step 1: Clone atau Download Project
```bash
cd c:\Users\Ryanh\Project\cf-ml
```

### Step 2: Install Dependencies
```bash
pip install -r requirements.txt
```

**Isi requirements.txt:**
```
fastapi
uvicorn[standard]
pandas
scikit-learn
openpyxl
pydantic
```

### Step 3: Persiapan Data
Pastikan file `data_skripsi.xlsx` berada di folder yang sama dengan main.py.

**Format Excel yang dibutuhkan:**
- Header dimulai dari baris ke-2
- Kolom yang diperlukan:
  - ID Produk
  - Jenis Perbaikan
  - Gejala Kerusakan
  - Jenis Kerusakan
  - Tingkat Kerusakan
  - Rekomendasi Perbaikan
  - Estimasi Biaya
  - Estimasi Waktu Pengerjaan

---

## 🚀 Cara Menjalankan

### Opsi 1: Menjalankan dengan Docker (Recommended)

#### Build Docker Image
```bash
docker compose build
```

#### Jalankan Container
```bash
docker compose up -d
```

#### Stop Container
```bash
docker compose down
```

#### Rebuild dan Restart
```bash
docker compose down && docker compose up -d --build
```

#### Lihat Logs
```bash
# Lihat logs realtime
docker compose logs -f

# Lihat 50 baris terakhir
docker compose logs --tail=50
```

#### Cek Status Container
```bash
docker compose ps
```

**Konfigurasi Docker:**
- **Port**: 8000 (host) → 8000 (container)
- **Health Check**: Otomatis cek setiap 30 detik
- **Auto Restart**: Container otomatis restart jika error
- **Image**: Python 3.10 slim

**Catatan:**
- File `data_skripsi.xlsx` sudah di-copy ke dalam container saat build
- Jika ada perubahan code atau data, rebuild dengan `docker compose up -d --build`

---

### Opsi 2: Menjalankan Server Development (Tanpa Docker)

```bash
python -m uvicorn main:app --reload
```

atau

```bash
uvicorn main:app --reload
```

**Output:**
```
INFO:     Uvicorn running on http://127.0.0.1:8000
INFO:     Will watch for changes in these directories: ['C:\\Users\\Ryanh\\Project\\cf-ml']
```

Server akan berjalan di: `http://127.0.0.1:8000`

---

### Akses API Documentation

FastAPI menyediakan dokumentasi interaktif otomatis:

- **Swagger UI**: http://localhost:8000/docs
- **ReDoc**: http://localhost:8000/redoc

---

## 📚 Dokumentasi Modul

### Module: data_loader.py

#### Function: `load_data()`
Memuat data dari Excel dan melakukan preprocessing.

**Proses:**
1. Baca file Excel dari baris header ke-2
2. Ekstrak header dari baris pertama data
3. Drop kolom dan baris yang kosong
4. Rename kolom menggunakan pattern matching (case-insensitive)
5. Return dataframe yang sudah clean

**Return:** `pandas.DataFrame`

#### Function: `get_output_mapping(df)`
Membuat dictionary mapping dari rekomendasi ke estimasi biaya dan waktu.

**Parameter:**
- `df` (DataFrame) - Dataframe hasil load_data()

**Return:** `dict` - Mapping rekomendasi → {biaya, waktu}

---

### Module: utils.py

#### Function: `split_phrases(text: str)`
Memecah text menjadi list phrases.

**Proses:**
1. Convert ke lowercase
2. Replace "/" dan " dan " dengan ","
3. Remove special characters
4. Split by comma
5. Strip whitespace

**Return:** `list[str]`

**Contoh:**
```python
split_phrases("Kurang nyaman / tidak stabil")
# Output: ["kurang nyaman", "tidak stabil"]
```

#### Function: `build_feature_vocabulary(df)`
Membuat vocabulary dari semua unique phrases di dataset.

**Return:** `dict` - {phrase: feature_id}

**Contoh:**
```python
{
    "kurang nyaman": "G01",
    "karet putus": "G02",
    ...
}
```

#### Function: `phrases_to_vector(phrases, feature_cols)`
Convert list phrases menjadi feature vector untuk prediksi.

**Parameter:**
- `phrases` (list) - List of input phrases
- `feature_cols` (dict) - Feature vocabulary

**Return:** `pandas.DataFrame` - Binary feature vector

---

### Module: ml_model.py

#### Class: `DecisionTreeModel`

**Method: `train(X, y, test_size=0.3)`**
Melatih Decision Tree classifier.

**Parameter:**
- `X` (DataFrame) - Features
- `y` (Series) - Target variable (rekomendasi)
- `test_size` (float) - Proporsi data untuk testing

**Method: `predict(X)`**
Melakukan prediksi rekomendasi.

**Return:** `str` - Rekomendasi perbaikan

**Method: `get_confidence(X)`**
Mendapatkan confidence score dari prediksi.

**Return:** `float` - Probability score (0-1)

---

### Module: rules_engine.py

#### Class: `RulesEngine`

**Method: `__init__(df)`**
Inisialisasi dan build rules dari dataframe.

**Method: `forward_chaining(input_phrases)`**
Implementasi Forward Chaining - mencari rule dengan matching terpanjang.

**Algoritma:**
1. Convert input ke set
2. Loop semua rules
3. Check apakah kondisi rule subset dari input
4. Pilih rule dengan kondisi terpanjang (paling spesifik)
5. Return rekomendasi atau "Tidak diketahui"

**Return:** `str` - Rekomendasi perbaikan

**Method: `certainty_factor(input_phrases)`**
Implementasi Certainty Factor - menghitung CF untuk rules yang match.

**Algoritma:**
1. Convert input ke set
2. Loop semua rules
3. Check apakah kondisi rule subset dari input
4. Hitung CF value (default: 0.8)
5. Pilih rule dengan CF tertinggi
6. Return (rekomendasi, CF value)

**Return:** `tuple[str, float]` - (Rekomendasi, CF value)

---

## 🔌 API Endpoint

### GET /jenis-perbaikan

Endpoint untuk mendapatkan daftar semua jenis perbaikan yang tersedia dari database Excel.

#### Response

```json
{
  "total": 95,
  "data": [
    "Bantalan kursi minimalis",
    "Jok mobil Avanza",
    "Jok mobil Colt pickup",
    "Kursi Sofa 321",
    "..."
  ]
}
```

**Kegunaan:**
- Mendapatkan list opsi jenis perbaikan untuk dropdown/select input
- Validasi input jenis perbaikan sebelum submit
- Menampilkan katalog jenis perbaikan yang tersedia

---

### GET /kode/jenis-perbaikan

Endpoint untuk mendapatkan datatable jenis perbaikan dengan kode (JP001, JP002, dst).

#### Response

```json
{
  "total": 120,
  "data": [
    {
      "id": 1,
      "kode": "JP001",
      "jenis_perbaikan": "Bantalan kursi minimalis"
    },
    {
      "id": 2,
      "kode": "JP002",
      "jenis_perbaikan": "Jok mobil Avanza"
    },
    "..."
  ]
}
```

---

### GET /kode/gejala-kerusakan

Endpoint untuk mendapatkan datatable gejala kerusakan dengan kode (G001, G002, dst).

#### Response

```json
{
  "total": 75,
  "data": [
    {
      "id": 1,
      "kode": "G001",
      "gejala_kerusakan": "Amblas"
    },
    {
      "id": 2,
      "kode": "G002",
      "gejala_kerusakan": "Amblas ketika diduduki"
    },
    "..."
  ]
}
```

---

### GET /kode/jenis-kerusakan

Endpoint untuk mendapatkan datatable jenis kerusakan dengan kode (JK001, JK002, dst).

#### Response

```json
{
  "total": 124,
  "data": [
    {
      "id": 1,
      "kode": "JK001",
      "jenis_kerusakan": "oscar robek serta pecah-pecah dan pir dudukan putus"
    },
    {
      "id": 2,
      "kode": "JK002",
      "jenis_kerusakan": "Hidrolik rusak, sarung jok retak/mengelupas, spons kempis"
    },
    "..."
  ]
}
```

---

### GET /kode/rekomendasi

Endpoint untuk mendapatkan datatable rekomendasi perbaikan dengan kode (R001, R002, dst).

#### Response

```json
{
  "total": 124,
  "data": [
    {
      "id": 1,
      "kode": "R001",
      "rekomendasi_perbaikan": "Ganti cover jok dan menipiskan sponnya"
    },
    {
      "id": 2,
      "kode": "R002",
      "rekomendasi_perbaikan": "Ganti cover variasi bahan carvero"
    },
    "..."
  ]
}
```

---

### GET /kode/all

Endpoint untuk mendapatkan semua kode mapping sekaligus (untuk inisialisasi frontend).

#### Response

```json
{
  "jenis_perbaikan": {
    "total": 120,
    "data": [{"id": 1, "kode": "JP001", "value": "..."}, "..."]
  },
  "gejala_kerusakan": {
    "total": 75,
    "data": [{"id": 1, "kode": "G001", "value": "..."}, "..."]
  },
  "jenis_kerusakan": {
    "total": 124,
    "data": [{"id": 1, "kode": "JK001", "value": "..."}, "..."]
  },
  "rekomendasi_perbaikan": {
    "total": 124,
    "data": [{"id": 1, "kode": "R001", "value": "..."}, "..."]
  }
}
```

---

### POST /rekomendasi

Endpoint untuk mendapatkan rekomendasi perbaikan.

#### Request Body

```json
{
  "gejala_kerusakan": "string",
  "jenis_kerusakan": "string",
  "jenis_perbaikan": "string"
}
```

**Contoh:**
```json
{
  "gejala_kerusakan": "Kurang nyaman diduduki",
  "jenis_kerusakan": "Karet putus",
  "jenis_perbaikan": "Ganti komponen"
}
```

#### Response

```json
{
  "input": {
    "gejala_kerusakan": "string",
    "jenis_kerusakan": "string",
    "jenis_perbaikan": "string"
  },
  "rekomendasi_perbaikan": "string",
  "estimasi_biaya": "number | string",
  "estimasi_waktu": "string",
  "primary_method": "string",
  "methods_comparison": {
    "forward_chaining": {
      "rekomendasi": "string",
      "confidence": "number",
      "status": "string"
    },
    "certainty_factor": {
      "rekomendasi": "string",
      "confidence": "number",
      "status": "string"
    },
    "decision_tree": {
      "rekomendasi": "string",
      "confidence": "number",
      "status": "string"
    }
  }
}
```

**Contoh Response:**
```json
{
  "input": {
    "gejala_kerusakan": "Kurang nyaman diduduki",
    "jenis_kerusakan": "Karet putus",
    "jenis_perbaikan": "Ganti komponen"
  },
  "rekomendasi_perbaikan": "ganti karet, ganti spons, dan ganti sarung oscar",
  "estimasi_biaya": 1950000,
  "estimasi_waktu": "2-3 hari",
  "primary_method": "Forward Chaining",
  "methods_comparison": {
    "forward_chaining": {
      "rekomendasi": "ganti karet, ganti spons, dan ganti sarung oscar",
      "confidence": 100,
      "status": "Match"
    },
    "certainty_factor": {
      "rekomendasi": "ganti karet, ganti spons, dan ganti sarung oscar",
      "confidence": 80,
      "status": "Match"
    },
    "decision_tree": {
      "rekomendasi": "ganti karet, ganti spons, dan ganti sarung oscar",
      "confidence": 85.5,
      "status": "Predicted"
    }
  }
}
```

---

## 🧠 Metodologi

### 1. Forward Chaining

**Definisi:**
Metode inferensi yang bekerja dari fakta menuju kesimpulan (data-driven).

**Implementasi:**
- Membandingkan input user dengan rules yang ada
- Mencari rule yang kondisinya merupakan subset dari input
- Memilih rule dengan kondisi terpanjang (paling spesifik)
- Confidence: 100% jika match, 0% jika tidak

**Kelebihan:**
- Hasil pasti jika ada rule yang match
- Tidak ada ambiguitas
- Cepat untuk dataset kecil

**Kekurangan:**
- Tidak fleksibel untuk input yang tidak ada di rules
- Harus exact match

---

### 2. Certainty Factor (CF)

**Definisi:**
Metode untuk menangani ketidakpastian dalam sistem pakar dengan nilai kepercayaan.

**Formula CF:**
```
CF(H,E) = MB(H,E) - MD(H,E)
```

Dimana:
- MB (Measure of Belief) = Ukuran kepercayaan
- MD (Measure of Disbelief) = Ukuran ketidakpercayaan

**Implementasi:**
- Setiap rule yang match diberi CF value (default: 0.8)
- CF value merepresentasikan tingkat keyakinan terhadap rekomendasi
- Pilih rekomendasi dengan CF tertinggi
- Confidence: CF value × 100%

**Kelebihan:**
- Dapat menangani ketidakpastian
- Memberikan tingkat kepercayaan pada hasil
- Lebih fleksibel dari Forward Chaining

**Kekurangan:**
- Perlu penentuan CF value yang tepat
- Hasil bergantung pada CF yang ditetapkan

---

### 3. Decision Tree (Machine Learning)

**Definisi:**
Algoritma supervised learning yang membuat keputusan berdasarkan tree structure.

**Implementasi:**
- Training menggunakan historical data
- Features: Binary vector dari phrases
- Target: Rekomendasi perbaikan
- Test size: 30% untuk validation

**Proses:**
1. Extract features dari dataset
2. Convert ke binary vectors
3. Split train/test (70/30)
4. Train Decision Tree classifier
5. Predict menggunakan model trained
6. Confidence: Probability dari predict_proba()

**Kelebihan:**
- Dapat handle input yang tidak ada di rules
- Belajar dari pola data
- Memberikan probability/confidence
- Fleksibel dan adaptif

**Kekurangan:**
- Butuh data training yang cukup
- Dapat overfitting jika tidak di-tune
- Hasil bisa berbeda dengan expert knowledge

---

## 🔄 Flow Sistem

```
┌─────────────────────────────────────────────────────────────┐
│                    INPUT (3 Indikator)                      │
│  • Gejala Kerusakan                                         │
│  • Jenis Kerusakan                                          │
│  • Jenis Perbaikan                                          │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│              Preprocessing & Feature Extraction             │
│  • Split phrases                                            │
│  • Convert ke lowercase                                     │
│  • Remove special characters                                │
│  • Build feature vector                                     │
└────────────────────────┬────────────────────────────────────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
         ▼               ▼               ▼
┌────────────────┐ ┌──────────────┐ ┌──────────────┐
│    Forward     │ │  Certainty   │ │   Decision   │
│   Chaining     │ │    Factor    │ │     Tree     │
│                │ │              │ │              │
│ • Rule match   │ │ • CF calc    │ │ • ML predict │
│ • Longest rule │ │ • CF score   │ │ • Confidence │
│ • 100% / 0%    │ │ • 0-100%     │ │ • 0-100%     │
└───────┬────────┘ └──────┬───────┘ └──────┬───────┘
        │                 │                 │
        └─────────────────┼─────────────────┘
                          │
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                    Final Decision Logic                     │
│  Priority: Forward Chaining > Certainty Factor > ML         │
│  • Jika FC match → gunakan FC result                        │
│  • Jika CF match → gunakan CF result                        │
│  • Jika tidak match → gunakan ML result                     │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                      OUTPUT RESPONSE                        │
│  • Rekomendasi Perbaikan (final)                           │
│  • Estimasi Biaya                                           │
│  • Estimasi Waktu                                           │
│  • Primary Method (metode yang digunakan)                   │
│  • Methods Comparison (perbandingan 3 metode)              │
└─────────────────────────────────────────────────────────────┘
```

---

## 📝 Contoh Penggunaan

### Menggunakan cURL

```bash
curl -X POST "http://127.0.0.1:8000/rekomendasi" \
  -H "Content-Type: application/json" \
  -d '{
    "gejala_kerusakan": "Kurang nyaman diduduki",
    "jenis_kerusakan": "Karet putus",
    "jenis_perbaikan": "Ganti komponen"
  }'
```

### Menggunakan Python requests

```python
import requests
import json

url = "http://127.0.0.1:8000/rekomendasi"
data = {
    "gejala_kerusakan": "Kurang nyaman diduduki",
    "jenis_kerusakan": "Karet putus",
    "jenis_perbaikan": "Ganti komponen"
}

response = requests.post(url, json=data)
result = response.json()

print(json.dumps(result, indent=2))
```

### Menggunakan JavaScript fetch

```javascript
fetch('http://127.0.0.1:8000/rekomendasi', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    gejala_kerusakan: "Kurang nyaman diduduki",
    jenis_kerusakan: "Karet putus",
    jenis_perbaikan: "Ganti komponen"
  })
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
```

---

## 🔍 Troubleshooting

### Error: ModuleNotFoundError

**Solusi:**
```bash
pip install -r requirements.txt
```

### Error: KeyError 'waktu'

**Penyebab:** Kolom di Excel tidak sesuai format

**Solusi:**
- Pastikan nama kolom di Excel sesuai
- Sistem sudah handle dengan pattern matching case-insensitive

### Warning: sklearn regression problem

**Penyebab:** Jumlah unique classes terlalu banyak dibanding samples

**Solusi:** Warning ini normal, tidak mempengaruhi hasil

### Server tidak bisa diakses

**Solusi:**
- Pastikan port 8000 tidak digunakan aplikasi lain
- Coba ubah port: `uvicorn main:app --reload --port 8001`

---

## 📊 Dataset Requirements

### Format Excel

**Sheet Structure:**
- Header start dari row 2
- Data start dari row 3

**Required Columns:**
1. ID Produk
2. Jenis Perbaikan
3. Gejala Kerusakan
4. Jenis Kerusakan
5. Tingkat Kerusakan
6. Rekomendasi Perbaikan
7. Estimasi Biaya (numeric atau string)
8. Estimasi Waktu Pengerjaan (string)

**Tips:**
- Gunakan format konsisten untuk gejala/jenis kerusakan
- Pisahkan multiple items dengan "/" atau "dan"
- Hindari typo dan spasi berlebih
- Biaya bisa numeric atau string (akan ditampilkan as-is)

---

## 🚀 Development

### Menambah Fitur Baru

**1. Menambah field input:**
- Edit `SPKInput` class di main.py
- Update preprocessing di endpoint
- Update feature extraction di utils.py
- Update rules building di rules_engine.py

**2. Menambah metode baru:**
- Buat module baru (misal: `new_method.py`)
- Implement class dengan method predict()
- Import dan inisialisasi di main.py
- Tambahkan ke methods_comparison

**3. Mengubah prioritas metode:**
- Edit logic di endpoint `/rekomendasi`
- Ubah urutan if-elif checking

### Testing

```python
# Test individual module
python -c "from data_loader import load_data; df = load_data(); print(df.head())"

# Test API endpoint
python -c "import requests; r = requests.post('http://127.0.0.1:8000/rekomendasi', json={'gejala_kerusakan':'test','jenis_kerusakan':'test','jenis_perbaikan':'test'}); print(r.json())"
```

---

## 📄 License

Project ini dibuat untuk keperluan akademik/skripsi.

---

## 👨‍💻 Author

Ryan H.

---

## 📞 Support

Jika ada pertanyaan atau issue, silakan hubungi developer atau buat issue di repository.

---

**Last Updated:** December 14, 2025
