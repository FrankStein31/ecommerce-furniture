# ==========================================================
# DATA LOADER MODULE
# ==========================================================

import pandas as pd

FILE_PATH = "data_skripsi.xlsx"


def load_data():
    """
    Load dan preprocessing data dari Excel
    """
    raw = pd.read_excel(FILE_PATH, header=1)
    header = raw.iloc[0]
    df = raw.iloc[1:].reset_index(drop=True)
    df.columns = header
    df = df.loc[:, ~df.columns.isna()]
    df = df.dropna(subset=["Jenis Perbaikan"]).reset_index(drop=True)
    
    # Debug: print nama kolom untuk troubleshooting
    print("Kolom yang tersedia:", df.columns.tolist())
    
    # Rename dengan handling berbagai kemungkinan nama
    rename_mapping = {}
    for col in df.columns:
        col_lower = str(col).lower().strip()
        if "id produk" in col_lower or "id_produk" in col_lower:
            rename_mapping[col] = "id_produk"
        elif "jenis perbaikan" in col_lower:
            rename_mapping[col] = "jenis_perbaikan"
        elif "gejala kerusakan" in col_lower:
            rename_mapping[col] = "gejala"
        elif "jenis kerusakan" in col_lower:
            rename_mapping[col] = "jenis_kerusakan"
        elif "tingkat kerusakan" in col_lower:
            rename_mapping[col] = "tingkat"
        elif "rekomendasi perbaikan" in col_lower:
            rename_mapping[col] = "rekomendasi"
        elif "estimasi biaya" in col_lower:
            rename_mapping[col] = "biaya"
        elif "estimasi waktu pengerjaan" in col_lower:
            rename_mapping[col] = "waktu"
        elif "estimasi waktu" in col_lower and "diagnosis" in col_lower:
            rename_mapping[col] = "waktu_diagnosis"
    
    df = df.rename(columns=rename_mapping)
    
    return df


def get_output_mapping(df):
    """
    Buat mapping rekomendasi ke biaya dan waktu
    """
    output_map = {}
    for _, row in df.iterrows():
        if "rekomendasi" in df.columns and pd.notna(row.get("rekomendasi")):
            biaya_val = row.get("biaya", "-")
            waktu_val = row.get("waktu", "-")
            
            output_map[row["rekomendasi"]] = {
                "biaya": biaya_val if pd.notna(biaya_val) else "-",
                "waktu": waktu_val if pd.notna(waktu_val) else "-"
            }
    return output_map
