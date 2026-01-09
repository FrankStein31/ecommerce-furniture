# ==========================================================
# UTILITY FUNCTIONS MODULE
# ==========================================================

import pandas as pd
import re
from typing import List


def split_phrases(text: str) -> List[str]:
    """
    Split text menjadi list phrases dengan normalisasi agresif
    """
    if pd.isna(text):
        return []
    
    text = str(text).lower()  # Case insensitive dari awal
    
    # Normalisasi common patterns - lebih agresif
    text = text.replace("diduduki", "duduki")
    text = text.replace("di duduki", "duduki")
    text = text.replace("di-duduki", "duduki")
    
    # Normalisasi possessive dan suffix
    text = re.sub(r'nya\b', '', text)
    
    # Replace separators
    text = text.replace("/", ",")
    text = text.replace(" dan ", ",")
    text = text.replace(" atau ", ",")
    text = text.replace(";", ",")
    text = text.replace("&", ",")
    
    # Remove parentheses content but keep the main text
    # "Kursi (L)" -> keep both "kursi l" and "kursi"
    
    # Remove special characters but keep spaces and commas
    text = re.sub(r"[^a-zA-Z0-9, ]", " ", text)
    
    # Split by comma first
    parts = [p.strip() for p in text.split(",") if p.strip()]
    
    # Collect all keywords
    all_keywords = []
    for part in parts:
        # Add the full phrase
        part_clean = " ".join(part.split())  # Normalize spaces
        if part_clean:
            all_keywords.append(part_clean)
        
        # Add individual words (minimum 3 chars)
        words = [w.strip() for w in part.split() if len(w.strip()) >= 3]
        all_keywords.extend(words)
    
    # Remove duplicates while preserving order
    seen = set()
    cleaned = []
    for keyword in all_keywords:
        keyword_lower = keyword.lower().strip()
        if keyword_lower and keyword_lower not in seen and len(keyword_lower) >= 3:
            cleaned.append(keyword_lower)
            seen.add(keyword_lower)
    
    return cleaned


def build_feature_vocabulary(df):
    """
    Build vocabulary dari semua gejala, jenis kerusakan, dan jenis perbaikan
    Returns: feature_cols dictionary
    """
    all_phrases = set()
    for _, row in df.iterrows():
        all_phrases.update(split_phrases(row["gejala"]))
        all_phrases.update(split_phrases(row["jenis_kerusakan"]))
        if "jenis_perbaikan" in df.columns:
            all_phrases.update(split_phrases(row.get("jenis_perbaikan", "")))
    
    all_phrases = sorted(all_phrases)
    feature_cols = {p: f"G{i:02d}" for i, p in enumerate(all_phrases, start=1)}
    
    return feature_cols


def row_to_vector(row, feature_cols):
    """
    Convert row data menjadi feature vector
    """
    phrases = set(split_phrases(row["gejala"]) + split_phrases(row["jenis_kerusakan"]))
    if "jenis_perbaikan" in row.index:
        phrases.update(split_phrases(row.get("jenis_perbaikan", "")))
    return {feature_cols[p]: 1 if p in phrases else 0 for p in feature_cols}


def phrases_to_vector(phrases, feature_cols):
    """
    Convert list of phrases menjadi feature vector untuk prediksi
    """
    phrases = set([p.lower() for p in phrases])
    return pd.DataFrame([{
        col: 1 if phrase in phrases else 0
        for phrase, col in feature_cols.items()
    }])


def build_dataset(df, feature_cols):
    """
    Build dataset untuk training
    Returns: X, y
    """
    dataset = []
    for _, row in df.iterrows():
        d = row_to_vector(row, feature_cols)
        d["rekomendasi"] = row["rekomendasi"]
        dataset.append(d)
    
    dataset = pd.DataFrame(dataset)
    X = dataset.drop("rekomendasi", axis=1)
    y = dataset["rekomendasi"]
    
    return X, y
