# ==========================================================
# DECISION TREE MODEL MODULE
# ==========================================================

from sklearn.model_selection import train_test_split
from sklearn.tree import DecisionTreeClassifier


class DecisionTreeModel:
    """
    Decision Tree Classifier untuk rekomendasi perbaikan
    """
    
    def __init__(self):
        self.model = DecisionTreeClassifier(random_state=42)
        self.is_trained = False
    
    def train(self, X, y, test_size=0.3):
        """
        Train decision tree model
        """
        X_train, _, y_train, _ = train_test_split(X, y, test_size=test_size, random_state=42)
        self.model.fit(X_train, y_train)
        self.is_trained = True
    
    def predict(self, X):
        """
        Predict rekomendasi
        """
        if not self.is_trained:
            raise ValueError("Model belum ditraining. Jalankan train() terlebih dahulu.")
        return self.model.predict(X)[0]
    
    def get_confidence(self, X):
        """
        Get confidence/probability dari prediksi
        """
        if not self.is_trained:
            raise ValueError("Model belum ditraining. Jalankan train() terlebih dahulu.")
        probabilities = self.model.predict_proba(X)[0]
        return max(probabilities)
