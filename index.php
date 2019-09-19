<?php
	session_start();

	include_once('class/autoload.php');
	$site = new page_base();
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
			$site->affiche();
			break;

		case 'connexion' :
			$site->titre='Connexion';
			$site->js='jquery.validate.min';
			$site->js='messages_fr';
			$site->js='jquery.tooltipster.min';
			$site->css='tooltipster';
			$site-> right_sidebar=$site->rempli_right_sidebar();
			$site-> left_sidebar=$controleur->retourne_formulaire_login();
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
				$site->js='ville';
				$site-> right_sidebar=$site->rempli_right_sidebar();
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

?>