<?php
/**
 * Reviéry Model - Fishing Waters Data Handler
 */

class Reviery {
    private $conn;
    private $table = 'reviery';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Získaj všetky reviéry
    public function getAll() {
        $query = 'SELECT r.*, t.nazev as typ_nazev, t.farba 
                  FROM ' . $this->table . ' r
                  JOIN typy_vod t ON r.typ_vody_id = t.id
                  ORDER BY t.id, r.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získaj reviér podľa ID
    public function getById($id) {
        $query = 'SELECT r.*, t.nazev as typ_nazev, t.farba, t.popis as typ_popis
                  FROM ' . $this->table . ' r
                  JOIN typy_vod t ON r.typ_vody_id = t.id
                  WHERE r.id = ?';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Získaj reviéry podľa typu
    public function getByType($type_id) {
        $query = 'SELECT r.*, t.nazev as typ_nazev, t.farba 
                  FROM ' . $this->table . ' r
                  JOIN typy_vod t ON r.typ_vody_id = t.id
                  WHERE r.typ_vody_id = ?
                  ORDER BY r.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$type_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vyhľadaj reviéry
    public function search($keyword) {
        $keyword = '%' . $keyword . '%';
        $query = 'SELECT r.*, t.nazev as typ_nazev, t.farba 
                  FROM ' . $this->table . ' r
                  JOIN typy_vod t ON r.typ_vody_id = t.id
                  WHERE r.nazev LIKE ? OR r.kod_revieru LIKE ? OR r.lokalita LIKE ?
                  ORDER BY t.id, r.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$keyword, $keyword, $keyword]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získaj lovné miery pre reviér
    public function getLoveneMiery($reviera_id) {
        $query = 'SELECT lm.*, dr.nazev as druh_nazev, dr.vedecky_nazev
                  FROM lovne_miere lm
                  JOIN druhy_ryb dr ON lm.druh_ryby_id = dr.id
                  WHERE lm.reviera_id = ? AND lm.rok = YEAR(NOW())
                  ORDER BY dr.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$reviera_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Skontroluj či je lov povolený dnes
    public function isLovPovoleny($reviera_id) {
        $today = date('m-d');
        $query = 'SELECT r.zakaz_od, r.zakaz_do FROM ' . $this->table . ' r WHERE r.id = ?';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$reviera_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result || !$result['zakaz_od'] || !$result['zakaz_do']) {
            return true; // Nie je zákaz
        }

        $today_num = intval(date('n') . date('d'));
        $zakaz_od = intval(substr($result['zakaz_od'], 5, 2) . substr($result['zakaz_od'], 8, 2));
        $zakaz_do = intval(substr($result['zakaz_do'], 5, 2) . substr($result['zakaz_do'], 8, 2));

        if ($zakaz_od <= $zakaz_do) {
            return !($today_num >= $zakaz_od && $today_num <= $zakaz_do);
        } else {
            return !($today_num >= $zakaz_od || $today_num <= $zakaz_do);
        }
    }

    // Pridaj nový reviér
    public function add($data) {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (kod_revieru, nazev, typ_vody_id, podtyp, plocha_ha, lokalita, popis, poznamky, zakaz_od, zakaz_do, povinnosti)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['kod_revieru'],
            $data['nazev'],
            $data['typ_vody_id'],
            $data['podtyp'] ?? null,
            $data['plocha_ha'] ?? null,
            $data['lokalita'] ?? null,
            $data['popis'] ?? null,
            $data['poznamky'] ?? null,
            $data['zakaz_od'] ?? null,
            $data['zakaz_do'] ?? null,
            $data['povinnosti'] ?? null
        ]);
    }

    // Uprav reviér
    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET 
                  kod_revieru = ?, nazev = ?, typ_vody_id = ?, podtyp = ?, plocha_ha = ?, 
                  lokalita = ?, popis = ?, poznamky = ?, zakaz_od = ?, zakaz_do = ?, povinnosti = ?
                  WHERE id = ?';
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['kod_revieru'],
            $data['nazev'],
            $data['typ_vody_id'],
            $data['podtyp'] ?? null,
            $data['plocha_ha'] ?? null,
            $data['lokalita'] ?? null,
            $data['popis'] ?? null,
            $data['poznamky'] ?? null,
            $data['zakaz_od'] ?? null,
            $data['zakaz_do'] ?? null,
            $data['povinnosti'] ?? null,
            $id
        ]);
    }

    // Vymaž reviér
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
