<?php
/**
 * Reviéry Listing Page
 */

require_once '../config/Database.php';
require_once '../models/Reviery.php';
require_once '../models/LovneMiery.php';

$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die('Chyba pripojenia k databáze!');
}

$revieryModel = new Reviery($conn);
$reviery = [];
$search = '';
$typ = null;
$title = 'Všetky reviéry';

// Získaj údaje
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $reviery = $revieryModel->search($search);
    $title = 'Výsledky hľadania: ' . htmlspecialchars($search);
} elseif (isset($_GET['typ']) && !empty($_GET['typ'])) {
    $typ = intval($_GET['typ']);
    $reviery = $revieryModel->getByType($typ);
    $typyNazvy = ['', 'Kaprové vody - Tečúce', 'Kaprové vody - Nádrže', 'Kaprové vody - Ostatné', 'Pstruhové vody', 'Lipňové vody'];
    $title = $typyNazvy[$typ] ?? 'Reviéry';
} else {
    $reviery = $revieryModel->getAll();
}

$farbyMapa = [
    'modrá' => '#2196F3',
    'červená' => '#f44336',
    'zelená' => '#4CAF50',
    'žltá' => '#FFC107',
    'oranžová' => '#FF9800'
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Lovné miery reviérov</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .reviery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        
        .reviera-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            border-left: 5px solid #2196F3;
            cursor: pointer;
        }
        
        .reviera-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }
        
        .reviera-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .reviera-color {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .reviera-title {
            flex-grow: 1;
        }
        
        .reviera-title h3 {
            margin: 0;
            color: #333;
            font-size: 1.1em;
        }
        
        .reviera-kod {
            font-size: 0.85em;
            color: #666;
            font-weight: 500;
        }
        
        .reviera-info {
            font-size: 0.95em;
            color: #666;
            margin: 10px 0;
            line-height: 1.6;
        }
        
        .reviera-info strong {
            color: #333;
        }
        
        .reviera-typ {
            display: inline-block;
            background-color: #f0f0f0;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            margin: 5px 0;
        }
        
        .zakaz-badge {
            display: inline-block;
            background-color: #ffebee;
            color: #c62828;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .view-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 8px 16px;
            background-color: #2196F3;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            font-size: 0.9em;
        }
        
        .view-btn:hover {
            background-color: #1976D2;
        }
        
        .no-results {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            color: #666;
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
                <li><a href="reviery.php" class="active">Všetky reviéry</a></li>
                <li><a href="o-nas.php">O projekte</a></li>
            </ul>
        </div>
    </nav>

    <main class="container">
        <section class="hero">
            <h2><?php echo htmlspecialchars($title); ?></h2>
            
            <div class="search-box">
                <form method="GET" action="reviery.php">
                    <input type="text" name="search" placeholder="Hľadaj reviér alebo kód..." value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit">🔍 Hľadať</button>
                </form>
            </div>
        </section>

        <?php if (count($reviery) > 0): ?>
            <div class="reviery-container">
                <?php foreach ($reviery as $reviera): ?>
                    <?php 
                        $farba = $farbyMapa[$reviera['farba']] ?? '#2196F3';
                        $loveneMiery = $revieryModel->getLoveneMiery($reviera['id']);
                        $lovPovoleny = $revieryModel->isLovPovoleny($reviera['id']);
                    ?>
                    <div class="reviera-card" style="border-left-color: <?php echo $farba; ?>;">
                        <div class="reviera-header">
                            <div class="reviera-color" style="background-color: <?php echo $farba; ?>;"></div>
                            <div class="reviera-title">
                                <h3><?php echo htmlspecialchars($reviera['nazev']); ?></h3>
                                <div class="reviera-kod">Kód: <?php echo htmlspecialchars($reviera['kod_revieru']); ?></div>
                            </div>
                        </div>
                        
                        <div class="reviera-info">
                            <strong>Typ:</strong> <?php echo htmlspecialchars($reviera['typ_nazev']); ?><br>
                            <?php if ($reviera['podtyp']): ?>
                                <strong>Podtyp:</strong> <?php echo htmlspecialchars($reviera['podtyp']); ?><br>
                            <?php endif; ?>
                            <?php if ($reviera['lokalita']): ?>
                                <strong>Lokalita:</strong> <?php echo htmlspecialchars($reviera['lokalita']); ?><br>
                            <?php endif; ?>
                            <?php if ($reviera['plocha_ha']): ?>
                                <strong>Plocha:</strong> <?php echo htmlspecialchars($reviera['plocha_ha']); ?> ha<br>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($reviera['zakaz_od'] && $reviera['zakaz_do']): ?>
                            <div class="zakaz-badge">
                                ⚠️ Zákaz lovu: <?php echo date('d.m', strtotime($reviera['zakaz_od'])); ?> - <?php echo date('d.m', strtotime($reviera['zakaz_do'])); ?>
                                <?php if (!$lovPovoleny): ?>
                                    <br><strong>Dnes zákaz!</strong>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div style="color: #2e7d32; margin-top: 10px; font-weight: 600;">✓ Lov povolený celoročne</div>
                        <?php endif; ?>
                        
                        <?php if ($reviera['povinnosti']): ?>
                            <div class="reviera-info" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                                <strong>Povinnosti:</strong><br>
                                <small><?php echo htmlspecialchars($reviera['povinnosti']); ?></small>
                            </div>
                        <?php endif; ?>
                        
                        <a href="detail.php?id=<?php echo $reviera['id']; ?>" class="view-btn">Zobraziť lovné miery →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <h3>Žiadne reviéry nenájdené</h3>
                <p>Skúste zmeniť kritériá hľadania</p>
                <a href="reviery.php" class="btn" style="display: inline-block; margin-top: 20px;">Zobraziť všetky reviéry</a>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Slovenský rybársky zväz. Všetky práva vyhradené.</p>
        </div>
    </footer>
</body>
</html>
