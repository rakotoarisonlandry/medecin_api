<?php
namespace MedecinApi\Infrastructure\Persistence;

use MedecinApi\Domain\Repositories\MedecinRepositoryInterface;
use PDO;

class MysqlMedecinRepository implements MedecinRepositoryInterface {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT *, (nombre_jours * taux_journalier) as prestation FROM medecin");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM medecin WHERE numed = ?");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function add($data) {
        $stmt = $this->db->prepare(
            "INSERT INTO medecin (nom, nombre_jours, taux_journalier) VALUES (?, ?, ?)"
        );
        return $stmt->execute(array(
            $data['nom'],
            $data['nombre_jours'],
            $data['taux_journalier']
        ));
    }
    
    public function update($id, $data) {
        $stmt = $this->db->prepare(
            "UPDATE medecin SET nom = ?, nombre_jours = ?, taux_journalier = ? WHERE numed = ?"
        );
        return $stmt->execute(array(
            $data['nom'],
            $data['nombre_jours'],
            $data['taux_journalier'],
            $id
        ));
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM medecin WHERE numed = ?");
        return $stmt->execute(array($id));
    }
    
    public function getTotalPrestation() {
        $stmt = $this->db->query(
            "SELECT SUM(nombre_jours * taux_journalier) as total FROM medecin"
        );
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
    public function getMinMaxPrestation() {
        $stmt = $this->db->query(
            "SELECT 
                MIN(nombre_jours * taux_journalier) as minimal,
                MAX(nombre_jours * taux_journalier) as maximal
             FROM medecin"
        );
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}