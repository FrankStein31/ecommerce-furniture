"""
Import Data dari Excel ke Database
Sistem Rekomendasi Perbaikan Mebel
"""

import pandas as pd
import mysql.connector
from mysql.connector import Error
import sys
import os

# Konfigurasi Database
DB_CONFIG = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'ecommerce-furniture'
}

# Path file Excel
EXCEL_FILE = 'Ecommerce Anggita Jaya.xlsx'

def create_connection():
    """Buat koneksi ke database"""
    try:
        connection = mysql.connector.connect(**DB_CONFIG)
        if connection.is_connected():
            print("✓ Koneksi ke database berhasil!")
            return connection
    except Error as e:
        print(f"✗ Error koneksi database: {e}")
        return None

def import_jenis_perbaikan(connection):
    """Import data Jenis Perbaikan dari sheet 'Katerogi mebel'"""
    print("\n[1/4] Import Jenis Perbaikan...")
    
    try:
        # Baca Excel sheet "Katerogi mebel" (typo di Excel)
        df = pd.read_excel(EXCEL_FILE, sheet_name='Katerogi mebel', header=1)
        
        cursor = connection.cursor()
        count = 0
        
        # Mapping kategori berdasarkan kolom Excel
        kategori_mapping = {
            'Sofa': 1,
            'Kursi Kantor': 2,
            'Kursi Tamu': 3,
            'Jok Kendaraan': 4,
            'Springbed & Kasur': 5,
            'Lain-lain': 6
        }
        
        # Loop kolom B sampai G (index 1-6)
        for col_idx, kategori_name in enumerate(['Sofa', 'Kursi Kantor', 'Kursi Tamu', 
                                                   'Jok Kendaraan', 'Springbed & Kasur', 'Lain-lain']):
            id_kategori = kategori_mapping[kategori_name]
            
            # Ambil data dari kolom yang sesuai (skip header row 0)
            col_data = df.iloc[:, col_idx + 1]  # +1 karena kolom A adalah index
            
            urutan = 1
            for value in col_data:
                if pd.notna(value) and str(value).strip():
                    nama_jenis = str(value).strip()
                    
                    # Cek apakah sudah ada
                    cursor.execute("""
                        SELECT id FROM jenis_perbaikan 
                        WHERE nama_jenis_perbaikan = %s AND id_kategori = %s
                    """, (nama_jenis, id_kategori))
                    
                    if cursor.fetchone() is None:
                        # Insert jika belum ada
                        sql = """
                            INSERT INTO jenis_perbaikan 
                            (id_kategori, nama_jenis_perbaikan, urutan, status) 
                            VALUES (%s, %s, %s, '1')
                        """
                        cursor.execute(sql, (id_kategori, nama_jenis, urutan))
                        count += 1
                    
                    urutan += 1
        
        connection.commit()
        print(f"  ✓ Berhasil import {count} data jenis perbaikan")
        return True
        
    except Exception as e:
        print(f"  ✗ Error import jenis perbaikan: {e}")
        return False

def import_gejala_kerusakan(connection):
    """Import data Gejala Kerusakan dari sheet 'Gejala kerusakan'"""
    print("\n[2/4] Import Gejala Kerusakan...")
    
    try:
        df = pd.read_excel(EXCEL_FILE, sheet_name='Gejala kerusakan', header=0)
        
        cursor = connection.cursor()
        count = 0
        
        for idx, row in df.iterrows():
            # Kolom yang benar adalah 'Gejala Kerusakan' dan 'Kode Gejala'
            if pd.notna(row.get('Gejala Kerusakan')) and str(row['Gejala Kerusakan']).strip():
                kode_gejala = str(row.get('Kode Gejala', f"G{str(idx + 1).zfill(2)}")).strip()
                nama_gejala = str(row['Gejala Kerusakan']).strip()
                deskripsi = str(row.get('Deskripsi', '')).strip() if pd.notna(row.get('Deskripsi')) else None
                pertanyaan = f"Apakah furniture Anda mengalami {nama_gejala.lower()}?"
                
                # Cek duplikat
                cursor.execute("SELECT id FROM gejala_kerusakan WHERE kode_gejala = %s", (kode_gejala,))
                if cursor.fetchone() is None:
                    sql = """
                        INSERT INTO gejala_kerusakan 
                        (kode_gejala, nama_gejala, deskripsi_gejala, pertanyaan, urutan, status) 
                        VALUES (%s, %s, %s, %s, %s, '1')
                    """
                    cursor.execute(sql, (kode_gejala, nama_gejala, deskripsi, pertanyaan, idx + 1))
                    count += 1
        
        connection.commit()
        print(f"  ✓ Berhasil import {count} data gejala kerusakan")
        return True
        
    except Exception as e:
        print(f"  ✗ Error import gejala: {e}")
        return False

