from flask import Flask, request, jsonify
import pandas as pd
from sklearn.preprocessing import StandardScaler
from tensorflow.keras.models import load_model
import joblib

app = Flask(__name__)

# Modeli yükle
scaler = joblib.load('scaler.pkl')

# Modeli yükle
model = load_model('model.h5')

def manual_preprocess_df(df):
    df['Embarked'] = df['Embarked'].map({'C': 0, 'Q': 1, 'S': 2})
    df['Sex'] = df['Sex'].map({'male': 0, 'female': 1})
    df['Age'] = df['Age'].fillna(df['Age'].mean())
    return df

@app.route('/', methods=['POST'])
def home():
    try:
        # İstekten JSON verilerini al
        data = request.json
        data_df = pd.DataFrame([data])

        # Gelen veriyi aynı şekilde dönüştürün
        data_df = manual_preprocess_df(data_df)

        # Veriyi ölçeklendirin
        scaled_data = scaler.transform(data_df)

        # Modeli kullanarak tahmin yapın
        prediction = model.predict(scaled_data)

        if prediction > 0.5:
            result = "Survived"
        else:
            result = "Not Survived"

        # Tahmini JSON olarak döndürün
        return jsonify({'prediction': prediction.tolist(), 'result': result})

    except Exception as e:
        return jsonify({'error': str(e)})

if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000)
