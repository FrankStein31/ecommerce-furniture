"""
Script untuk test endpoint jenis-perbaikan
"""
from data_loader import load_data

# Load data
df = load_data()

# Get unique jenis perbaikan
jenis_perbaikan_list = df["jenis_perbaikan"].dropna().unique().tolist()

print("✓ API Endpoint: GET /jenis-perbaikan")
print(f"\nTotal Jenis Perbaikan: {len(jenis_perbaikan_list)}")
print("\nBeberapa contoh jenis perbaikan:")
for item in sorted(jenis_perbaikan_list)[:15]:
    print(f"  - {item}")
print("  ...")
print(f"\nResponse format:")
print({
    "total": len(jenis_perbaikan_list),
    "data": ["... sorted list of all jenis perbaikan ..."]
})
