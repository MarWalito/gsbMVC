<?php
  if (!isset($_SESSION)) {
    session_start();
  }

  require("fpdf/fpdf.php");

  ob_get_clean();

  $position = 60;

  $PDF = new fpdf();
  $PDF->AddPage();
  $PDF->SetTextColor(255,0,0);
  // entete
  $PDF->SetFont("Arial","B",16);
  $PDF->SetY(60);
  $PDF->Cell(0, 0, "Fiche de frais", 0, 0, "C", 0);
  $PDF->SetFont("Arial","I",8);
  $PDF->SetY(70);
  $PDF->Image("images/logo.jpg", 80, 0, 50, 50);

  //info visiteur et mois

  $PDF->SetFont("Arial","",16);
  $PDF->SetY(80);
  $PDF->Cell(0, 0, utf8_decode("Visiteur : " . $idVisiteur . " - ". $nom), 0, 0, "L", 0);

  $PDF->SetFont("Arial","",16);
  $PDF->SetY(90);
  $PDF->Cell(0, 0, utf8_decode("Mois fiche de frais : " . $numMois."-".$numAnnee), 0, 0, "L", 0);


  //Frais forfaitisés
  $PDF->SetFont("Arial","I",16);
  $position = 130;
  

  $PDF->SetY($position-8);
  $PDF->SetX(15);
  $PDF->MultiCell(45,8,utf8_decode("Frais Forfaitaires"),1,'C');

  $PDF->SetY($position-8);
  $PDF->SetX(60);
  $PDF->MultiCell(45,8,utf8_decode("Quantité"),1,'C');

  $PDF->SetY($position-8);
  $PDF->SetX(105);
  $PDF->MultiCell(45,8,utf8_decode("Montant Unitaire"),1,'C');

  $PDF->SetY($position-8);
  $PDF->SetX(150);
  $PDF->MultiCell(45,8,utf8_decode("Total"),1,'C');


  $PDF->SetFont("Arial","",12);

  foreach ($lesFraisForfait as $unFraisForfait) {
    $PDF->SetY($position);
    $PDF->SetX(15);
    $PDF->MultiCell(45,8,utf8_decode($unFraisForfait['libelle']),1,'C');

    $PDF->SetY($position);
    $PDF->SetX(60);
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
  $PDF->SetFont("Arial","B",16);
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
  $PDF->SetFont("Arial","",12);

  foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {

    $date = date($unFraisHorsForfait['date']);

    $PDF->SetY($position);
    $PDF->SetX(15);
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
