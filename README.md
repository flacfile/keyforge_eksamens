# Interneta veikals “KeyForge”

## Projekta apraksts
KeyForge ir tīmekļa e-komercijas platforma digitālo spēļu atslēgām. Lietotāji var pārlūkot vai meklēt spēles, skatīt detalizētu informāciju par produktiem, pievienot produktus iepirkumu grozam un droši iegādāties spēļu atslēgas tiešsaistē. Platforma atbalsta lietotāju reģistrāciju, pieteikšanos un personīgo kabinetu pasūtījumu pārvaldībai. Ir iekļautas administrēšanas funkcijas un maksājumu integrācija (Stripe), lai nodrošinātu pilnīgu tiešsaistes veikala pieredzi.

## Galvenās funkcijas
- Lietotāju reģistrācija un autentifikācija
- Produktu katalogs ar meklēšanu un filtrēšanu
- Iepirkumu groza pārvaldība
- Droša izrakstīšanās un maksājumu apstrāde
- Pasūtījumu vēsture un atslēgu piegāde
- Administratora panelis produktu, lietotāju un pasūtījumu pārvaldībai

## Izmantotās tehnoloģijas
- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP
- **Datubāze:** MySQL

## Kā palaist projektu lokāli

### 1. Klonējiet vai lejupielādējiet projektu
```
git clone https://github.com/flacfile/keyforge_eksamens.git
```

### 2. Pārvietojiet projektu uz tīmekļa servera direktoriju
1. XAMPP gadījumā pārvietojiet projekta mapi uz `C:\xampp\htdocs\`
2. Pārdēvējiet projekta mapi uz `keyforge_eksamens`

### 3. Iestatiet datubāzi
1. Palaidiet Apache un MySQL no XAMPP vadības paneļa.
2. Atveriet phpMyAdmin (http://localhost/phpmyadmin).
3. Izveidojiet jaunu datubāzi (keyforge).
4. Importējiet SQL shēmu: `config/keyforge_db.sql`

### 4. Konfigurējiet datubāzes savienojumu
Atveriet konfigurācijas failu `assets\functionality\db.php`.
Iestatiet datubāzes un servera nosaukumu, lietotājvārdu un paroli:
```
$servername = "";
$username = "";
$password = "";
$dbname = "keyforge";

$conn = new mysqli($servername, $username, $password, $dbname);
```

### 5. Iestatiet Stripe atslēgu un šifrēšanas atslēgu
Atveriet konfigurācijas failu `config\secrets.php`.
```
define('STRIPE_SECRET_KEY', '');
define('ENCRYPTION_KEY', '');
```

### 6. Atveriet projekta saiti
`http://localhost/keyforge_eksamens/`

### Administratora konts
- **E-pasts:** admin@keyforge.test
- **Parole:** t3st4dm!nth1ngz
