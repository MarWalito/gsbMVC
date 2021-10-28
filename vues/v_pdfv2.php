<?php
    session_start();
    // Connexion à la BDD (à personnaliser)
    require_once "../include/fpdf/fpdf.php";
    include "../include/class.pdogsb.inc.php";


    
// Si base de données en UTF-8, utiliser la fonction utf8_decode pour tous les champs de texte à afficher
// extraction des données à afficher dans le sous-titre (nom du voyageur et dates de son voyage)

// Création de la class PDF
class PDF extends FPDF {
    // Header
    function Header()
    {
        // Logo : 8 >position à gauche du document (en mm), 2 >position en haut du document, 80 >largeur de l'image en mm). La hauteur est calculée automatiquement.
        $this->Image('../images/logo3.png', 8, 2);
        // Saut de ligne 20 mm
        $this->Ln(20);
        // Titre gras (B) police Helbetica de 11
        $this->SetFont('Helvetica', 'B', 11);
        $this->SetTextColor(255,255,255);
        // fond de couleur gris (valeurs en RGB)
        $this->setFillColor(203, 121, 125);
        // position du coin supérieur gauche par rapport à la marge gauche (mm)
        $this->SetX(70);
        // Texte : 60 >largeur ligne, 8 >hauteur ligne. Premier 0 >pas de bordure, 1 >retour à la ligneensuite, C >centrer texte, 1> couleur de fond ok
        $this->Cell(80, 10, 'Fiche de frais du client :', 0, 1, 'C', 1);
        // Saut de ligne 10 mm
        $this->Ln(10);
    }
    // Footer
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        // Police Arial italique 8
        $this->SetFont('Helvetica', 'I', 9);
        // Numéro de page, centré (C)
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// On active la classe une fois pour toutes les pages suivantes
// Format portrait (>P) ou paysage (>L), en mm (ou en points > pts), A4 (ou A5, etc.)
$pdf = new PDF('P', 'mm', 'A4');

// Nouvelle page A4 (incluant ici logo, titre et pied de page)
$pdf->AddPage();
// Polices par défaut : Helvetica taille 9
$pdf->SetFont('Helvetica', '', 9);
// Couleur par défaut : noir
$pdf->SetTextColor(0);
// Compteur de pages {nb}
$pdf->AliasNbPages();

// Sous-titre calées à gauche, texte gras (Bold), police de caractère 11
$pdf->SetFont('Helvetica', 'B', 11);
// couleur de fond de la cellule : gris clair
$pdf->setFillColor(230, 230, 230);

// Fonction en-tête des tableaux en 3 colonnes de largeurs variables
function entete_table($position_entete) {
    $bdd = new PDO('mysql:host=localhost;dbname=gsbv2;charset=utf8', 'root', '');

    global $pdf;
    $pdf->SetDrawColor(183); // Couleur du fond RVB
    $pdf->SetFillColor(221); // Couleur des filets RVB
    $pdf->SetTextColor(0); // Couleur du texte noir
    $pdf->SetY($position_entete);
    // position de colonne 1 (10mm à gauche)
    $pdf->SetX(15);
    $pdf->Cell(60, 8, 'Ville', 1, 0, 'C', 1); // 60 >largeur colonne, 8 >hauteur colonne
    // position de la colonne 2 (70 = 10+60)
    $pdf->SetX(75);

    $pdf->Cell(60, 8, 'Pays', 1, 0, 'C', 1);
    // position de la colonne 3 (130 = 70+60)
    $pdf->SetX(135);
    $pdf->Cell(60, 8, 'Repas', 1, 0, 'C', 1);
    $pdf->Ln(); // Retour à la ligne

    
}
    // AFFICHAGE EN-TÊTE DU TABLEAU
    // Position ordonnée de l'entête en valeur absolue par rapport au sommet de la page (70 mm)
    $position_entete = 70;
    // police des caractères
    $pdf->SetFont('Helvetica','',9);
    $pdf->SetTextColor(0);
    // on affiche les en-têtes du tableau
    entete_table($position_entete);

// }
$pdf->Output();
?>