def import_jenis_kerusakan(connection):
    """Import data Jenis Kerusakan dari sheet 'Jenis Kerusakan'"""
    print("\n[3/4] Import Jenis Kerusakan...")
    
    try:
        df = pd.read_excel(EXCEL_FILE, sheet_name='Jenis Kerusakan', header=0)
        
        cursor = connection.cursor()
        count = 0
        
        for idx, row in df.iterrows():
            if pd.notna(row.get('Jenis Kerusakan')) and str(row['Jenis Kerusakan']).strip():
                kode_kerusakan = f"JK{str(idx + 1).zfill(3)}"
                nama_kerusakan = str(row['Jenis Kerusakan']).strip()
                
                # Ambil tingkat kerusakan jika ada
                tingkat = 'sedang'
                if pd.notna(row.get('Tingkat Kerusakan')):
                    tingkat_val = str(row['Tingkat Kerusakan']).lower()
                    if 'ringan' in tingkat_val:
                        tingkat = 'ringan'
                    elif 'berat' in tingkat_val or 'parah' in tingkat_val:
                        tingkat = 'berat'
                
                pertanyaan = f"Apakah furniture Anda mengalami kerusakan: {nama_kerusakan.lower()}?"
                
                # Cek duplikat
                cursor.execute("SELECT id FROM jenis_kerusakan WHERE kode_kerusakan = %s", (kode_kerusakan,))
                if cursor.fetchone() is None:
                    sql = """
                        INSERT INTO jenis_kerusakan 
                        (kode_kerusakan, nama_jenis_kerusakan, pertanyaan, tingkat_kerusakan, urutan, status) 
                        VALUES (%s, %s, %s, %s, %s, '1')
                    """
                    cursor.execute(sql, (kode_kerusakan, nama_kerusakan, pertanyaan, tingkat, idx + 1))
                    count += 1
        
        connection.commit()
        print(f"  ✓ Berhasil import {count} data jenis kerusakan")
        return True
        
    except Exception as e:
        print(f"  ✗ Error import jenis kerusakan: {e}")
        return False

