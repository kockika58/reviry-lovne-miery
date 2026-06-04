# 🎣 Lovné Miery Reviérov - Informačný Portál

Webová aplikácia na zobrazenie povolených lovných miér rýb v jednotlivých reviéroch Slovenska. Portál informuje o sezónnych zákazoch, individuálnych ochranách a špecifických pravidlách pre každý reviér.

## 📋 Obsah

- [Požiadavky](#požiadavky)
- [Inštalácia](#inštalácia)
- [Konfigurácia](#konfigurácia)
- [Použitie](#použitie)
- [Štruktúra projektu](#štruktúra-projektu)
- [Typy vôd](#typy-vôd)
- [Licencia](#licencia)

## 🔧 Požiadavky

- PHP 7.4+
- MySQL 5.7+
- Web server (Apache, Nginx)
- Composer (voliteľné)

## 📥 Inštalácia

### 1. Klonuj repozitár

```bash
git clone https://github.com/kockika58/reviry-lovne-miery.git
cd reviry-lovne-miery
```

### 2. Vytvor databázu

```bash
mysql -u root -p < database/schema.sql
```

Alebo manuálne v PHPMyAdmin:
1. Vytvor novú databázu: `lovne_miery`
2. Importuj súbor `database/schema.sql`

### 3. Nakonfiguruj databázu

Uprav súbor `config/Database.php`:

```php
private $host = 'localhost';      // Hostiteľ MySQL
private $db_name = 'lovne_miery'; // Názov databázy
private $user = 'root';           // Používateľ MySQL
private $password = '';           // Heslo MySQL
```

### 4. Nastav práva na adresáre

```bash
chmod 755 public
chmod 755 public/css
```

## ⚙️ Konfigurácia

### Web Server Configuration (Apache)

Umiestnite `.htaccess` do adresára `public/`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?/$1 [L]
</IfModule>
```

### Nginx Configuration

```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/reviry-lovne-miery/public;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

## 📖 Použitie

### Domovská stránka

Navštív: `http://localhost/reviry-lovne-miery/public/index.php`

### Prehliadanie reviérov

1. **Všetky reviéry**: `reviery.php`
2. **Filter podľa typu**: `reviery.php?typ=1` (typ 1-5)
3. **Vyhľadávanie**: `reviery.php?search=Dunaj`

### Zobrazenie detailov reviéru

`detail.php?id=1` - Zobrazí všetky lovné miery pre reviér s ID 1

## 📁 Štruktúra projektu

```
reviry-lovne-miery/
├── config/
│   └── Database.php          # Konfigurácia databázy
├── database/
│   └── schema.sql            # SQL skript na vytvorenie databázy
├── models/
│   ├── Reviery.php           # Model pre reviéry
│   └── LovneMiery.php        # Model pre lovné miery
├── public/
│   ├── index.php             # Domovská stránka
│   ├── reviery.php           # Zoznam reviérov
│   ├── detail.php            # Detail reviéru
│   └── css/
│       └── style.css         # Štýly
└── README.md                 # Dokumentácia
```

## 🎨 Typy vôd

| Typ | Farba | Názov | Lov |
|-----|-------|-------|-----|
| 1 | 🔵 Modrá | Kaprové vody - Tečúce | Celoročný |
| 2 | 🔴 Červená | Kaprové vody - Nádrže | Zákaz 15.3-31.5 |
| 3 | 🟢 Zelená | Kaprové vody - Ostatné | Celoročný |
| 4 | 🟡 Žltá | Pstruhové vody | Zákaz 1.10-15.4 |
| 5 | 🟠 Oranžová | Lipňové vody | Zákaz 1.1-31.5 |

## 📊 Databázová štruktúra

### Tabuľka: `typy_vod`
- `id` - ID typu (1-5)
- `nazev` - Názov typu
- `farba` - Farba typu
- `popis` - Popis

### Tabuľka: `reviery`
- `id` - ID reviéru
- `kod_revieru` - Kód reviéru (napr. 1-0020-1-1)
- `nazev` - Názov reviéru
- `typ_vody_id` - Typ vody (FK)
- `podtyp` - Podtyp (kanál, nádrž, štrkovisko...)
- `plocha_ha` - Plocha v hektároch
- `lokalita` - Lokalita
- `zakaz_od` - Dátum začatia zákazu
- `zakaz_do` - Dátum konca zákazu
- `povinnosti` - Povinnosti a zákazy

### Tabuľka: `druhy_ryb`
- `id` - ID druhu
- `nazev` - Názov druhu
- `vedecky_nazev` - Vedecký názov

### Tabuľka: `lovne_miere`
- `id` - ID
- `reviera_id` - ID reviéru (FK)
- `druh_ryby_id` - ID druhu ryby (FK)
- `rok` - Rok
- `min_dlzka_cm` - Minimálna dĺžka v cm
- `max_dlzka_cm` - Maximálna dĺžka v cm
- `max_pocet` - Maximálny počet kusov

## 🚀 Nasadenie na server

### Lokálne testovanie

```bash
cd public
php -S localhost:8000
```

Navštív: `http://localhost:8000`

### Produkčné nasadenie

1. Nahraj súbory na server
2. Nastav práva na adresáre: `chmod 755 public`
3. Vytvor databázu a importuj SQL skript
4. Aktualizuj `config/Database.php` s produkčnými údajmi
5. Zabezpečuj server (HTTPS, firewall...)

## 📝 Príklady API

### Získaj všetky reviéry konkrétneho typu

```php
$revieryModel = new Reviery($conn);
$reviery = $revieryModel->getByType(1); // typ 1 = modrá
```

### Vyhľadaj reviér

```php
$reviery = $revieryModel->search('Dunaj');
```

### Získaj lovné miery pre reviér

```php
$loveneMiery = $revieryModel->getLoveneMiery($reviera_id);
```

## 🔐 Bezpečnosť

- Všetky vstupy sú sanitizované
- Používajú sa prepared statements (PDO)
- Databázové heslo nikdy nie je v kóde
- Vstupy sú HTML escapované

## 📄 Licencia

MIT License - Voľné použitie a úprava

## 👤 Autor

Vytvorené pre Slovenský rybársky zväz (SRZ)

## 📞 Podpora

Pre otázky alebo chyby vytvor Issue na GitHub:
https://github.com/kockika58/reviry-lovne-miery/issues

---

**© 2026 Slovenský rybársky zväz. Všetky práva vyhradené.**
