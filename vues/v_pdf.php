<?php
  session_start();
  require_once('../include/fpdf/fpdf.php')  ;
  include('../controleurs/c_etatFrais.php');

// Création de la class PDF
class PDF extends FPDF {
    // Header
    function Header() {
        // Titre gras (B) 
        $this->SetFont('Arial','B',11);
        // fond de couleur gris (valeurs en RGB)
        $this->SetFillColor(211);
        // Décallage vers la doite
        $this->Cell(60);
        // Texte : 160 >largeur ligne, 18 > hauteur ligne. Premier 1 > pas de bordure, 1 > retour à la ligne , C > centrer texte 
        $this->Cell(160,18,'INVENTAIRE',1,1,'C',1);
        // Saut de ligne 10
        $this->Ln(5);    
    }
    // Footer
    function Footer() {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-13);
        // Police Arial italique 8
        $this->SetFont('Arial','I',9);
        // Numéro de page, centré (C)
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
function entete_table($position_entete) {
    global $pdf;
    // Couleur du fond RVB
    $pdf->SetDrawColor(180); 
    // Couleur des filets RVB
    $pdf->SetFillColor(221); 
    // Couleur du texte noir
    $pdf->SetTextColor(0); 
    $pdf->SetY($position_entete);
    // position de colonne 1 (5mm à gauche)  
    $pdf->SetX(5);
    // 25 >largeur colonne, 8 >hauteur colonne
    $pdf->Cell(25,8,utf8_decode('Lot'),1,0,'C',1);  
    // position de la colonne 2 (30 = 5+25)
    $pdf->SetX(30); 
    $pdf->Cell(50,8,utf8_decode('Produit'),1,0,'C',1);
    // position de la colonne 3 (80 = 30+50)
    $pdf->SetX(80); 
    $pdf->Cell(50,8,utf8_decode('Conditionnement'),1,0,'C',1);
    // position de la colonne 4 (130 = 80+50)
    $pdf->SetX(130); 
    $pdf->Cell(50,8,utf8_decode('Fournisseur'),1,0,'C',1);
    // position de la colonne 5 (180 = 130+50)
    $pdf->SetX(180); 
    $pdf->Cell(30,8,utf8_decode('Quantité'),1,0,'C',1);
    // position de la colonne 6 (210 = 180+30)
    $pdf->SetX(210); 
    $pdf->Cell(30,8,utf8_decode('Prix Unitaire HT'),1,0,'C',1);
    // position de la colonne 7 (240 = 210+30)
    $pdf->SetX(240); 
    $pdf->Cell(30,8,utf8_decode('Valeut stock TTC'),1,0,'C',1);
    // position de la colonne 8 (270 = 240+30)
    $pdf->SetX(270); 
    $pdf->Cell(25,8,utf8_decode('Taux TVA'),1,0,'C',1);

    // Retour à la ligne
    $pdf->Ln();
}

$pdf = new PDF('L','mm','A4');
//Ajout d'une nouvelle page pdf
$pdf->AddPage();
// Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
$position_entete = 50;
// AFFICHAGE EN-TÊTE DU TABLEAU
// police des caractères
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0);

// Position ordonnée = $position_entete+hauteur de la cellule d'en-tête
$position_detail = 58;
// $requete = "SELECT * FROM FraisForfait";

$fhf = $result->getLesFraisHorsForfait($idVisiteur,$mois);
while($fhf->fetch()) {
    // position abcisse de la colonne 1 (10mm du bord)
    $pdf->SetY($position_detail);
    $pdf->SetX(5);
    $pdf->MultiCell(25,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 2  
    $pdf->SetY($position_detail);
    $pdf->SetX(30); 
    $pdf->MultiCell(50,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 3
    $pdf->SetY($position_detail);
    $pdf->SetX(80); 
    $pdf->MultiCell(50,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 4
    $pdf->SetY($position_detail);
    $pdf->SetX(130); 
    $pdf->MultiCell(50,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 5
    $pdf->SetY($position_detail);
    $pdf->SetX(180); 
    $pdf->MultiCell(30,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 6
    $pdf->SetY($position_detail);
    $pdf->SetX(210); 
    $pdf->MultiCell(30,8,utf8_decode($data['libelle']),1,'C');
    // position abcisse de la colonne 7
    $calculTTC = calculTTC($data['QuantiteStock'], $data['PrixUnitaireHorsTaxe'], $data['TVA']);
    $pdf->SetY($position_detail);
    $pdf->SetX(240); 
    $pdf->MultiCell(30,8,utf8_decode($calculTTC),1,'C');
    // position abcisse de la colonne 8
    $pdf->SetY($position_detail);
    $pdf->SetX(270); 
    $pdf->MultiCell(25,8,utf8_decode($data['TVA']),1,'C');
    
    // on incrémente la position ordonnée de la ligne suivante (+8mm = hauteur des cellules)  
    $position_detail += 8; 
}
mysqli_free_result($result);
// on affiche les en-têtes du tableau
entete_table($position_entete);
//Police par défaut
$pdf->SetFont('Arial','B',16);
// Couleur par défaut : noir
$pdf->SetTextColor(0);
// Compteur de pages {nb}
$pdf->AliasNbPages();

//Affichage du pdf
$pdf->Output('v_pdf.php','I');
?>