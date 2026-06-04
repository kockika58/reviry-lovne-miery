<?php
/**
 * Lovné miery reviérov - Main Index Page
 */
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lovné miery reviérov - Informačný portál SRZ</title>
    <link rel="stylesheet" href="css/style.css">
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
                <li><a href="index.php" class="active">Domov</a></li>
                <li><a href="reviery.php">Všetky reviéry</a></li>
                <li><a href="o-nas.php">O projekte</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <section class="hero">
            <h2>Vítajte v Informačnom portáli</h2>
            <p>Nájdite všetky informácie o povolených lovných mierach pre jednotlivé druhy rýb v každom reviéri.</p>
            
            <div class="search-box">
                <form method="GET" action="reviery.php">
                    <input type="text" name="search" placeholder="Hľadaj reviér alebo druh ryby..." required>
                    <button type="submit">🔍 Hľadať</button>
                </form>
            </div>
        </section>

        <section class="typy-vod">
            <h2>Typy vôd podľa farieb</h2>
            <div class="grid">
                <div class="card blue">
                    <div class="color-badge" style="background-color: #2196F3;"></div>
                    <h3>Kaprové vody - Tečúce</h3>
                    <p><strong>Farba:</strong> Modrá</p>
                    <p><strong>Lov:</strong> Celoročný</p>
                    <p>Vodné toky, kanály a prietoč. ramená</p>
                    <a href="reviery.php?typ=1" class="btn btn-blue">Zobraziť reviéry →</a>
                </div>

                <div class="card red">
                    <div class="color-badge" style="background-color: #f44336;"></div>
                    <h3>Kaprové vody - Nádrže</h3>
                    <p><strong>Farba:</strong> Červená</p>
                    <p><strong>Zákaz:</strong> 15.3 - 31.5</p>
                    <p>Vodné nádrže, slepé a mŕtve ramená</p>
                    <a href="reviery.php?typ=2" class="btn btn-red">Zobraziť reviéry →</a>
                </div>

                <div class="card green">
                    <div class="color-badge" style="background-color: #4CAF50;"></div>
                    <h3>Kaprové vody - Ostatné</h3>
                    <p><strong>Farba:</strong> Zelená</p>
                    <p><strong>Lov:</strong> Celoročný</p>
                    <p>Jazerá, štrkoviská, prepadliny...</p>
                    <a href="reviery.php?typ=3" class="btn btn-green">Zobraziť reviéry →</a>
                </div>

                <div class="card yellow">
                    <div class="color-badge" style="background-color: #FFC107;"></div>
                    <h3>Pstruhové vody</h3>
                    <p><strong>Farba:</strong> Žltá</p>
                    <p><strong>Zákaz:</strong> 1.10 - 15.4</p>
                    <p>Vodné toky, nádrže, jazerá</p>
                    <a href="reviery.php?typ=4" class="btn btn-yellow">Zobraziť reviéry →</a>
                </div>

                <div class="card orange">
                    <div class="color-badge" style="background-color: #FF9800;"></div>
                    <h3>Lipňové vody</h3>
                    <p><strong>Farba:</strong> Oranžová</p>
                    <p><strong>Zákaz:</strong> 1.1 - 31.5</p>
                    <p>Vodné toky (tečúce vody)</p>
                    <a href="reviery.php?typ=5" class="btn btn-orange">Zobraziť reviéry →</a>
                </div>
            </div>
        </section>

        <section class="info">
            <h2>Ako používať portál</h2>
            <ol>
                <li><strong>Vyhľadaj reviér:</strong> Zadaj názov reviéru alebo jeho kód do vyhľadávacieho poľa</li>
                <li><strong>Prehliadaj lovné miery:</strong> Zobrazí sa tabuľka s minimálnymi a maximálnymi dĺžkami pre každý druh ryby</li>
                <li><strong>Rešpektuj sezónne zákazy:</strong> Niektoré reviéry majú zákaz lovu počas určitých období</li>
                <li><strong>Dodržuj pravidlá:</strong> Niektoré reviéry majú špecifické povinnosti a zákazy</li>
            </ol>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Slovenský rybársky zväz. Všetky práva vyhradené.</p>
        </div>
    </footer>
</body>
</html>