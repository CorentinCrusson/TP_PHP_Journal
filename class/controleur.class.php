<?php
class controleur {

	private $vpdo;
	private $db;
	public function __construct() {
		$this->vpdo = new mypdo ();
		$this->db = $this->vpdo->connexion;
	}
	public function __get($propriete) {
		switch ($propriete) {
			case 'vpdo' :
				{
					return $this->vpdo;
					break;
				}
			case 'db' :
				{
					
					return $this->db;
					break;
				}
		}
	}
	public function retourne_article($title)
	{
		
		$retour='<section>';
		$result = $this->vpdo->liste_article($title);
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{
		
				$retour = $retour . '<div class="card text-white bg-dark m-2" ><div class="card-body">
				<article>
					<h3 class="card-title">'.$row->h3.'</h3>                    
					<p class="card-text">'.$row->corps.'</p>
                    <p class="card-text"><i>'.'Ecrit par '.$row->intitule.' '.$row->nom.' '.$row->prenom.'    , le '.$row->date_redaction.'</i></p>
				</article>
				</div></div>';
			}
		$retour = $retour .'</section>';
		return $retour;
		}
	}
	
	public function retourne_carrousel()
	{
	    $retour='';
	    $retour = $retour.'<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	    <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	    </ol>
	    <div class="carousel-inner">
	    <div class="carousel-item active">
	    <img class="d-block w-50" src="image/france/data1/images de base/aiguille-du-Midi.jpg" alt="L\'aiguille du Midi">
	    </div>
	    <div class="carousel-item">
	    <img class="d-block w-50" src="image/france/data1/images de base/Bonifacio.jpg" alt="Bonifacio">
	    </div>
	    <div class="carousel-item">
	    <img class="d-block w-50" src="image/france/data1/images de base/pigeon-paris-.jpg" alt="Pigeon Paris">
	    </div>
	    </div>
	    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	    </a>
	    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	    </a>
	    </div>';
        return $retour;
	}

	public function retournerDepartement()
	{
	    $retour = '';
	    $retour = $retour.'<div class="table-responsive">
	    <table id="deparTable" class="table table-striped table-bordered" cellspacing="0" >
            <thead>
            	<tr>
            		<th>Code d�partement</th>
            		<th>D�partement</th>
            		<th>R�gion</th>
            	</tr>
            </thead>
         </table>
        </div>';

        return $retour;	    
	}
	
	public function genererMDP ($longueur = 8){
		// initialiser la variable $mdp
		$mdp = "";
	
		// Définir tout les caractères possibles dans le mot de passe,
		// Il est possible de rajouter des voyelles ou bien des caractères spéciaux
		$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ&#@$*!";
	
		// obtenir le nombre de caractères dans la chaîne précédente
		// cette valeur sera utilisé plus tard
		$longueurMax = strlen($possible);
	
		if ($longueur > $longueurMax) {
			$longueur = $longueurMax;
		}
	
		// initialiser le compteur
		$i = 0;
	
		// ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
		while ($i < $longueur) {
			// prendre un caractère aléatoire
			$caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);
	
			// vérifier si le caractère est déjà utilisé dans $mdp
			if (!strstr($mdp, $caractere)) {
				// Si non, ajouter le caractère à $mdp et augmenter le compteur
				$mdp .= $caractere;
				$i++;
			}
		}
	
		// retourner le résultat final
		return $mdp;
	}
	
	
}

?>
