# ==========================================================
# RULES ENGINE MODULE (Forward Chaining + Certainty Factor)
# ==========================================================

from utils import split_phrases
import pandas as pd


DEFAULT_CF = 0.8


class RulesEngine:
    """
    Rules engine untuk Forward Chaining dan Certainty Factor
    """
    
    def __init__(self, df):
        self.df = df
        self.rules = self._build_rules(df)
    
    def _build_rules(self, df):
        """
        Build rules dari dataframe
        """
        rules = {}
        for _, row in df.iterrows():
            cond_phrases = split_phrases(row["gejala"]) + split_phrases(row["jenis_kerusakan"])
            if "jenis_perbaikan" in df.columns:
                cond_phrases += split_phrases(row.get("jenis_perbaikan", ""))
            cond = tuple(sorted(set(cond_phrases)))
            rules[cond] = row["rekomendasi"]
        return rules
    
    def forward_chaining(self, input_phrases):
        """
        Forward Chaining: cari rule dengan matching terpanjang
        Returns: best_solution, fc_details
        """
        input_set = set([p.lower().strip() for p in input_phrases])
        best, max_score = None, 0
        best_overlap_ratio = 0
        best_details = None
        
        print(f"\n[FC] Input phrases: {sorted(input_set)}")
        
        # Collect all candidates
        candidates = []
        
        for cond, sol in self.rules.items():
            cond_set = set([c.lower().strip() for c in cond])
            overlap = cond_set & input_set
            overlap_count = len(overlap)
            
            if overlap_count > 0:
                overlap_ratio = overlap_count / len(cond_set) if len(cond_set) > 0 else 0
                
                # Prioritize by overlap ratio first, then count
                if overlap_ratio >= 0.4:  # Lower threshold to 40%
                    candidate_info = {
                        "rekomendasi": sol,
                        "rule_keywords": sorted(list(cond_set)),
                        "matched_keywords": sorted(list(overlap)),
                        "matched_count": overlap_count,
                        "rule_total_keywords": len(cond_set),
                        "overlap_ratio": overlap_ratio,
                        "overlap_percentage": round(overlap_ratio * 100, 2),
                        "is_selected": False
                    }
                    candidates.append(candidate_info)
                    
                    print(f"[FC] Candidate: {sol[:50]}...")
                    print(f"     Rule keywords: {sorted(list(cond_set)[:5])}...")
                    print(f"     Overlap: {sorted(overlap)} ({overlap_count}/{len(cond_set)} = {overlap_ratio:.0%})\n")
                    
                    # Prefer higher ratio, or higher count if ratio is same
                    if overlap_ratio > best_overlap_ratio or (overlap_ratio == best_overlap_ratio and overlap_count > max_score):
                        best = sol
                        max_score = overlap_count
                        best_overlap_ratio = overlap_ratio
                        best_details = candidate_info
        
        # Mark the selected candidate
        if best_details:
            best_details["is_selected"] = True
        
        result = best or "Tidak diketahui"
        
        fc_calculation = {
            "input_phrases": sorted(list(input_set)),
            "total_candidates": len(candidates),
            "candidates": candidates,
            "selected_rule": {
                "rekomendasi": result,
                "matched_count": max_score,
                "overlap_ratio": best_overlap_ratio,
                "overlap_percentage": round(best_overlap_ratio * 100, 2),
                "selection_criteria": "Highest overlap ratio with rule keywords"
            } if best else None
        }
        
        print(f"[FC] Final result: {result[:80]}...\n")
        return result, fc_calculation
    
    def certainty_factor(self, input_phrases, cf_user_default=0.8):
        """
        Certainty Factor: hitung CF untuk setiap rule yang match
        Returns: best_solution, best_cf, calculation_details
        """
        input_set = set([p.lower().strip() for p in input_phrases])
        best_sol, best_cf = "Tidak diketahui", 0
        best_details = None
        
        print(f"\n[CF] Input phrases: {sorted(input_set)}")
        
        for cond, sol in self.rules.items():
            cond_set = set([c.lower().strip() for c in cond])
            overlap = cond_set & input_set
            overlap_count = len(overlap)
            
            if overlap_count > 0:
                overlap_ratio = overlap_count / len(cond_set) if len(cond_set) > 0 else 0
                
                if overlap_ratio >= 0.4:  # Lower threshold to 40%
                    # Detail perhitungan untuk setiap gejala
                    gejala_details = []
                    cf_combines = []
                    
                    for idx, gejala in enumerate(sorted(overlap), start=1):
                        cf_expert = DEFAULT_CF  # CF dari pakar
                        cf_user = cf_user_default  # CF dari user
                        cf_combine = cf_expert * cf_user  # CF(H,E) = CF(H) * CF(E)
                        
                        gejala_details.append({
                            "kode": f"G{idx:02d}",
                            "gejala": gejala,
                            "cf_expert": cf_expert,
                            "cf_user": cf_user,
                            "cf_combine": cf_combine,
                            "formula": f"CF(H,E) = CF(H) × CF(E) = {cf_expert} × {cf_user} = {cf_combine}"
                        })
                        cf_combines.append(cf_combine)
                    
                    # Hitung CF Total menggunakan kombinasi CF
                    cf_total = cf_combines[0] if cf_combines else 0
                    cf_combination_steps = []
                    
                    if len(cf_combines) > 1:
                        for i in range(1, len(cf_combines)):
                            cf_old = cf_total
                            cf_new = cf_combines[i]
                            # CF_combine = CF_old + CF_new * (1 - CF_old)
                            cf_total = cf_old + cf_new * (1 - cf_old)
                            cf_combination_steps.append({
                                "step": i,
                                "formula": f"CF_old + CF_new × (1 - CF_old)",
                                "calculation": f"{cf_old:.3f} + {cf_new:.3f} × (1 - {cf_old:.3f}) = {cf_total:.3f}"
                            })
                    
                    calculation_details = {
                        "rekomendasi": sol,
                        "gejala_matched": len(overlap),
                        "gejala_total": len(cond_set),
                        "overlap_ratio": overlap_ratio,
                        "gejala_details": gejala_details,
                        "cf_combination_steps": cf_combination_steps,
                        "cf_total": cf_total,
                        "cf_total_percentage": round(cf_total * 100, 2)
                    }
                    
                    print(f"[CF] Candidate: {sol[:50]}...")
                    print(f"     Overlap: {sorted(overlap)} ({overlap_count}/{len(cond_set)} = {overlap_ratio:.0%})")
                    print(f"     CF Total: {cf_total:.3f}\n")
                    
                    if cf_total > best_cf:
                        best_cf, best_sol = cf_total, sol
                        best_details = calculation_details
        
        print(f"[CF] Final result: {best_sol[:80]}... (CF: {best_cf:.3f})\n")
        return best_sol, best_cf, best_details
    
    def filter_by_product(self, jenis_perbaikan_input):
        """
        Filter dataframe berdasarkan jenis perbaikan/produk
        """
        jenis_phrases = set(split_phrases(jenis_perbaikan_input))
        
        filtered_rows = []
        for _, row in self.df.iterrows():
            row_jenis = set(split_phrases(row.get("jenis_perbaikan", "")))
            # Check if ada overlap antara input dan data
            if jenis_phrases & row_jenis:  # Set intersection
                filtered_rows.append(row)
        
        if filtered_rows:
            return pd.DataFrame(filtered_rows)
        else:
            return self.df  # Fallback ke semua data jika tidak ada match
