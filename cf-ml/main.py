# ==========================================================
# FASTAPI - SPK Rekomendasi Perbaikan Perabotan Rumah Tangga
# Metode: Forward Chaining dan Certainty Factor
# ==========================================================

from fastapi import FastAPI
from pydantic import BaseModel

# Import modules
from data_loader import load_data, get_output_mapping
from utils import split_phrases, build_feature_vocabulary, build_dataset, phrases_to_vector
from rules_engine import RulesEngine

# ==========================================================
# INITIALIZATION
# ==========================================================

# Load data
df = load_data()

# Initialize Rules Engine
rules_engine = RulesEngine(df)

# Output mapping
OUTPUT_MAPPING = get_output_mapping(df)

# ==========================================================
# FASTAPI
# ==========================================================

app = FastAPI(title="SPK Rekomendasi Perbaikan - Forward Chaining & Certainty Factor")

class SPKInput(BaseModel):
    gejala_kerusakan: str
    jenis_kerusakan: str
    jenis_perbaikan: str
    cf_user: float = 0.8  # Default CF user = 0.8 (yakin)


@app.post("/rekomendasi")
def rekomendasi(data: SPKInput):
    # STEP 1: Filter data berdasarkan jenis perbaikan/produk
    filtered_df = rules_engine.filter_by_product(data.jenis_perbaikan)
    
    # STEP 2: Rebuild rules dari filtered data
    from rules_engine import RulesEngine
    
    filtered_rules_engine = RulesEngine(filtered_df)
    
    # STEP 3: Split input menjadi phrases (tanpa jenis_perbaikan untuk matching)
    phrases = (split_phrases(data.gejala_kerusakan) + 
               split_phrases(data.jenis_kerusakan))
    
    # STEP 4: Forward Chaining dengan filtered rules
    fc_result, fc_details = filtered_rules_engine.forward_chaining(phrases)
    fc_found = fc_result != "Tidak diketahui"
    
    # STEP 5: Certainty Factor dengan filtered rules
    cf_result, cf_value, cf_details = filtered_rules_engine.certainty_factor(phrases, cf_user_default=data.cf_user)
    cf_found = cf_result != "Tidak diketahui"
    
    # Perbandingan 2 metode: Forward Chaining vs Certainty Factor
    methods_comparison = {
        "forward_chaining": {
            "rekomendasi": fc_result,
            "confidence": 100 if fc_found else 0,
            "status": "Match" if fc_found else "Tidak ditemukan",
            "calculation_details": fc_details
        },
        "certainty_factor": {
            "rekomendasi": cf_result,
            "confidence": round(cf_value * 100, 2) if cf_found else 0,
            "status": "Match" if cf_found else "Tidak ditemukan",
            "calculation_details": cf_details
        }
    }
    
    # Final decision: prioritas FC > CF
    if fc_found:
        final = fc_result
        primary_method = "Forward Chaining"
        confidence_score = 100
    elif cf_found:
        final = cf_result
        primary_method = "Certainty Factor"
        confidence_score = round(cf_value * 100, 2)
    else:
        final = "Tidak diketahui"
        primary_method = "None"
        confidence_score = 0
    
    estimasi = OUTPUT_MAPPING.get(final, {"biaya": "-", "waktu": "-"})
    
    return {
        "input": data,
        "filtered_data_count": len(filtered_df),
        "rekomendasi_perbaikan": final,
        "estimasi_biaya": estimasi["biaya"],
        "estimasi_waktu": estimasi["waktu"],
        "primary_method": primary_method,
        "confidence_score": confidence_score,
        "methods_comparison": methods_comparison
    }


@app.get("/jenis-perbaikan")
def get_jenis_perbaikan():
    """
    API endpoint untuk mendapatkan list semua jenis perbaikan yang tersedia dari Excel
    """
    jenis_perbaikan_list = df["jenis_perbaikan"].dropna().unique().tolist()
    
    return {
        "total": len(jenis_perbaikan_list),
        "data": sorted(jenis_perbaikan_list)
    }


