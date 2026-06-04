<?php
/**
 * Lovne Miery Model - Fishing Limits Data Handler
 */

class LovneMiery {
    private $conn;
    private $table = 'lovne_miere';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Získaj lovné miery pre reviér a rok
    public function getByRevieraAndYear($reviera_id, $year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $query = 'SELECT lm.*, dr.nazev as druh_nazev, dr.vedecky_nazev
                  FROM ' . $this->table . ' lm
                  JOIN druhy_ryb dr ON lm.druh_ryby_id = dr.id
                  WHERE lm.reviera_id = ? AND lm.rok = ?
                  ORDER BY dr.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$reviera_id, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získaj lovné miery pre druh ryby a rok
    public function getByDruhAndYear($druh_id, $year = null) {
        if (!$year) {
            $year = date('Y');
        }

        $query = 'SELECT lm.*, r.nazev as reviera_nazev, r.kod_revieru, r.farba as typ_farba, t.farba
                  FROM ' . $this->table . ' lm
                  JOIN reviery r ON lm.reviera_id = r.id
                  JOIN typy_vod t ON r.typ_vody_id = t.id
                  WHERE lm.druh_ryby_id = ? AND lm.rok = ?
                  ORDER BY r.nazev';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$druh_id, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pridaj lovnú mieru
    public function add($data) {
        $query = 'INSERT INTO ' . $this->table . ' 
                  (reviera_id, druh_ryby_id, rok, min_dlzka_cm, max_dlzka_cm, max_pocet, poznanka)
                  VALUES (?, ?, ?, ?, ?, ?, ?)';
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['reviera_id'],
            $data['druh_ryby_id'],
            $data['rok'],
            $data['min_dlzka_cm'] ?? null,
            $data['max_dlzka_cm'] ?? null,
            $data['max_pocet'] ?? null,
            $data['poznanka'] ?? null
        ]);
    }

    // Uprav lovnú mieru
    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET 
                  min_dlzka_cm = ?, max_dlzka_cm = ?, max_pocet = ?, poznanka = ?
                  WHERE id = ?';
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['min_dlzka_cm'] ?? null,
            $data['max_dlzka_cm'] ?? null,
            $data['max_pocet'] ?? null,
            $data['poznanka'] ?? null,
            $id
        ]);
    }

    // Vymaž lovnú mieru
    public function delete($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = ?';
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
