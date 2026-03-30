# ☄️ Lab-NativePHP-ChatAi

**Pure PHP Native AI Interface | TALL Stack Architecture | NativePHP v3**

A technical laboratory demonstrating high-performance AI integration within a **Native PHP** environment. This project bypasses heavy JS frameworks in favor of the **TALL Stack** and seamless **Gemini API** communication, optimized for Android and Desktop.

---
## Phase 1: Prerequisites (Windows Environment)

Before initialization, ensure your system is configured for the Android build pipeline:

* **PHP 8.2+** (`php -v`)
* **Composer & NPM**
* **Android Studio 2024.2.1+** (SDK API 33+ & Emulator)
* **7-Zip** (Required for Windows extraction)

### Environment Variables
Configure these in your Windows System Variables:

| Variable | Typical Path |
| :--- | :--- |
| **ANDROID_HOME** | `C:\Users\User\AppData\Local\Android\Sdk` |
| **JAVA_HOME** | `C:\Program Files\Android\Android Studio\jbr` |
| **NATIVEPHP_7ZIP_LOCATION** | `C:\Program Files\7-Zip\7z.exe` |

> **Note:** Add `%ANDROID_HOME%\platform-tools` and `%JAVA_HOME%\bin` to your system **Path**.

---

## 🚀 Installation & Setup

### 1. Project Initialization
```bash
composer create-project laravel/laravel app
cd app
composer require nativephp/mobile
```
## Phase 2: Interface & Branding

### 3. Hello World" Implementation
Validated the Native WebView by rendering a minimalist TALL stack interface.
Backend: Laravel 13 Web Routes.
Frontend: Alpine.js for zero-refresh reactivity.
Result: Successfully rendered a "Hello World" screen within the native Android/Windows container.

### 4. Custom Asset Branding (Icon)
Replaced the default framework assets with a custom industrial-style icon.
Process: Updated resources/ assets with a high-resolution logo.
Update: Compiled the assets using native:run to reflect the new branding in the OS taskbar and app drawer.

## 🧠 Phase 3: AI Logic & Mobile Integration

### 5. Gemini API Integration
Created a secure bridge to the Google Gemini API to enable real-time chat capabilities.
API Layer: Developed a Laravel controller to manage secure POST requests.
Reactive Display: Used Alpine.js to handle the asynchronous stream of AI data directly in the mobile view.

