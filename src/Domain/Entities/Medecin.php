<?php
namespace MedecinApi\Domain\Entities;

class Medecin {
    private $id;
    private $numed;
    private $nom;
    private $nombreJours;
    private $tauxJournalier;

    public function __construct($id = null, $numed, $nom, $nombreJours, $tauxJournalier) {
        $this->id = $id;
        $this->numed = $numed;
        $this->nom = $nom;
        $this->nombreJours = $nombreJours;
        $this->tauxJournalier = $tauxJournalier;
    }

    public function getId() { 
        return $this->id; 
    }

    public function getNumed() { 
        return $this->numed; 
    }

    public function getNom() { 
        return $this->nom; 
    }

    public function getNombreJours() { 
        return $this->nombreJours; 
    }

    public function getTauxJournalier() { 
        return $this->tauxJournalier; 
    }

    public function setId($id) { 
        $this->id = $id; 
    }

    public function setNumed($numed) { 
        $this->numed = $numed; 
    }

    public function setNom($nom) { 
        $this->nom = $nom; 
    }

    public function setNombreJours($nombreJours) { 
        $this->nombreJours = $nombreJours; 
    }

    public function setTauxJournalier($tauxJournalier) { 
        $this->tauxJournalier = $tauxJournalier; 
    }

    public function calculatePrestation() {
        return $this->nombreJours * $this->tauxJournalier;
    }
}