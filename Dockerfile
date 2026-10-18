# Menggunakan image PHP dengan ekstensi yang dibutuhkan Laravel
FROM php:8.2-cli

# Instal dependensi sistem dan ekstensi PHP untuk MySQL
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Salin semua file proyek ke dalam kontainer
WORKDIR /var/www
COPY . .

# Jalankan server bawaan Laravel pada port 8000
CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
