<?php
	if(!isset($_REQUEST['action'])){
		$_REQUEST['action'] = 'demandeConnexion';
	}
	$idVisiteur = $_SESSION['idVisiteur'];
	$nom = $_SESSION['nom'];
	$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur,$leMois);
	$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur,$leMois);
	$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur,$leMois);
	$numAnnee =substr( $leMois,0,4);
	$numMois =substr( $leMois,4,2);
	include("vues/v_pdf.php");
?>
