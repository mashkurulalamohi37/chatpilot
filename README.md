# ChatPilot - AI Powered WhatsApp Marketing SaaS

![ChatPilot](marketing_assets/inline_preview.png)

**ChatPilot** is a production-ready SaaS application built with **Laravel 10** and **Bootstrap 5**. It allows businesses to automate WhatsApp marketing campaigns, manage contacts, and provide AI-powered customer support using the official Meta Cloud API.

🚀 **Live Demo:** [http://chatpilot.rf.gd](http://chatpilot.rf.gd)  
🔑 **Demo Credentials:** `admin@chatpilot.com` / `password`

---

## 🌟 Key Features

*   ✅ **SaaS Ready**: Integrated Subscription system with Stripe Payment Gateway.
*   ✅ **Official Meta API**: Uses the whitespace-compliant WhatsApp Cloud API (No risk of banning).
*   ✅ **Bulk Campaigns**: Send thousands of messages asynchronously using Laravel Queues.
*   ✅ **AI Smart Bots**: Integrated OpenAI (ChatGPT) to handle automated responses.
*   ✅ **Live Chat / Inbox**: Real-time multi-agent chat interface for manual intervention.
*   ✅ **Contact Management**: Import, export, and manage contacts with custom attributes.
*   ✅ **Dark Mode**: Beautiful, high-contrast dark UI for professional usage.
*   ✅ **Multi-Tenancy**: Data isolation for every user (SaaS structure).

---

## 🛠️ Tech Stack

*   **Backend**: Laravel 10 (PHP 8.1+)
*   **Frontend**: Blade Templates, Bootstrap 5, Vanilla JS
*   **Database**: MySQL 8.0
*   **Queue**: Database / Redis
*   **APIs**: Meta Cloud API (WhatsApp), OpenAI API, Stripe API

---

## ⚙️ Server Requirements

*   PHP >= 8.1
*   BCMath PHP Extension
*   Ctype PHP Extension
*   Fileinfo PHP Extension
*   JSON PHP Extension
*   Mbstring PHP Extension
*   OpenSSL PHP Extension
*   PDO PHP Extension
*   Tokenizer PHP Extension
*   XML PHP Extension

---

## 📦 Installation (Local Development)

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/mashkurulalamohi37/chatpilot.git
    cd chatpilot
    ```

2.  **Install Dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Config:**
    *   Create a MySQL database (e.g., `chatpilot`).
    *   Update `.env` with DB credentials.

5.  **Run Migrations & Seeders:**
    ```bash
    php artisan migrate --seed
    ```

6.  **Serve Application:**
    ```bash
    php artisan serve
    ```
    Visit `http://localhost:8000`.

---

## 🚀 Deployment (Shared Hosting)

1.  Upload files to your server (e.g., `public_html` or `htdocs`).
2.  If the server root is `public_html`, move contents of `public/` to `public_html/` and adjust `index.php` paths.
3.  Set `APP_ENV=production` and `APP_DEBUG=false` in `.env`.
4.  Import the database SQL file via phpMyAdmin.
5.  **Important**: Ensure your hosting supports `PUT`, `DELETE` methods and URL rewriting (`.htaccess`).

---

## 📄 License
This project is proprietary software.

---
*Built with ❤️ by ChatPilot Team*
