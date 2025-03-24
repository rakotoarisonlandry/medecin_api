<?php
namespace MedecinApi\Application\UseCases;

use MedecinApi\Domain\Repositories\MedecinRepositoryInterface;
use MedecinApi\Config\Database; 
class MedecinUseCase {
    private $repository;

    public function __construct(MedecinRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getAllMedecins() {
        return $this->repository->getAll();
    }

    public function getMedecinDetails($id) {
        return $this->repository->getById($id);
    }

    public function createMedecin($numed, $nom, $nombre_jours, $taux_journalier) {
        $data = [
            'numed' => $numed,
            'nom' => $nom,
            'nombre_jours' => $nombre_jours,
            'taux_journalier' => $taux_journalier
        ];
        return $this->repository->add($data);
    }

    public function updateMedecin($id, $numed, $nom, $nombre_jours, $taux_journalier) {
        $data = [
            'numed' => $numed,
            'nom' => $nom,
            'nombre_jours' => $nombre_jours,
            'taux_journalier' => $taux_journalier
        ];
        return $this->repository->update($id, $data);
    }

    public function deleteMedecin($id) {
        return $this->repository->delete($id);
    }

    public function getTotalPrestation() {
        return $this->repository->getTotalPrestation();
    }

    public function getMinMaxPrestation() {
        return $this->repository->getMinMaxPrestation();
    }
}