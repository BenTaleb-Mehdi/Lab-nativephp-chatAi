# ☄️ Lab-NativePHP-ChatAi
**Pure PHP Native AI Interface | TALL Stack Architecture**

A technical laboratory demonstrating high-performance AI integration within a **Native PHP** environment. This project bypasses heavy JS frameworks in favor of the **TALL Stack**, and seamless **Gemini API** communication.

---

## Stack
* **Backend:** Laravel 13 (Latest Stable)
* **Native Engine:** NativePHP 3.0 (Desktop & Android Support)
* **Reactive UI:** Alpine.js 3.x 
* **Styling:** Tailwind CSS (Industrial Design)
* **Build Tool:** Vite 6.x (Optimized for Native WebView)
* **AI Logic:** Google Gemini API Integration

## 🛠 Key Features
* **Architecture:** High-speed reactivity handled entirely by Alpine.js, reducing bundle size and memory usage in the Android Emulator.
* **Session Management:** Intelligent chat history persistence using LocalStorage.
* **Industrial Aesthetic:** * **Monochrome Palette:** Pure black and white interface.
    * **Precision UI:** Sharp 1px borders and technical typography.
* **Mobile Optimized:** Fully responsive layout designed specifically for Android WebView and Native windows.

## 🚀 Installation & Local Setup

### 1. Clone the Repository
```bash
git clone [https://github.com/BenTaleb-Mehdi/Lab-nativephp-chatAi.git](https://github.com/BenTaleb-Mehdi/Lab-nativephp-chatAi.git)
cd Lab-nativephp-chatAi
```
### 2. Install Dependencies
```bash
composer install
npm install && npm run build
```
### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```
### 4. Launch via NativePHP (Android)
```bash
# Set 7-Zip path for the build process
$env:NATIVEPHP_7ZIP_LOCATION = "C:\Program Files\7-Zip\7z.exe"

# Launch on Android Emulator
php artisan native:run
```