<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch ($action) {
  case 'selectionnerMois':{
    $lesMois=$pdo->getLesMois();
		// Afin de sélectionner par défaut le dernier mois dans la zone de liste
		// on demande toutes les clés, et on prend la première,
		// les mois étant triés décroissants
		$lesCles = array_keys($lesMois);
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMoisFichesFrais.php");
    break;
  }
  case 'voirEtatFrais':{
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMois();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisFichesFrais.php");
    $lesFichesFrais = $pdo->getLesFichesFrais($leMois);
		include("vues/v_listeFichesFrais.php");
    break;
  }
  case 'detailFicheFrais':{;
    $lesEtat=$pdo->getEtatFiche();

    $idVisiteur = $_REQUEST['idVisiteur'];
    $mois = $_REQUEST['mois'];
    $laFicheFrais = $pdo->getLaFicheFrais($idVisiteur,$mois);
		include("vues/v_detailFicheFrais.php");

    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$mois);
		$lesFraisForfait= $pdo->getLesFraisForfait($idVisiteur,$mois);
		$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$mois);
		$numAnnee =substr( $mois,0,4);
		$numMois =substr( $mois,4,2);
		$libEtat = $lesInfosFicheFrais['libEtat'];
		$montantValide = $lesInfosFicheFrais['montantValide'];
		$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
		$dateModif =  $lesInfosFicheFrais['dateModif'];
		$dateModif =  dateAnglaisVersFrancais($dateModif);
		include("vues/v_etatFrais.php");
    break;
  }
  case 'modifierEtat':{;
    $etat = $_REQUEST['lstEtat'];
    $idVisiteur = $_REQUEST['idVisiteur'];
    $mois = $_REQUEST['mois'];
    $dateModif = date("y-m-d");
    $pdo->changerEtat($etat,$idVisiteur,$mois,$dateModif);

    $lesMois=$pdo->getLesMois();
		$lesCles = array_keys($lesMois);
		$moisASelectionner = $lesCles[0];
    include("vues/v_listeMoisFichesFrais.php");
  }
}
?>
