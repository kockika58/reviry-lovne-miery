-- MySQL Database Schema for Lovné miery reviérov
-- Slovak Fishing Waters Database

CREATE TABLE IF NOT EXISTS `typy_vod` (
  `id` INT PRIMARY KEY,
  `nazev` VARCHAR(100) NOT NULL,
  `farba` VARCHAR(20) NOT NULL,
  `popis` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `typy_vod` VALUES
(1, 'Kaprové vody - Tečúce vody', 'modrá', 'Vodné toky (tečúce vody, vrátane kanálov a prietoč. ramien). Lov rýb povolený celoročne.'),
(2, 'Kaprové vody - Nádrže', 'červená', 'Vodné nádrže a slepé, mŕtve a odstavené ramená. Zákaz lovu od 15.03 do 31.05.'),
(3, 'Kaprové vody - Ostatné', 'zelená', 'Ostatné vodné plochy (jazerá, štrkoviská, prepadliny...). Lov povolený celoročne.'),
(4, 'Pstruhové vody', 'žltá', 'Vodné toky, nádrže, jazerá. Zákaz lovu od 01.10 do 15.04.'),
(5, 'Lipňové vody', 'oranžová', 'Vodné toky (tečúce vody). Zákaz lovu od 01.01 do 31.05.');

CREATE TABLE IF NOT EXISTS `reviery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kod_revieru` VARCHAR(20) NOT NULL UNIQUE,
  `nazev` VARCHAR(255) NOT NULL,
  `typ_vody_id` INT NOT NULL,
  `podtyp` VARCHAR(100),
  `plocha_ha` DECIMAL(10,2),
  `lokalita` VARCHAR(255),
  `popis` TEXT,
  `poznamky` TEXT,
  `zakaz_od` DATE,
  `zakaz_do` DATE,
  `povinnosti` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`typ_vody_id`) REFERENCES `typy_vod`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `druhy_ryb` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nazev` VARCHAR(100) NOT NULL,
  `vedecky_nazev` VARCHAR(150),
  `popis` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `druhy_ryb` (nazev, vedecky_nazev) VALUES
('kapor rybničný', 'Cyprinus carpio'),
('lieň sliznatý', 'Tinca tinca'),
('sumec veľký', 'Silurus glanis'),
('šťuka severná', 'Esox lucius'),
('zubáč veľkoústy', 'Sander lucioperca'),
('boleň dravý', 'Aspius aspius'),
('ostriež zelenkavý', 'Perca fluviatilis');

CREATE TABLE IF NOT EXISTS `lovne_miere` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `reviera_id` INT NOT NULL,
  `druh_ryby_id` INT NOT NULL,
  `rok` INT NOT NULL,
  `min_dlzka_cm` INT,
  `max_dlzka_cm` INT,
  `max_pocet` INT,
  `poznanka` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`reviera_id`) REFERENCES `reviery`(`id`),
  FOREIGN KEY (`druh_ryby_id`) REFERENCES `druhy_ryb`(`id`),
  UNIQUE KEY `unique_miera` (`reviera_id`, `druh_ryby_id`, `rok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bratislava 5 - Kaprové vody (Modrá)
INSERT INTO `reviery` (kod_revieru, nazev, typ_vody_id, podtyp, plocha_ha, lokalita, popis, povinnosti)
VALUES
('1-0020-1-1', 'Chorvátsky kanál', 1, 'kanál', 9.8, 'Bratislava-Petržalka', 'Kanál v mestskej časti Bratislava-Petržalka.', 'Povinná rybárska podložka. Zákaz lovu z premostenia kanála.');

-- Bratislava 5 - Kaprové vody (Červená)
INSERT INTO `reviery` (kod_revieru, nazev, typ_vody_id, podtyp, plocha_ha, lokalita, popis, zakaz_od, zakaz_do, povinnosti)
VALUES
('1-0080-1-1', 'Dunaj č. 3 – MR Malý Zemník', 2, 'mŕtve rameno', 0.5, 'Bratislava-Petržalka', 'Vodná plocha mŕtveho ramena na pravej strane zdrže.', '2026-03-15', '2026-05-31', 'Zákaz lovu od 15.03. do 31.05.'),
('1-0110-1-1', 'Dunaj č. 3 – MR Veľký Zemník', 2, 'mŕtve rameno', 48.35, 'Bratislava-Petržalka', 'Vodná plocha mŕtveho ramena na pravej strane zdrže.', '2026-03-15', '2026-05-31', 'Zákaz lovu od 15.03. do 31.05. Časť revíru vyhlásená CHRO.'),
('1-0100-1-1', 'Dunaj č. 3 – OR Polder', 2, 'sústava kanála a ramien', NULL, 'Bratislava-Petržalka', 'Sústava kanála a ramien na pravej strane zdrže pri obci Rusovce.', '2026-03-15', '2026-05-31', 'Povinná rybárska podložka. Zákaz lovu od 15.03. do 31.05.'),
('1-0090-1-1', 'Dunaj č. 4 – SR Ovsište', 2, 'slepé rameno', 0.22, 'Bratislava-Petržalka', 'Vodná plocha slepého ramena na pravej strane Dunaja.', '2026-03-15', '2026-05-31', 'Povinná rybárska podložka. Zákaz lovu od 15.03. do 31.05.'),
('1-0120-1-1', 'Dunaj č. 4 – SR Zuzana', 2, 'slepé rameno', 13.94, 'Bratislava-Petržalka', 'Vodná plocha slepého ramena a sústava ramien na pravej strane Dunaja.', '2026-03-15', '2026-05-31', 'Povinná rybárska podložka. Zákaz lovu od 15.03. do 31.05.'),
('1-0130-1-1', 'Dunaj č. 3, Rusovecko – Jarovecká sústava ramien', 2, 'slepé ramená', 56.1, 'Rusovce', 'Sústava slepých ramien na pravej strane zdrže pri obci Rusovce.', '2026-03-15', '2026-05-31', 'Povinná rybárska podložka. Zákaz lovu od 15.03. do 31.05. Dodatočný zákaz 01.02-30.06 v zátoke.');

