# PHP-FPM untuk Nginx 
FROM php:8.2-fpm                                    # Menggunakan base image resmi PHP 8.2 dengan FPM
# Install MySQL extensions 
RUN docker-php-ext-install mysqli pdo pdo_mysql     # Menginstall ekstensi PHP untuk koneksi MySQL (mysqli & PDO)
# Set working directory
WORKDIR /var/www/myphpapp                           # Menentukan folder kerja utama di dalam container
# Set proper permissions 
RUN chown -R www-data:www-data /var/www/myphpapp    # Mengubah kepemilikan folder agar sesuai user PHP-FPM (www-data)
# Expose port 9000 untuk PHP-FPM 
EXPOSE 9000                                         # Membuka port 9000 agar Nginx bisa berkomunikasi dengan PHP-FPM
