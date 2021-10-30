<?php
  session_start();
  include "../include/fPDF/fPDF.php";
  include "../include/class.pdogsb.inc.php";
  $bdd = new PDO('mysql:host=localhost;dbname=gsbv2;charset=utf8', 'root', '');
  if ($bdd) {
    $user = $_SESSION['idVisiteur'];
    $PDF = new fPDF();
    $PDF->AddPage();
    // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
    $PDF->Image('../images/logo3.png', 8, 2);
    // Saut de ligne 20 mm
    $PDF->Ln(10);
    // Titre gras (B) police Helbetica de 11
    $PDF->SetFont('Helvetica', 'B', 11);
    $PDF->SetTextColor(255,255,255);
    // fond de couleur gris (valeurs en RGB)
    $PDF->setFillColor(203, 121, 125);
    // position du coin supérieur gauche par rapport à la marge gauche (mm)
    $PDF->SetX(70);

    // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
    $PDF->Cell(80, 10, 'Fiche de frais du client :', 0, 1, 'C', 1);
    // Saut de ligne 10 mm
    $PDF->Ln(10);

    $position = 60;

    $PDF->SetTextColor(0,0,0);

    $PDF->SetDrawColor(183); // Couleur du fond RVB
    $PDF->SetFillColor(221); // Couleur des filets RVB
    $PDF->SetTextColor(0); // Couleur du texte noir
    $PDF->SetY($position-8);
    // position de colonne 1 (15mm à gauche)
    $PDF->SetX(15);
    $PDF->Cell(60, 8, 'Date', 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne
    // position de colonne 1 (75mm à gauche)
    $PDF->SetX(75);
    $PDF->Cell(60, 8, 'Libelle', 1, 0, 'C', 1);
    // position de colonne 1 (135mm à gauche)

    $PDF->SetX(135);
    $PDF->Cell(60, 8, 'Montant', 1, 0, 'C', 1);
    $PDF->Ln(); // Retour à la ligne

    //foreach ($lesFraisHorsForfait as $donneesVisiteur){

    $req = $bdd->query("SELECT id FROM Visiteur WHERE id = '$user';");

    $mont = $req->fetch();

    $id = $mont['id'];
    $select = $bdd->query("SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = '$id';");
    $donneesVisiteur = $select->fetch();

    $PDF->SetFont("Helvetica", "", 10);

    $PDF->SetY($position);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,($donneesVisiteur['date']),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,($donneesVisiteur['libelle']),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,($donneesVisiteur['montant']." Euros"),1,'C');

    $position += 8;
    //}

    $PDF->Output();
  
  }
  else {
    echo "Erreur de connexion a la base de données";
  }

?>