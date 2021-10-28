<?php
    $idVisiteur = $_SESSION['idVisiteur'];
    if(isset($_POST['valide'])){
        $lesFraisHorsForfaits = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);
        include 'vues/v_pdfv2.php';
    }
?>