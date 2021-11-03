<?php
  if (!isset($_SESSION)) {
    session_start();
  }

  require("fpdf/fpdf.php");

  ob_get_clean();

  $PDF = new fPDF();
  $PDF->AddPage();
  // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
  $PDF->Image('images/logo3.png', 8, 2);
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
  $PDF->Cell(80, 10, 'Fiche de frais du client : ' . $nom . " " . $prenom, 0, 1, 'C', 1);
  // Saut de ligne 10 mm
  $PDF->Ln(10);

  $position = 60;

  $PDF->SetDrawColor(183); // Couleur du fond RVB
  $PDF->SetFillColor(221); // Couleur des filets RVB
  $PDF->SetTextColor(0); // Couleur du texte noir


  //info visiteur et mois
  $PDF->SetTextColor(0);
  $PDF->SetDrawColor(183);
  $PDF->SetFillColor(221); // Couleur des filets RVB
  $PDF->SetY($position-8);



  $PDF->Ln(10);
  $PDF->SetFont('Helvetica', 'B', 11);
  $PDF->SetDrawColor(203, 121, 125); // Couleur du fond RVB
  $PDF->SetLineWidth(0.28);

  $PDF->SetY($position-8);
  $PDF->SetX(15);
  
  $PDF->SetFillColor(221); // Couleur des filets RVB
  $PDF->SetDrawColor(0); // Couleur du fond RVB

  $PDF->Cell(45, 8, 'Visiteur', 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne


  $PDF->SetFont('Helvetica', '', 11);
  $PDF->SetY($position-8);
  $PDF->SetX(60);
  $PDF->MultiCell(45,8,utf8_decode($idVisiteur . " - ". $nom),1,'C');
  
  
  
  $PDF->SetFont('Helvetica', 'B', 11);
  $PDF->SetY($position);
  $PDF->SetX(15);
  $PDF->Cell(45, 8, 'Mois fiche de frais', 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne


  $PDF->SetFont('Helvetica', '', 11);
  $PDF->SetY($position);
  $PDF->SetX(60);
  $PDF->MultiCell(45,8, $numMois." - ".$numAnnee,1,'C');

  $position += 8;

 


  $position = 90;
  //Frais forfaitisés
  $PDF->SetFont('Helvetica', 'B', 11);
  $PDF->SetFillColor(221); // Couleur des filets RVB
  $PDF->SetDrawColor(203, 121, 125); // Couleur du fond RVB


  $PDF->SetY($position-8);
  $PDF->SetX(15);
  $PDF->Cell(45, 8, utf8_decode("Frais Forfaitaires"), 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne



  $PDF->SetY($position-8);
  $PDF->SetX(60);
  $PDF->Cell(45, 8, utf8_decode("Quantité"), 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne


  $PDF->SetY($position-8);
  $PDF->SetX(105);
  $PDF->Cell(45, 8, utf8_decode("Montant Unitaire"), 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne


  $PDF->SetY($position-8);
  $PDF->SetX(150);
  $PDF->Cell(45, 8, utf8_decode("Total"), 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne



  foreach ($lesFraisForfait as $unFraisForfait) {
    $PDF->SetY($position);
    $PDF->SetX(15);
    $PDF->SetFont('Helvetica', 'B', 11);

    $PDF->MultiCell(45,8,utf8_decode($unFraisForfait['libelle']),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(60);
    $PDF->SetFont('Helvetica', '', 11);
    $PDF->MultiCell(45,8, $unFraisForfait['quantite'],1,'C');

    $PDF->SetY($position);
    $PDF->SetX(105);
    $PDF->MultiCell(45,8,$unFraisForfait['montantFrais'] . " " . chr(128),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(150);
    $PDF->MultiCell(45,8, $unFraisForfait['quantite'] * $unFraisForfait['montantFrais'] . " " . chr(128),1,'C');

    $position += 8;
  }

  $position += 10;

  //frais hors forfait
  $PDF->SetFont('Helvetica', 'B', 11);
  $PDF->SetY($position);
  $PDF->Cell(0, 0, "Frais hors forfait", 0, 0, "C", 0);

  $position += 10;

  $PDF->SetY($position);
  $PDF->SetX(15);
  $PDF->MultiCell(45,8,utf8_decode("Date"),1,'C');

  $PDF->SetY($position);
  $PDF->SetX(60);
  $PDF->MultiCell(90,8,utf8_decode("Libellé"),1,'C');

  $PDF->SetY($position);
  $PDF->SetX(150);
  $PDF->MultiCell(45,8,utf8_decode("Montant"),1,'C');

  $position += 8;
  $PDF->SetFont('Helvetica', 'B', 11);

  foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {

    $date = date($unFraisHorsForfait['date']);

    $PDF->SetY($position);
    $PDF->SetX(15);
    $PDF->SetFont('Helvetica', '', 11);
    $PDF->MultiCell(45,8,$date,1,'C');

    $PDF->SetY($position);
    $PDF->SetX(60);
    $PDF->MultiCell(90,8,utf8_decode($unFraisHorsForfait['libelle']),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(150);
    $PDF->MultiCell(45,8,$unFraisHorsForfait['montant'] . " " . chr(128),1,'C');

    $position += 8;
  }

  $position += 10;


  $PDF->Output("vues/v_pdf.php","I");
?>
