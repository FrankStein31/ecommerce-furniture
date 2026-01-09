"""
Generate code mapping untuk dokumentasi
"""
from data_loader import load_data
import pandas as pd

# Load data
df = load_data()

# Get unique values
jenis_perbaikan = sorted(df["jenis_perbaikan"].dropna().unique().tolist())
gejala = sorted(df["gejala"].dropna().unique().tolist())
jenis_kerusakan = sorted(df["jenis_kerusakan"].dropna().unique().tolist())
rekomendasi = sorted(df["rekomendasi"].dropna().unique().tolist())

# Generate mapping tables
print("=" * 80)
print("TABEL KODE JENIS PERBAIKAN")
print("=" * 80)
print("| Kode | Jenis Perbaikan |")
print("|------|-----------------|")
for i, item in enumerate(jenis_perbaikan, 1):
    print(f"| JP{i:03d} | {item} |")

print("\n" + "=" * 80)
print("TABEL KODE GEJALA KERUSAKAN")
print("=" * 80)
print("| Kode | Gejala Kerusakan |")
print("|------|------------------|")
for i, item in enumerate(gejala, 1):
    print(f"| G{i:03d} | {item} |")

print("\n" + "=" * 80)
print("TABEL KODE JENIS KERUSAKAN")
print("=" * 80)
print("| Kode | Jenis Kerusakan |")
print("|------|-----------------|")
for i, item in enumerate(jenis_kerusakan, 1):
    print(f"| JK{i:03d} | {item} |")

print("\n" + "=" * 80)
print("TABEL KODE REKOMENDASI PERBAIKAN")
print("=" * 80)
print("| Kode | Rekomendasi Perbaikan |")
print("|------|------------------------|")
for i, item in enumerate(rekomendasi, 1):
    print(f"| R{i:03d} | {item} |")

print("\n" + "=" * 80)
print("SUMMARY")
print("=" * 80)
print(f"Total Jenis Perbaikan: {len(jenis_perbaikan)}")
print(f"Total Gejala Kerusakan: {len(gejala)}")
print(f"Total Jenis Kerusakan: {len(jenis_kerusakan)}")
print(f"Total Rekomendasi: {len(rekomendasi)}")
