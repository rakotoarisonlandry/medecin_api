<?php
namespace MedecinApi\Infrastructure\Controllers;

use MedecinApi\Application\UseCases\MedecinUseCase;
use MedecinApi\Infrastructure\Persistence\MysqlMedecinRepository;
use MedecinApi\Config\Database;

class MedecinController {
    private $useCase;

    public function __construct() {
        $db = Database::getConnection();
        $repository = new MysqlMedecinRepository($db);
        $this->useCase = new MedecinUseCase($repository);
    }

    public function handleRequest($method, $params = null) {
        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'])) {
            http_response_code(405); // Method Not Allowed
            return ['error' => 'Méthode non autorisée'];
        }
        
        try {
            switch ($method) {
                case 'GET': return $this->handleGet($params);
                case 'POST': return $this->createMedecin($params);
                // ...
            }
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            return ['error' => 'Requête invalide'];
        }
    }

    private function createMedecin($params) {
        if (!$params) {
            return array('error' => 'Missing parameters');
        }

        $id = $this->useCase->createMedecin(
            $params['numed'],
            $params['nom'],
            $params['nombre_jours'],
            $params['taux_journalier']
        );

        return $id ? array('success' => true, 'id' => $id) : array('error' => 'Creation failed');
    }

    private function updateMedecin($params) {
        if (!$params || !isset($params['id'])) {
            return array('error' => 'Missing parameters');
        }

        $success = $this->useCase->updateMedecin(
            $params['id'],
            $params['numed'],
            $params['nom'],
            $params['nombre_jours'],
            $params['taux_journalier']
        );

        return array('success' => $success);
    }

    private function deleteMedecin($params) {
        if (!$params || !isset($params['id'])) {
            return array('error' => 'Missing ID');
        }

        $success = $this->useCase->deleteMedecin($params['id']);
        return array('success' => $success);
    }

    private function handleGet($params) {
        if (!$params) {
            return $this->useCase->getAllMedecins();
        }

        if (isset($params['id'])) {
            $medecin = $this->useCase->getMedecinDetails($params['id']);
            return $medecin ? array($medecin) : array('error' => 'Medecin not found');
        }

        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'total_prestation':
                    return array('total_prestation' => $this->useCase->getTotalPrestation());
                case 'min_max_prestation':
                    return $this->useCase->getMinMaxPrestation();
                default:
                    return array('error' => 'Invalid action');
            }
        }

        return array('error' => 'Invalid request');
    }
}