def import_rekomendasi_perbaikan(connection):
    """Import data Rekomendasi Perbaikan dari sheet 'Rekomendasi Perbaikan'"""
    print("\n[4/4] Import Rekomendasi Perbaikan...")
    
    try:
        df = pd.read_excel(EXCEL_FILE, sheet_name='Rekomendasi Perbaikan', header=0)
        
        # Mapping MB & MD sesuai tabel yang diberikan user
        mb_md_mapping = {
            'R01': {'mb': 1.0, 'md': 0.0},
            'R02': {'mb': 1.0, 'md': 0.0},
            'R03': {'mb': 0.8, 'md': 0.2},
            'R04': {'mb': 0.8, 'md': 0.2},
            'R05': {'mb': 0.6, 'md': 0.4},
            'R06': {'mb': 0.8, 'md': 0.2},
            'R07': {'mb': 0.6, 'md': 0.4},
            'R08': {'mb': 1.0, 'md': 0.0},
            'R09': {'mb': 0.8, 'md': 0.2},
            'R10': {'mb': 1.0, 'md': 0.0},
            'R11': {'mb': 1.0, 'md': 0.0},
            'R12': {'mb': 0.6, 'md': 0.4},
        }
        
        cursor = connection.cursor()
        count = 0
        updated = 0
        
        for idx, row in df.iterrows():
            if pd.notna(row.get('Rekomendasi Perbaikan')) and str(row['Rekomendasi Perbaikan']).strip():
                # Ambil Kode Rekomendasi dari Excel atau generate
                if pd.notna(row.get('Kode Rekomendasi')):
                    kode_rekomendasi = str(row['Kode Rekomendasi']).strip()
                else:
                    kode_rekomendasi = f"R{str(idx + 1).zfill(2)}"
                
                nama_rekomendasi = str(row['Rekomendasi Perbaikan']).strip()
                
                # Ambil Jenis Kerusakan terkait
                jenis_kerusakan_terkait = None
                if pd.notna(row.get('Jenis Kerusakan')):
                    jenis_kerusakan_terkait = str(row['Jenis Kerusakan']).strip()
                
                # Ambil Tingkat Kerusakan
                tingkat = 'sedang'
                if pd.notna(row.get('Tingkat Kerusakan')):
                    tingkat_val = str(row['Tingkat Kerusakan']).lower()
                    if 'ringan' in tingkat_val:
                        tingkat = 'ringan'
                    elif 'berat' in tingkat_val:
                        tingkat = 'berat'
                
                # Ambil harga
                harga_min = None
                harga_max = None
                if pd.notna(row.get('Estimasi Biaya')):
                    try:
                        harga = float(str(row['Estimasi Biaya']).replace('Rp', '').replace('.', '').replace(',', '').strip())
                        harga_min = harga
                        harga_max = harga
                    except:
                        pass
                
                # Ambil waktu
                waktu = None
                if pd.notna(row.get('Estimasi Waktu Pengerjaan')):
                    waktu = str(row['Estimasi Waktu Pengerjaan']).strip()
                elif pd.notna(row.get('Estimasi waktu (diagnosis)')):
                    waktu = str(row['Estimasi waktu (diagnosis)']).strip()
                
                # Ambil MB & MD dari mapping
                mb_value = 0.80  # default
                md_value = 0.20  # default
                
                if kode_rekomendasi in mb_md_mapping:
                    mb_value = mb_md_mapping[kode_rekomendasi]['mb']
                    md_value = mb_md_mapping[kode_rekomendasi]['md']
                
                # Simpan detail perbaikan dengan jenis kerusakan terkait
                detail_perbaikan = None
                if jenis_kerusakan_terkait:
                    detail_perbaikan = f"Untuk kerusakan: {jenis_kerusakan_terkait}. Tingkat: {tingkat}"
                
                # Cek duplikat
                cursor.execute("SELECT id FROM rekomendasi_perbaikan WHERE kode_rekomendasi = %s", (kode_rekomendasi,))
                existing = cursor.fetchone()
                
                if existing is None:
                    # Insert baru
                    sql = """
                        INSERT INTO rekomendasi_perbaikan 
                        (kode_rekomendasi, nama_rekomendasi, detail_perbaikan, estimasi_harga_min, estimasi_harga_max, 
                         estimasi_waktu, mb_value, md_value, urutan, status) 
                        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, '1')
                    """
                    cursor.execute(sql, (kode_rekomendasi, nama_rekomendasi, detail_perbaikan, harga_min, harga_max, 
                                       waktu, mb_value, md_value, idx + 1))
                    count += 1
                else:
                    # Update MB & MD yang sudah ada
                    sql = """
                        UPDATE rekomendasi_perbaikan 
                        SET mb_value = %s, md_value = %s, detail_perbaikan = %s,
                            estimasi_harga_min = %s, estimasi_harga_max = %s, estimasi_waktu = %s
                        WHERE kode_rekomendasi = %s
                    """
                    cursor.execute(sql, (mb_value, md_value, detail_perbaikan, harga_min, harga_max, waktu, kode_rekomendasi))
                    updated += 1
        
        connection.commit()
        print(f"  ✓ Berhasil: {count} data baru, {updated} data diupdate")
        return True
        
    except Exception as e:
        print(f"  ✗ Error import rekomendasi: {e}")
        return False

def main():
    """Main function"""
    print("=" * 60)
    print("IMPORT DATA EXCEL KE DATABASE")
    print("Sistem Rekomendasi Perbaikan Mebel")
    print("=" * 60)
    
    # Cek file Excel
    if not os.path.exists(EXCEL_FILE):
        print(f"\n✗ File Excel tidak ditemukan: {EXCEL_FILE}")
        sys.exit(1)
    
    print(f"\n✓ File Excel ditemukan: {EXCEL_FILE}")
    
    # Koneksi database
    connection = create_connection()
    if not connection:
        sys.exit(1)
    
    try:
        # Import data
        success = True
        success = import_jenis_perbaikan(connection) and success
        success = import_gejala_kerusakan(connection) and success
        success = import_jenis_kerusakan(connection) and success
        success = import_rekomendasi_perbaikan(connection) and success
        
        if success:
            print("\n" + "=" * 60)
            print("✓ IMPORT DATA SELESAI!")
            print("=" * 60)
        else:
            print("\n⚠ Import selesai dengan beberapa error")
            
    except Exception as e:
        print(f"\n✗ Error: {e}")
        
    finally:
        if connection and connection.is_connected():
            connection.close()
            print("\n✓ Koneksi database ditutup")

if __name__ == "__main__":
    main()
