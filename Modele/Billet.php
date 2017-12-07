<?php

require_once 'Modele/Modele.php';

class Billet extends Modele {
    
//Méthode qui recupere les 5 dernier billets
    public function getBillets()
{
    $sql = 'SELECT id, titre, contenu, auteur, statut, DATE_FORMAT(date_publication, \'%d/%m/%Y à %Hh%imin%ss\') AS date_publication_fr FROM billets WHERE statut=\'publie\' ORDER BY date_publication DESC LIMIT 0,5';
    $billets = $this->executerRequete($sql);
    return $billets;
}

//Méthode qui recupere tous les billets
    public function getBlog()
{
    $sql = 'SELECT id, titre, contenu, auteur, statut, DATE_FORMAT(date_publication, \'%d/%m/%Y à %Hh%imin%ss\') AS date_publication_fr FROM billets WHERE statut=\'publie\' ORDER BY date_publication DESC';
    $billets = $this->executerRequete($sql);
    return $billets;
}

// Renvoie les informations sur un billet
    public function getBillet($idBillet) {
  $sql = 'SELECT id, titre, contenu, auteur, DATE_FORMAT(date_publication, \'%d/%m/%Y à %Hh%imin%ss\') AS date_publication_fr FROM billets WHERE id = ?';
  $billet = $this->executerRequete($sql, array($idBillet));
  if ($billet->rowCount() == 1) {
        return $billet->fetch();
    }  // Accès à la première ligne de résultat
    else {
        throw new Exception("Aucun billet ne correspond à l'identifiant '$idBillet'");
    }
}

// fonction qui realise l'insertion dans la base de données
    public function insertBillet($titre, $contenu, $auteur, $statut){
$sql = 'INSERT INTO billets(titre, contenu, auteur, statut, date_publication) VALUES(?, ?, ?, ?, NOW())';
$this->executerRequete($sql, array($titre, $contenu, $auteur, $statut));
}


// fonction qui realise la modification dans la base de données
    public function modifBillet($idBillet, $titre, $contenu, $auteur, $statut){
$sql = 'UPDATE billets SET titre =?, contenu=?, auteur=?, statut=?, date_publication=NOW() WHERE id=?';

$resultat = $this->executerRequete($sql, array($titre, $contenu, $auteur, $statut, $idBillet));
 print_r($resultat);
    }
    
    //fonction qui realise la suppression dans la base de données
    public function confirmer($idBillet) {
        $sql = 'DELETE FROM billets WHERE id= ?';
        $this->executerRequete($sql, array($idBillet));
    }

}