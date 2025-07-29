# 📎 NanoLink

**NanoLink** is a minimalistic, stateless, and zero-dependency PHP URL shortener. It uses SQLite for persistent storage and [Medoo](https://medoo.in) as a lightweight database wrapper. Perfect for small projects, self-hosted tools, or educational purposes.

---

### 📦 Features

* ✂️ URL shortening with unique 10-character codes
* 🔁 Redirection system based on the shortened code
* ✅ Validates and sanitizes input URLs
* 💾 Lightweight SQLite database (auto-creates if not present)
* 🧱 Clean and extensible PHP structure (OOP with PSR-4 autoloading)
* ⚡ No external dependencies except [Medoo](https://medoo.in)

---

### 🚀 Quick Start

#### 1. Clone the project

```bash
git clone https://github.com/devh3n/NanoLink.git
cd NanoLink
```

#### 2. Install dependencies via Composer

```bash
composer install
```

#### 3. Configure the domain

Edit `config/config.php` and set your domain (can include subfolder):

```php
return [
    "domain" => "http://yourdomain.com"
];
```

> ⚠️ Note: Use **full URL** like `http://localhost/shortUrl` for local testing.

#### 4. Set up the server

Point your web server (Apache, Nginx, etc.) to the `public_html` directory as document root.

For example with PHP’s built-in server:

```bash
php -S localhost:8000 -t public_html
```

---

### 🔍 Usage

#### ➕ Create a short URL

Send a GET request with a `url` parameter:

```
http://localhost/shortUrl/?url=https://example.com
```

You’ll get back a shortened link like:

```
localhost/shortUrl/?aB3xT92qLs=1
```

#### 🔁 Redirect from shortened URL

Visit the returned URL (e.g. `/?aB3xT92qLs=1`) and you’ll be redirected to the original URL.

---

### 🗃️ Project Structure

```
NanoLink/
├── config/
│   └── config.php          # Basic configuration
├── database/               # SQLite DB auto-created here
├── public_html/
│   └── index.php           # Main entry point for the app
├── src/
│   ├── Database.php        # SQLite connection (via Medoo)
│   └── Url.php             # Logic for validation & code mapping
├── composer.json
```

---

### ⚙️ How It Works

* The app checks `$_GET["url"]` for a valid URL and returns a short code.
* URLs and their codes are saved in SQLite (`urls` table).
* When someone visits a link like `/?code=1`, the app retrieves the original URL and redirects.
* If the code is invalid or missing, `404 - Not Found` is shown.

---

### 📄 Requirements

* PHP 8.0+
* Composer
* SQLite (enabled in PHP)
* Web server (Apache, Nginx, or built-in)

---

### ✅ To Do / Ideas

* Add admin panel for managing links
* Add expiry or hit counter for each URL
* RESTful API version (optional)
* Optional authentication

---

### 📖 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

### 👨‍💻 Author

Made with 💡 by [devh3n](https://github.com/devh3n)
