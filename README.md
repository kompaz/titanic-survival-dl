# 🧠 Titanic Survival Prediction API

Bu proje, Titanic yolcularının hayatta kalıp kalamayacağını tahmin etmek amacıyla geliştirilmiş bir derin öğrenme uygulamasıdır. Flask ile oluşturulmuş bir REST API üzerinden eğitimli modeli kullanarak JSON formatında veri alır ve tahmin sonucu döner.

---

## 🎯 Amaç

Bu projeyi yapmaktaki amacım, veri bilimi sürecinin sadece model eğitmekten ibaret olmadığını; aynı zamanda veriyi doğru temsil etmek, işlemek ve servis edilebilir bir yapıya sokmanın da en az model kadar önemli olduğunu deneyimlemekti.

---

## 🤖 Kullandığım Yöntemler ve Teknolojiler

- **Python + Flask**: Hafif bir REST API oluşturmak için
- **TensorFlow / Keras**: Sigmoid aktivasyonlu derin öğrenme modeli eğitmek için
- **scikit-learn + joblib**: Veriyi ölçeklemek ve scaler nesnesini kayıt etmek için
- **Pandas**: Veri çerçevesi işlemleri
- **JSON tabanlı giriş**: API ile veri alma
- **Postman / Hoppscotch**: API testleri

Model `.h5` formatında kayıt edilmiştir, veriler ise `scaler.pkl` ile normalize edilmiştir. API, POST yöntemiyle gelen verileri işleyip sonucu döner.

---

## 🧠 Öğrendiklerim

Bu projede sadece bir model geliştirmekle kalmadım, aynı zamanda aşağıdaki konularda da derinlemesine pratik yaptım:

- Gerçek dünya verisinde eksik değerlerle nasıl başa çıkılır?
- Categorical veriler nasıl sayısallaştırılır?
- Modeli `.h5` olarak kaydedip Flask ile dış dünyaya nasıl açarım?
- JSON formatındaki veriyi nasıl işlerim?


