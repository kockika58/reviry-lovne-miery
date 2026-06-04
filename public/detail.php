<?php
/**
 * Reviér Detail Page - Lovné miery
 */

require_once '../config/Database.php';
require_once '../models/Reviery.php';
require_once '../models/LovneMiery.php';

$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die('Chyba pripojenia k databáze!');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: reviery.php');
    exit;
}

$id = intval($_GET['id']);
$revieryModel = new Reviery($conn);
$loveneMieryModel = new LovneMiery($conn);

$reviera = $revieryModel->getById($id);

if (!$reviera) {
    header('Location: reviery.php');
    exit;
}

$loveneMiery = $revieryModel->getLoveneMiery($id);
$lovPovoleny = $revieryModel->isLovPovoleny($id);

$farbyMapa = [
    'modrá' => '#2196F3',
    'červená' => '#f44336',
    'zelená' => '#4CAF50',
    'žltá' => '#FFC107',
    'oranžová' => '#FF9800'
];
$farba = $farbyMapa[$reviera['farba']] ?? '#2196F3';
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($reviera['nazev']); ?> - Lovné miery</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detail-header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-left: 6px solid <?php echo $farba; ?>;
        }
        
        .detail-header-top {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .color-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: <?php echo $farba; ?>;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        
        .header-info h1 {
            margin: 0 0 10px 0;
            color: #333;
        }
        
        .header-info .kod {
            font-size: 0.95em;
            color: #666;
            font-weight: 500;
        }
        
        .status-badge {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 15px;
        }
        
        .status-povoleny {
            background-color: #c8e6c9;
            color: #2e7d32;
        }
        
        .status-zakaz {
            background-color: #ffcdd2;
            color: #c62828;
        }
        
        .detail-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        
        .info-block {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 6px;
        }
        
        .info-block strong {
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        
        .info-block span {
            color: #666;
        }
        
        .lovne-miery-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .lovne-miery-table th {
            background-color: <?php echo $farba; ?>;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .lovne-miery-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .lovne-miery-table tr:last-child td {
            border-bottom: none;
        }
        
        .lovne-miery-table tr:hover {
            background-color: #f9f9f9;
        }
        
        .lovne-miery-table .druh-nazev {
            font-weight: 600;
            color: #333;
        }
        
        .lovne-miery-table .vedecky-nazev {
            font-size: 0.9em;
            color: #999;
            font-style: italic;
        }
        
        .limit-value {
            background-color: #f0f0f0;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .no-limit {
            color: #999;
        }
        
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .back-link:hover {
            background-color: #e0e0e0;
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
        <a href="reviery.php" class="back-link">← Späť na zoznam reviérov</a>
        
        <div class="detail-header">
            <div class="detail-header-top">
                <div class="color-circle"></div>
                <div class="header-info">
                    <h1><?php echo htmlspecialchars($reviera['nazev']); ?></h1>
                    <div class="kod">Kód reviéru: <strong><?php echo htmlspecialchars($reviera['kod_revieru']); ?></strong></div>
                </div>
            </div>
            
            <?php if ($lovPovoleny): ?>
                <span class="status-badge status-povoleny">✓ Lov dnes povolený</span>
            <?php else: ?>
                <span class="status-badge status-zakaz">⚠️ Dnes zákaz lovu</span>
            <?php endif; ?>
            
            <div class="detail-info">
                <div class="info-block">
                    <strong>Typ vody:</strong>
                    <span><?php echo htmlspecialchars($reviera['typ_nazev']); ?></span>
                </div>
                
                <?php if ($reviera['podtyp']): ?>
                    <div class="info-block">
                        <strong>Podtyp:</strong>
                        <span><?php echo htmlspecialchars($reviera['podtyp']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($reviera['lokalita']): ?>
                    <div class="info-block">
                        <strong>Lokalita:</strong>
                        <span><?php echo htmlspecialchars($reviera['lokalita']); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($reviera['plocha_ha']): ?>
                    <div class="info-block">
                        <strong>Plocha:</strong>
                        <span><?php echo htmlspecialchars($reviera['plocha_ha']); ?> hektárov</span>
                    </div>
                <?php endif; ?>
                
                <?php if ($reviera['zakaz_od'] && $reviera['zakaz_do']): ?>
                    <div class="info-block">
                        <strong>Zákaz lovu:</strong>
                        <span><?php echo date('d.m.Y', strtotime($reviera['zakaz_od'])); ?> až <?php echo date('d.m.Y', strtotime($reviera['zakaz_do'])); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($reviera['popis']): ?>
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee;">
                    <strong>Popis:</strong><br>
                    <p><?php echo htmlspecialchars($reviera['popis']); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($reviera['povinnosti']): ?>
                <div style="margin-top: 15px; padding: 15px; background-color: #fff3cd; border-radius: 4px; border-left: 4px solid #ffc107;">
                    <strong style="color: #856404;">⚠️ Povinnosti a zákazy:</strong><br>
                    <p style="color: #856404; margin: 5px 0 0 0;"><?php echo htmlspecialchars($reviera['povinnosti']); ?></p>
                </div>
            <?php endif; ?>
        </div>
        
        <section>
            <h2 style="margin-bottom: 20px; color: #333;">Lovné miery rýb - Rok 2026</h2>
            
            <?php if (count($loveneMiery) > 0): ?>
                <table class="lovne-miery-table">
                    <thead>
                        <tr>
                            <th>Druh ryby</th>
                            <th>Min. dĺžka</th>
                            <th>Max. dĺžka</th>
                            <th>Max. počet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($loveneMiery as $miera): ?>
                            <tr>
                                <td>
                                    <div class="druh-nazev"><?php echo htmlspecialchars($miera['druh_nazev']); ?></div>
                                    <div class="vedecky-nazev"><?php echo htmlspecialchars($miera['vedecky_nazev']); ?></div>
                                </td>
                                <td>
                                    <?php if ($miera['min_dlzka_cm']): ?>
                                        <span class="limit-value"><?php echo intval($miera['min_dlzka_cm']); ?> cm</span>
                                    <?php else: ?>
                                        <span class="no-limit">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($miera['max_dlzka_cm']): ?>
                                        <span class="limit-value"><?php echo intval($miera['max_dlzka_cm']); ?> cm</span>
                                    <?php else: ?>
                                        <span class="no-limit">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($miera['max_pocet']): ?>
                                        <span class="limit-value"><?php echo intval($miera['max_pocet']); ?> ks</span>
                                    <?php else: ?>
                                        <span class="no-limit">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="background: white; padding: 30px; text-align: center; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <p>Pre tento reviér nie sú definované lovné miery</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Slovenský rybársky zväz. Všetky práva vyhradené.</p>
        </div>
    </footer>
</body>
</html>
