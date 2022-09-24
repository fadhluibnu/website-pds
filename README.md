# Install Website PDS

### Requirement :

-   **PHP Versi 8 Keatas**
-   **Composer**

### 1. Clone Project Github

```cmd
git clone https://github.com/fadhluibnu/website-pds.git
```

### 2. Masuk Ke Folder, dan Install Dependensi

```
composer install
```

### 3. Rename File `.env.example` Menjadi `.env`

![Env](/Install/env_example.PNG)

![Env](/Install/env.PNG)

### 4. Generate APP Key

```
php artisan key:generate
```

### 5. Buka File `.env`

Ubah `APP_KEY` dan `APP_DEBUG` menjadi

```env
APP_ENV=production
APP_DEBUG=false
```

### 6. Run Project

```
php artisan serve
```
