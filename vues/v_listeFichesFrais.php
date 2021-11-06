
<h3>Fiches de frais du mois <?php echo $numMois."-".$numAnnee?> :
    </h3>
    <div class="encadre">

    <form action="index.php?uc=suivrePaiement&action=detailFicheFrais" method="post">

    <table class="listeLegere">
  	   <caption>Liste des fiches de frais
       </caption>
             <tr>
                <th class="date">Date de modification</th>
                <th class="date">Nom</th>
                <th class='date'>Prenom</th>
                <th class='date'>Etat</th>
                <th class='date'>Détails</th>
             </tr>
        <?php
          foreach ( $lesFichesFrais as $uneFicheFrais ){
      			$dateModif = $uneFicheFrais['dateModif'];
      			$nom = $uneFicheFrais['nom'];
      			$prenom = $uneFicheFrais['prenom'];
      			$etat = $uneFicheFrais['typeEtat'];
            $idVisiteur = $uneFicheFrais['idVisiteur'];
            $mois = $uneFicheFrais['mois'];
    		?>
             <tr>
                <td><?php echo $dateModif ?></td>
                <td><?php echo $nom ?></td>
                <td><?php echo $prenom ?></td>
                <td><?php echo $etat ?></td>
                <td>
                  <input id="ok" type="hidden" name="idVisiteur" value="<?php echo $idVisiteur; ?>">
                  <input id="ok" type="hidden" name="mois" value="<?php echo $mois; ?>">
                  <input id="ok" type="submit" value="Afficher" size="20" />
                </td>
             </tr>
        <?php
          }
		?>
    </table>

  </form>

  </div>
  </div>
