<?php
    session_start();
    include "../include/fpdf/fpdf.php;
    
    $idVisiteur = $_SESSION['idVisteur'];

    $PDF = new fpdf();
    $PDF->AddPage();
    $PDF->SetFont("Arial","B",16);
    $PDF->SetTextColor(0,0,0);
    $PDF->MultiCell(0, 10, " Bienvenue \n PDF de :\n" . $_SESSION['idVisiteur'], 1, "C", 0);
    //$PDF->Image("../Image/logo.jpg", 80, 40, 50, 50);

    $position = 120; 
    $requete2 = $bdd->query("SELECT * FROM panier WHERE idUtilisateur = '$idVisiteur';");

    $PDF->SetTextColor(0,0,0);

    $PDF->SetY($position-16);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Prix Total"),1,'C');
    $PDF->SetFont("Arial","",16);
    $PDF->SetY($position-16);
    $PDF->SetX(135);
    /*$PDF->MultiCell(60,8,utf8_decode($_SESSION['totalPanier']."e"),1,'C');*/

    $PDF->SetFont("Arial","B",16);
    $PDF->SetY($position-8);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,utf8_decode("Produit"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Prix"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,utf8_decode("Quantité"),1,'C');

    $PDF->SetTextColor(0,0,0);

    while ($donnees = $requete2->fetch()) {
      $idProduit = $donnees['idProduit'];
      $select = $bdd->query("SELECT * FROM produit WHERE idProduit = '$idProduit';");
      $donneesProduit = $select->fetch();
      $PDF->SetFont("Arial","I",16);

      $PDF->SetY($position);
      $PDF->SetX(15);
      $PDF->MultiCell(60,8,utf8_decode($donneesProduit['nomProduit']),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(75);
      $PDF->MultiCell(60,8,utf8_decode($donneesProduit['prixProduit']."e"),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(135);
      $PDF->MultiCell(60,8,utf8_decode($donneesProduit['quantiteProduit']),1,'C');

      $position += 8;
    }

    $PDF->Output();
    $recupNbCommande = $bdd->query("SELECT COUNT(*) AS nbCommande FROM commande WHERE idUtilisateur = '$user' ;");
    $resultatNbCommande = $recupNbCommande->fetch();
    $nbCommande = $resultatNbCommande['nbCommande'];
    $nbCommande = $nbCommande + 1;
    $PDF->Output("commande/".$user.$nbCommande.".PDF", "F");
  }
  else {
    echo "Erreur de connexion a la base de données";
  }

?>