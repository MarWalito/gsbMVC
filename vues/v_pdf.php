<?php
  session_start();
  include "../include/fpdf/fpdf.php";
  include "../include/class.pdogsb.inc.php";
  $bdd = new PDO('mysql:host=localhost;dbname=gsbv2;charset=utf8', 'root', '');
  if ($bdd) {
    $user = $_SESSION['idVisiteur'];
    $PDF = new fpdf();
    $PDF->AddPage();
    $PDF->SetFont("Arial","B",16);
    $PDF->SetTextColor(0,0,0);
    $PDF->MultiCell(0,10,utf8_decode("Fiche de frais hors forfait"),0,'C',0);

    $position = 40;
    $req = $bdd->query("SELECT id FROM Visiteur WHERE id = '$user';");

    $PDF->SetTextColor(0,0,0);

    $PDF->SetFont("Arial","B",16);
    $PDF->SetY($position-8);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,utf8_decode("Date"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Libellé"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,utf8_decode("Montant"),1,'C');

    $PDF->SetTextColor(0,0,0);

    //foreach ($lesFraisHorsForfait as $donneesVisiteur){
    $mont = $req->fetch();

    $id = $mont['id'];
    $select = $bdd->query("SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = '$id';");
    $donneesVisiteur = $select->fetch();

    $PDF->SetFont("Arial","I",16);

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