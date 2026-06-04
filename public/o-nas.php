<?php
/**
 * About page - O projekte
 */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O projekte - Lovné miery reviérov</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .about-content {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            line-height: 1.8;
            margin-bottom: 30px;
        }
        
        .about-content h2 {
            color: #1976D2;
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .about-content h2:first-child {
            margin-top: 0;
        }
        
        .about-content p {
            margin-bottom: 15px;
            color: #666;
        }
        
        .about-content ul {
            margin-left: 20px;
            margin-bottom: 15px;
        }
        
        .about-content li {
            margin-bottom: 8px;
            color: #666;
        }
        
        .contact-box {
            background: #e3f2fd;
            padding: 20px;
            border-left: 4px solid #1976D2;
            border-radius: 4px;
            margin: 30px 0;
        }
        
        .contact-box strong {
            color: #1976D2;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>🎣 Lovné Miery Reviérov</h1>
            <p>Informačný portál o povolených lovných mierach rýb v jednotlivých reviéroch</p>
        </div>
    </header>

    <nav class="navbar">
        <div class="container">
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="reviery.php">Všetky reviéry</a></li>
                <li><a href="o-nas.php" class="active">O projekte</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <div class="about-content">
            <h2>O Projekte</h2>
            <p>Informačný portál <strong>Lovné Miery Reviérov</strong> je interaktívna webová aplikácia, ktorá poskytuje aktuálne informácie o povolených lovných mierach rýb v jednotlivých reviéroch na území Slovenska.</p>

            <h2>Cieľ Projektu</h2>
            <p>Hlavným cieľom portálu je:</p>
            <ul>
                <li>Poskytnúť jednotným a ľahko prístupným zdrojom informácií o lovných mierach</li>
                <li>Informovať rybárov o sezónnych zákazoch a ochranných limitoch</li>
                <li>Uľahčiť vyhľadávanie informácií pre konkrétne reviéry a druhy rýb</li>
                <li>Prispieť k dodržiavaniu pravidiel a ochranu rybích zdrojov</li>
            </ul>

            <h2>Typy Vôd</h2>
            <p>Portál rozdeľuje vody podľa ich charakteru a typu lovu do 5 kategórií:</p>
            <ul>
                <li><strong>🔵 Kaprové vody - Tečúce (Modrá)</strong> - Vodné toky s celoročným lovom</li>
                <li><strong>🔴 Kaprové vody - Nádrže (Červená)</strong> - Vodné nádrže so sezónnym zákazom</li>
                <li><strong>🟢 Kaprové vody - Ostatné (Zelená)</strong> - Jazerá a štrkoviská s celoročným lovom</li>
                <li><strong>🟡 Pstruhové vody (Žltá)</strong> - Studenú vodu milujúce rýby</li>
                <li><strong>🟠 Lipňové vody (Oranžová)</strong> - Špecializované reviéry</li>
            </ul>

            <h2>Funkcionalita</h2>
            <p>Portál vám umožňuje:</p>
            <ul>
                <li>Prehliadať všetky reviéry s ich charakteristikami</li>
                <li>Filtrovať reviéry podľa typu vody</li>
                <li>Vyhľadávať konkrétne reviéry podľa názvu alebo kódu</li>
                <li>Zobraziť detailné informácie o lovných mierach pre každý druh ryby</li>
                <li>Vidieť informácie o sezónnych zákazoch a povinnostiach</li>
                <li>Poznať minimálne a maximálne veľkosti ryb a limitný počet kusov</li>
            </ul>

            <h2>Ako Používať Portál</h2>
            <p><strong>Krok 1 - Domovská stránka:</strong> Na domovskej stránke vidíte prehľad 5 typov vôd rozdelených podľa farieb. Kliknutím na ktorýkoľvek typ sa zobrazia všetky reviéry daného typu.</p>
            <p><strong>Krok 2 - Vyhľadávanie:</strong> Ak hľadáte konkrétny reviér, zadajte jeho názov alebo kód do vyhľadávacieho poľa.</p>
            <p><strong>Krok 3 - Zoznam Reviérov:</strong> Zobrazí sa zoznam reviérov s kľúčovými informáciami, ako napríklad lokalita, plocha a informácia o zákaze lovu.</p>
            <p><strong>Krok 4 - Detail Reviéru:</strong> Kliknutím na "Zobraziť lovné miery" sa zobrazí tabuľka so všetkými lovnými mierami pre daný reviér.</p>

            <h2>Lovné Miery - Čo Znamenajú</h2>
            <ul>
                <li><strong>Minimálna dĺžka (Min. dĺžka):</strong> Najmenšia povolená veľkosť ryby v centimetroch. Rybky menšej veľkosti musíte vrátiť do vody.</li>
                <li><strong>Maximálna dĺžka (Max. dĺžka):</strong> Najväčšia povolená veľkosť ryby. Väčšie ryby musíte vrátiť do vody (ochrana veľkých reprodukčných jedincov).</li>
                <li><strong>Maximálny počet (Max. počet):</strong> Maximálny počet kusov konkrétneho druhu, ktorý môžete chytiť za deň.</li>
            </ul>

            <h2>Dôležité Upozornenia</h2>
            <ul>
                <li>Vždy si skontrolujte sezónne zákazy pred návštevou reviéru</li>
                <li>Dodržujte všetky povinnosti a zákazy uvedené pre daný reviér</li>
                <li>Rešpektujte minimálne a maximálne veľkosti rýb</li>
                <li>Neprekročite limitný počet kusov</li>
                <li>Majte vždy pri sebe platný rybársky lístok</li>
                <li>Informácie sa môžu zmeniť - pre najnovšie údaje kontaktujte SRZ</li>
            </ul>

            <div class="contact-box">
                <strong>📞 Kontakt:</strong><br>
                Slovenský rybársky zväz<br>
                <a href="mailto:info@srz.sk">info@srz.sk</a><br>
                www.srz.sk
            </div>

            <h2>Technické Informácie</h2>
            <p>Portál je vyvinutý s použitím:</p>
            <ul>
                <li>PHP 7.4+</li>
                <li>MySQL databáza</li>
                <li>HTML5 a CSS3</li>
                <li>Responzívny dizajn pre všetky zariadenia</li>
            </ul>

            <h2>Verzia</h2>
            <p><strong>Verzia 1.0.0</strong> | Aktualizované: 2026</p>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Slovenský rybársky zväz. Všetky práva vyhradené.</p>
        </div>
    </footer>
</body>
</html>
