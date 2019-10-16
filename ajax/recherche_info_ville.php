<?php
include_once('../class/autoload.php');
$data = array();
$mypdo=new mypdo();
if(isset($_POST['id_ville']))
{
	// exécution de la requête
	$resultat = $mypdo->trouve_infos_ville_via_idVille($_POST['id_ville']);
	if(isset($resultat))
	{
		// résultats
		while($donnees = $resultat->fetch(PDO::FETCH_OBJ)) {
			// je remplis un tableau et mettant le nom de la ville en index pour garder le tri
      $data["ville_departement"][] = ($donnees->ville_departement);
      $data["ville_code_postal"][] = ($donnees->ville_code_postal);
      $data["ville_nom_reel"][] = ($donnees->ville_nom_reel);
      $data["ville_latitude_deg"][] = ($donnees->ville_latitude_deg);
      $data["ville_longitude_deg"][] = ($donnees->ville_longitude_deg);
		}
	}
}
// renvoit un tableau dynamique encodé en json
echo json_encode($data);

?>