@app.get("/kode/jenis-perbaikan")
def get_kode_jenis_perbaikan():
    """
    API endpoint untuk mendapatkan datatable jenis perbaikan dengan kode
    """
    jenis_perbaikan_list = sorted(df["jenis_perbaikan"].dropna().unique().tolist())
    
    data = []
    for i, item in enumerate(jenis_perbaikan_list, 1):
        data.append({
            "id": i,
            "kode": f"JP{i:03d}",
            "jenis_perbaikan": item
        })
    
    return {
        "total": len(data),
        "data": data
    }


@app.get("/kode/gejala-kerusakan")
def get_kode_gejala():
    """
    API endpoint untuk mendapatkan datatable gejala kerusakan dengan kode
    """
    gejala_list = sorted(df["gejala"].dropna().unique().tolist())
    
    data = []
    for i, item in enumerate(gejala_list, 1):
        data.append({
            "id": i,
            "kode": f"G{i:03d}",
            "gejala_kerusakan": item
        })
    
    return {
        "total": len(data),
        "data": data
    }


@app.get("/kode/jenis-kerusakan")
def get_kode_jenis_kerusakan():
    """
    API endpoint untuk mendapatkan datatable jenis kerusakan dengan kode
    """
    jenis_kerusakan_list = sorted(df["jenis_kerusakan"].dropna().unique().tolist())
    
    data = []
    for i, item in enumerate(jenis_kerusakan_list, 1):
        data.append({
            "id": i,
            "kode": f"JK{i:03d}",
            "jenis_kerusakan": item
        })
    
    return {
        "total": len(data),
        "data": data
    }


@app.get("/kode/rekomendasi")
def get_kode_rekomendasi():
    """
    API endpoint untuk mendapatkan datatable rekomendasi perbaikan dengan kode
    """
    rekomendasi_list = sorted(df["rekomendasi"].dropna().unique().tolist())
    
    data = []
    for i, item in enumerate(rekomendasi_list, 1):
        data.append({
            "id": i,
            "kode": f"R{i:03d}",
            "rekomendasi_perbaikan": item
        })
    
    return {
        "total": len(data),
        "data": data
    }


@app.get("/kode/all")
def get_all_kode():
    """
    API endpoint untuk mendapatkan semua kode mapping sekaligus
    """
    jenis_perbaikan_list = sorted(df["jenis_perbaikan"].dropna().unique().tolist())
    gejala_list = sorted(df["gejala"].dropna().unique().tolist())
    jenis_kerusakan_list = sorted(df["jenis_kerusakan"].dropna().unique().tolist())
    rekomendasi_list = sorted(df["rekomendasi"].dropna().unique().tolist())
    
    jenis_perbaikan_data = [{"id": i, "kode": f"JP{i:03d}", "value": item} 
                            for i, item in enumerate(jenis_perbaikan_list, 1)]
    gejala_data = [{"id": i, "kode": f"G{i:03d}", "value": item} 
                   for i, item in enumerate(gejala_list, 1)]
    jenis_kerusakan_data = [{"id": i, "kode": f"JK{i:03d}", "value": item} 
                            for i, item in enumerate(jenis_kerusakan_list, 1)]
    rekomendasi_data = [{"id": i, "kode": f"R{i:03d}", "value": item} 
                        for i, item in enumerate(rekomendasi_list, 1)]
    
    return {
        "jenis_perbaikan": {
            "total": len(jenis_perbaikan_data),
            "data": jenis_perbaikan_data
        },
        "gejala_kerusakan": {
            "total": len(gejala_data),
            "data": gejala_data
        },
        "jenis_kerusakan": {
            "total": len(jenis_kerusakan_data),
            "data": jenis_kerusakan_data
        },
        "rekomendasi_perbaikan": {
            "total": len(rekomendasi_data),
            "data": rekomendasi_data
        }
    }
