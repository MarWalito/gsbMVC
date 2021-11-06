<?php
foreach ( $laFicheFrais as $uneFicheFrais ){
  $dateModif = $uneFicheFrais['dateModif'];
  $nom = $uneFicheFrais['nom'];
  $prenom = $uneFicheFrais['prenom'];
  $etat = $uneFicheFrais['typeEtat'];
  $idVisiteur = $uneFicheFrais['idVisiteur'];
  $mois = $uneFicheFrais['mois'];
}
?>
<h3>Fiches de frais de l'utilisateur <?php echo $nom." ".$prenom;?> :
    </h3>
    <div class="encadre">
      <form action="index.php?uc=suivrePaiement&action=modifierEtat" method="post">
        <table class="listeLegere">
          <caption>Liste des fiches de frais
          </caption>
          <tr>
            <th class="date">Date de modification</th>
            <th class="date">Nom</th>
            <th class='date'>Prenom</th>
            <th class='date'>Etat</th>
            <th class='date'>Modifier</th>
          </tr>
          <tr>
            <td><?php echo $dateModif ?></td>
            <td><?php echo $nom ?></td>
            <td><?php echo $prenom ?></td>
            <td><?php echo $etat ?></td>
            <td>
              <label for="lstEtat" accesskey="n">Etat : </label>
              <select id="lstEtat" name="lstEtat">
              <?php
        			foreach ($lesEtat as $unEtat)
        			{
                $idEtat = $unEtat['idEtat'];
        			  $etat = $unEtat['libelle'];
        				if($etat == $moisASelectionner){
        				?>
        				<option selected value="<?php echo $idEtat; ?>"><?php echo  $etat; ?> </option>
        				<?php
        				}
        				else{ ?>
        				<option value="<?php echo $idEtat; ?>"><?php echo  $etat; ?> </option>
        				<?php
        				}
        			}
        		  ?>
              </select>
            </td>
          </tr>
        </table>

      <div class="piedForm">
      <p>
        <input type="hidden" name="idVisiteur" value="<?php echo $idVisiteur; ?>">
        <input type="hidden" name="mois" value="<?php echo $mois; ?>">
        <input id="ok" type="submit" value="Valider" size="20" />
      </p>
      </div>
    </form>
  </div>
