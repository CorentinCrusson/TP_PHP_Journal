<?php
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();
if(isset($_POST['id_dep']))
{
	// exécution de la requête
	$resultat = $mypdo->trouve_toutes_les_ville_via_un_departement($_POST['id_dep']);
	if(isset($resultat))
	{
		// résultats
		while($donnees = $resultat->fetch(PDO::FETCH_OBJ)) {
			// je remplis un tableau et mettant le nom de la ville en index pour garder le tri
			$data[$donnees->ville_nom_reel][] = ($donnees->ville_id);
		}
	}
}
// renvoit un tableau dynamique encodé en json
echo json_encode($data);
?>