-- Bratislava 5 - Kaprové vody (Zelená)
INSERT INTO `reviery` (kod_revieru, nazev, typ_vody_id, podtyp, plocha_ha, lokalita, popis)
VALUES
('1-0990-1-1', 'Štrkovisko Malé Čunovo', 3, 'štrkovisko', 3, 'Čunovo', 'Vodná plocha štrkoviska v obci Čunovo.'),
('1-1100-1-1', 'Štrkovisko U horára | Malý Draždiak', 3, 'štrkovisko', 3.5, 'Bratislava-Petržalka', 'Vodná plocha štrkoviska vrátane vodnej plochy pri ceste Kutlíková.'),
('1-1130-1-1', 'Štrkovisko Veľké Čunovo', 3, 'štrkovisko', 15, 'Čunovo', 'Vodná plocha štrkoviska v obci Čunovo. Nachádzajú sa v PR Ostrovné lúčky.'),
('1-1190-1-1', 'Štrkovisko Zrkadlový Háj | Veľký Draždiak', 3, 'štrkovisko', 20.5, 'Bratislava-Petržalka', 'Vodná plocha štrkoviska v mestskej časti Bratislava-Petržalka.'),
('1-1060-1-1', 'Štrkovisko Rusovce', 3, 'štrkovisko', 5, 'Rusovce', 'Vodná plocha štrkoviska v obci Rusovce.');

-- Lovné miery pre Chorvátsky kanál (modrá - celoročný lov)
INSERT INTO `lovne_miere` (reviera_id, druh_ryby_id, rok, min_dlzka_cm, max_dlzka_cm) VALUES
(1, 1, 2026, 45, 70),
(1, 2, 2026, 35, NULL),
(1, 3, 2026, 80, NULL),
(1, 4, 2026, 65, NULL),
(1, 5, 2026, 60, NULL);

-- Lovné miery pre Dunaj č. 3 – MR Malý Zemník (červená)
INSERT INTO `lovne_miere` (reviera_id, druh_ryby_id, rok, min_dlzka_cm) VALUES
(2, 1, 2026, 45),
(2, 2, 2026, 35),
(2, 3, 2026, 80),
(2, 4, 2026, 65),
(2, 5, 2026, 60);

-- Lovné miery pre Dunaj č. 3 – OR Polder (červená)
INSERT INTO `lovne_miere` (reviera_id, druh_ryby_id, rok, min_dlzka_cm, max_dlzka_cm) VALUES
(4, 1, 2026, 45, 70),
(4, 2, 2026, 35, NULL),
(4, 3, 2026, 80, NULL),
(4, 4, 2026, 65, NULL),
(4, 5, 2026, 60, NULL);

-- Lovné miery pre Dunaj č. 4 – SR Ovsište (červená)
INSERT INTO `lovne_miere` (reviera_id, druh_ryby_id, rok, min_dlzka_cm, max_dlzka_cm) VALUES
(5, 6, 2026, 50, NULL),
(5, 1, 2026, 45, 70),
(5, 2, 2026, 35, NULL),
(5, 7, 2026, NULL, 10),
(5, 3, 2026, 90, NULL),
(5, 4, 2026, 65, NULL),
(5, 5, 2026, 60, NULL);

-- Lovné miery pre štrkoviská (zelená - celoročný lov)
INSERT INTO `lovne_miere` (reviera_id, druh_ryby_id, rok, min_dlzka_cm) VALUES
(6, 1, 2026, 45),
(6, 2, 2026, 35),
(6, 3, 2026, 80),
(6, 4, 2026, 65),
(6, 5, 2026, 60),
(9, 1, 2026, 45),
(9, 2, 2026, 35),
(9, 3, 2026, 90),
(9, 4, 2026, 65),
(9, 5, 2026, 60);
