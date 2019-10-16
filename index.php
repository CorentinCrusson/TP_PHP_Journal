<?php
	session_start();

	include_once('class/autoload.php');
	$site = connexsecurise();
	$controleur=new controleur();
	$request = strtolower($_SERVER['REQUEST_URI']);
	$params = explode('/', trim($request, '/'));
    $params = array_filter($params);

	if (!isset($params[3]))
	{

		$params[3]='accueil';
	}
	switch ($params[3]) {

		case 'accueil' :
			$site->titre='Accueil';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar=$controleur->retourne_carrousel();
			$site-> left_sidebar=$controleur->retourne_article($site->titre);
			$site-> left_sidebar=$controleur->retourne_article_journaliste();
			$site->affiche();
			break;

		case 'connexion' :
			$site->titre='Connexion';
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='jquery.tooltipster.min';
			$site->js='all';
			$site->js='connexion';
			$site->css='all';
			$site->css='tooltipster';
			$site->css='tooltipster-sideTip-Light.min';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar=$controleur->retourne_formulaire_login();
			$site-> left_sidebar=$controleur->retourne_modal_message();
			$site->affiche();
			break;

		case 'departement' :
				$site->titre='Departement';
		    $site->js='departement';
		    $site->js='jquery.dataTables.min';
		    $site->js='dataTables.bootstrap4.min';
				$site->css='dataTables.bootstrap4.min';
		    $site-> right_sidebar=$site->rempli_right_sidebar();
		    $site-> left_sidebar=$controleur->retournerDepartement();
		    $site->affiche();
		    break;

		case 'ville' :

				$site->titre='Ville';
				$site->js='ol';
				$site->js='ville';
				$site->css='ol';
				$site->right_sidebar=$site->rempli_right_sidebar();
				$site->left_sidebar=$controleur->affiche_combo_departement();
				$site->left_sidebar=$controleur->affiche_combo_ville();
				$site->left_sidebar=$controleur->affiche_infos_ville();
				$site->affiche();
				break;

		case 'deconnexion' :
			$_SESSION=array();
			session_destroy();
			echo '<script>document.location.href="index.php"; </script>';
			break;

		default:
			$site->titre='Accueil';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar='<img src="'.$site->path.'/image/erreur-404.png" alt="Erreur de liens">';
			$site->affiche();
			break;
	}

	function connexsecurise() {
	$retour;
	if(!isset($_SESSION['id']) || !isset($_SESSION['type']))
	{
		$retour = new page_base();

	}
	else
	{
		if($_SESSION['type']=='3')
		{
			$retour = new page_base_securisee_journaliste();
		}
		if($_SESSION['type']=='2')
		{
			$retour = new page_base_securisee_redacteur();
		}
		if($_SESSION['type']=='1')
		{
			$retour = new page_base_securisee_administrateur();
		}
	}
	return $retour;
}


?>
