# 🎣 Pokyn na Inštaláciu

## Krok-po-Krok Inštalácia

### Predpoklady
- PHP 7.4 alebo vyššie
- MySQL 5.7 alebo vyššie
- Web server (Apache alebo Nginx)
- Príkazový riadok / Terminal

### 1. Stiahnutie Projektu

```bash
# Cez Git
git clone https://github.com/kockika58/reviry-lovne-miery.git
cd reviry-lovne-miery

# Alebo stiahni ZIP a rozbaľ
```

### 2. Príprava Adresárov

```bash
# Nastav práva na čítanie/písanie
chmod 755 public
chmod 755 public/css
mkdir -p logs
chmod 755 logs
```

### 3. Vytvorenie Databázy

#### Možnosť A: Cez PHPMyAdmin

1. Otvor PHPMyAdmin (zvyčajne http://localhost/phpmyadmin)
2. Klikni na "Nová databáza"
3. Názov: `lovne_miery`
4. Zhoda: `utf8mb4_unicode_ci`
5. Klikni "Vytvoriť"
6. Vyber databázu a klikni "Importovať"
7. Vyber súbor `database/schema.sql`
8. Klikni "Spustiť"

#### Možnosť B: Cez Príkazový Riadok

```bash
# Vytvor databázu
mysql -u root -p -e "CREATE DATABASE lovne_miery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Importuj schému
mysql -u root -p lovne_miery < database/schema.sql
```

### 4. Konfigurácia Databázy

Otvor `config/Database.php` a aktualizuj údaje:

```php
private $host = 'localhost';      // Adresa MySQL servera
private $db_name = 'lovne_miery'; // Názov databázy
private $user = 'root';           // Používateľ MySQL
private $password = '';           // Heslo MySQL (zvyčajne prázdne na lokálnom)
```

### 5. Testovanie Lokálne

#### S vstavanú PHP serverom

```bash
cd public
php -S localhost:8000
```

Nav­štív: http://localhost:8000

#### S Apache

Umiestnite projekt do `htdocs` (Windows) alebo `/var/www` (Linux)

```
http://localhost/reviry-lovne-miery/public/
```

#### S Nginx

Konfiguruj `nginx.conf`:

```nginx
server {
    listen 80;
    server_name localhost;
    root /var/www/reviry-lovne-miery/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 6. Overenie Inštalácie

Nav­štív: http://localhost:8000/index.php

Mal by si vidieť:
- ✅ Domovská stránka s 5 farebnými kartami
- ✅ Vyhľadávacia pole
- ✅ Navigácia

### 7. Prvé Kroky

1. Klikni na ktorúkoľvek farbu na domovskej stránke
2. Mali by si vidieť zoznam reviérov
3. Klikni na "Zobraziť lovné miery"
4. Mali by si vidieť tabuľku s lovnými mierami

## Riešenie Problémov

### "Chyba pripojenia k databáze"

- ✓ Skontroluj `config/Database.php` - správne údaje?
- ✓ Je MySQL server spustený?
- ✓ Existuje databáza `lovne_miery`?
- ✓ Skontroluj MySQL užívateľa a heslo

### "Práva na súbory - Permission denied"

```bash
chmod -R 755 public
chmod -R 755 logs
```

### "Stránka buď nenájdená (404)"

- ✓ Skontroluj cestu URL
- ✓ Skontroluj konfigu Apache/Nginx
- ✓ Presunúť `.htaccess` do `public/` priečinka

### "Databáza je prázdna"

Skontroluj či SQL skript bol úspešne importovaný:

```bash
mysql -u root -p lovne_miery -e "SHOW TABLES;"
```

Mal by si vidieť:
- typy_vod
- reviery
- druhy_ryb
- lovne_miere

### "Zoznam reviérov je prázdny"

Databáza obsahuje len príklady. Musíš pridať viac reviérov:

```bash
mysql -u root -p lovne_miery < database/schema.sql
```

## Nasadenie na Produkcii

### 1. Uploaduj Súbory

Nahrá všetky súbory na server (okrem `.git`, `logs`, `tmp`)

### 2. Nastav Práva

```bash
chmod -R 755 public
chmod -R 775 logs
chmod 600 config/Database.php
```

### 3. Bezpečnosť

- ✓ Nastav HTTPS
- ✓ Odstráň `.env` súbor
- ✓ Skryj chyby: `display_errors = Off` v `php.ini`
- ✓ Nastav firewall

### 4. Konfigúrácia

```php
// config/Database.php
private $host = 'mysql.example.com';
private $db_name = 'lovne_miery_prod';
private $user = 'db_user';
private $password = 'bezpecne_heslo';
```

### 5. Testovanie

Nav­štív: https://example.com/reviery.php

## Údržba

### Zálohovanie Databázy

```bash
mysqldump -u root -p lovne_miery > backup_$(date +%Y%m%d).sql
```

### Obnova z Zálohy

```bash
mysql -u root -p lovne_miery < backup_20240604.sql
```

### Aktualizácia Údajov

Prepisuj tabuľky SQL príkazmi alebo cez PHPMyAdmin

## Podpora

Ak narazíš na problém:

1. Skontroluj `logs/` adresár na chyby
2. Overuj `config/Database.php`
3. Skús vyčistiť cache a cookies
4. Vytvor Issue na: https://github.com/kockika58/reviry-lovne-miery/issues

---

**Ľahkú inštaláciu! 🎣**
