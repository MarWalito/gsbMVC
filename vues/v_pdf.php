<?php
  session_start();
  include "../include/fpdf/fpdf.php";
  include "../include/class.pdogsb.inc.php";
  $bdd = new PDO('mysql:host=172.16.203.203;dbname=gsbV2;charset=utf8', 'sio', 'slam'); 
  if($bdd){
    $user = $_SESSION['idVisiteur'];

    $PDF = new fpdf();
    $PDF->AddPage();
    $PDF->SetFont("Arial","B",16);
    $PDF->SetTextColor(0,0,0);
    $PDF->MultiCell(0, 25, "Fiche de frais du client :\n " . $_SESSION['idVisiteur'], 1, "C", 0);

    $PDF->Image("../images/logo.jpg", 150, 15, 40, 40);

    $position = 100; 
    $requete2 = $bdd->query("SELECT * FROM Visiteur WHERE login = '$user';");

    $PDF->SetTextColor(0,0,0);

    $PDF->SetFont("Arial","B",16);
    $PDF->SetY($position-5);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,utf8_decode("Date"),1,'C');

    $PDF->SetY($position-5);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Libellé"),1,'C');

    $PDF->SetY($position-5);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,utf8_decode("Montant"),1,'C');

    $PDF->SetY($position+30);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,utf8_decode("Prix Total"),1,'C');                     

    $PDF->SetTextColor(0,0,0);

    while ($donne = $requete2->fetch()) {
      $idProduit = $donne['idProduit'];
      $select = $bdd->query("SELECT * FROM LigneFraisForfait WHERE idVisiteur = '$idVisiteur';");
      $donneesUser = $select->fetch();
      $PDF->SetFont("Arial","I",16);

      $PDF->SetY($position);
      $PDF->SetX(15);
      $PDF->MultiCell(60,8,utf8_decode($donneesUser['idVisiteur']),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(75);
      $PDF->MultiCell(60,8,utf8_decode($donneesUser['mois']),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(135);
      $PDF->MultiCell(60,8,utf8_decode($donneesUser['idFraisForfait']."e"),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(195);
      $PDF->MultiCell(60,8,utf8_decode($donneesUser['quantite']),1,'C');
      $position += 8;
    }
    $PDF->Output();
    $recupNbCommade = $bdd->query("SELECT COUNT(*) AS nbCommade FROM commade WHERE userConnexion = '$user' ;");
    $resultatNbCommade = $recupNbCommade->fetch();
    $nbCommade = $resultatNbCommade['nbCommade'];
    $nbCommade = $nbCommade + 1;
    $PDF->Output("commande/".$user.$nbCommade.".PDF", "F");
  }
  else {
    echo "erreur";
  }
?>