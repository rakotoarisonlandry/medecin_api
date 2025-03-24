<?php
namespace MedecinApi\Domain\Repositories;

interface MedecinRepositoryInterface {
    public function add($data);  // Changez $medecin en $data
    public function update($id, $data);  // Ajoutez $id comme premier paramètre
    public function delete($id);
    public function getById($id);
    public function getAll();
    public function getTotalPrestation();
    public function getMinMaxPrestation();
}