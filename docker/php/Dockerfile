FROM php:7.3-fpm

# تثبيت متطلبات النظام، مكتبات PDF، وأدوات النسخ الاحتياطي لقاعدة البيانات
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client

# تنظيف الكاش لتخفيف حجم الحاوية
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# تثبيت إضافات PHP المتوافقة مع Laravel 5.7 و DomPDF
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath dom xml
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd

# تثبيت إضافة Redis البرمجية للاتصال السريع
RUN pecl install redis-5.3.7 && docker-php-ext-enable redis

# جلب Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# تحديد مسار العمل الأساسي
WORKDIR /var/www/html