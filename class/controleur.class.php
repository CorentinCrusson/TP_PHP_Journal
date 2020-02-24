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
		$max = 200;
		$nb = 0;
		$result = $this->vpdo->liste_article($title);
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{
				$nb +=1;
				$corps = $row->corps;
                $more = '';                
                if (strlen($corps)>$max) {
                    $more = substr($corps,$max);
                    $corps = substr($corps,0,$max);
                }
				$retour = $retour . '
				<div class="card text-white bg-dark m-2" >
				<div class="card-body">
					<article>
						<h3 class="card-title">'.$row->h3.'</h3>

						<div id="summary">
							<p class="collapse card-text" id="collapseSummary">'.$corps.'<!--
								--><span id="dots '.$nb.'">...</span><!--
								--><span id="more '.$nb.'" style="display:none">'.$more.'</span>
							</p>
							<button onclick="display('.$nb.')" id="myBtn '.$nb.'">Lire plus</button>
							<a class="collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
				      	</div>
	          <p class="card-text"><i>'.'Ecrit par '.$row->intitule.' '.$row->nom.' '.$row->prenom.'    , le '.$row->date_redaction.'</i></p>
					</article>
				</div>
			</div>';
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
            		<th>Code departement</th>
            		<th>Departement</th>
            		<th>Region</th>
            	</tr>  </thead> <tbody>';
		 $result = $this->vpdo->liste_dep();
		 if ($result != false) {
			 while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
					{
							$retour = $retour.'<tr>
							<td>'.$row->departement_code.'</td>
							<td>'.$row->departement_nom.'</td>
							<td>'.$row->libel.'</td>
							</tr>';
					}

			$retour = $retour.'</tbody>
         </table>
        </div>';

        return $retour;
			}
	}

	public function affiche_combo_departement(){

		$retour = '<div class="left_sidebar">
		<SELECT id="liste_dep" onChange="js_change_dep()" >';

		//Combo Box Departement
		$result = $this->vpdo->liste_dep();
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
				 {
						 $retour = $retour."<option value='$row->departement_code'>$row->departement_nom</OPTION>";
				}

		$retour = $retour.'</SELECT></div>';
		return $retour;
		}
	}

		public function affiche_combo_ville(){

			$retour = '<div class="left_sidebar">
			<SELECT id="liste_ville" style="display: none" onChange="js_change_ville()">';

			//Combo Box Departement
			$retour = $retour.'</SELECT> </div>';
			return $retour;

	}

	public function affiche_infos_ville(){

		$retour = '<div class="left_sidebar">
		<div id="infos_ville" style="display: none">

		<label> Département : </label>
		<input id="iddep" />

		<label> Code Postal : </label>
		<input id="ville_cp" />

		<label> Ville : </label>
		<input id="ville_nom" />

		<label> Latitude : </label>
		<input id="ville_lat" />

		<label> Longitude : </label>
		<input id="ville_long" />

		';
		$retour = $retour . '
		 <div id="map" class="map" style="display: none; height:0%">
		 </div>
		';

		$retour = $retour.'</div>';


		return $retour;

}

public function retourne_formulaire_login() {
	$retour = '
			<div class="modal fade" id="myModal" role="dialog" style="color:#000;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
	        				<h4 class="modal-title"><span class="fas fa-lock"></span> Formulaire de connexion</h4>
	        				<button type="button" class="close" data-dismiss="modal" aria-label="Close" ">
	          					<span aria-hidden="true">&times;</span>
	        				</button>
	      				</div>
						<div class="modal-body">
							<form role="form" id="login" method="post">
								<div class="form-group">
									<label for="id"><span class="fas fa-user"></span> Identifiant</label>
									<input type="text" class="form-control" id="id" name="id" placeholder="Identifiant">
								</div>
								<div class="form-group">
									<label for="mp"><span class="fas fa-eye"></span> Mot de passe</label>
									<input type="password" class="form-control" id="mp" name="mp" placeholder="Mot de passe">
								</div>
								<div class="form-group">
									<label class="radio-inline"><input type="radio" name="rblogin" id="rbj" value="rbj">Journaliste</label>
									<label class="radio-inline"><input type="radio" name="rblogin" id="rbr" value="rbr">Rédacteur en chef</label>
									<label class="radio-inline"><input type="radio" name="rblogin" id="rba" value="rba">Administrateur</label>
								</div>
								<button type="submit" class="btn btn-success btn-block" class="submit"><span class="fas fa-power-off"></span> Login</button>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button"  class="btn btn-danger btn-default pull-left" data-dismiss="modal" ><span class="fas fa-times"></span> Cancel</button>
						</div>
					</div>
				</div>
			</div>';

			return $retour;
}

public function retourne_modal_message()
	{
		$retour='
		<div class="modal fade" id="ModalRetour" role="dialog" style="color:#000;">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
        				<h4 class="modal-title"><span class="fas fa-info-circle"></span> INFORMATIONS</h4>
        				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="hd();">
          					<span aria-hidden="true">&times;</span>
        				</button>
      				</div>
		       		<div class="modal-body">
						<div class="alert alert-info">
							<p></p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" onclick="hdModalRetour();" >Close</button>
					</div>
				</div>
			</div>
		</div>
		';
		return $retour;
	}

	public function retourne_article_journaliste()
	{

		$retour='<script>$(document).ready(function() {$("#tart").dataTable().fadeIn();} )</script>
	<div class="table-responsive">
	<table id="tart" class="table table-striped table-bordered" cellspacing="0" style="display: none;">
    <thead><tr>
        <th>Titre article</th>
        <th>Page</th>
        <th>Date deb</th>
		<th>Date fin</th>
		<th></th>

	</tr></thead><tbody>';
		$result = $this->vpdo->liste_art_via_idSalarie($_SESSION['id']);
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{

				$retour = $retour . '<tr><td>'.$row->h3.'</td><td>'.$row->title.'</td><td>'.$row->date_deb.'</td><td>'.$row->date_fin.
				'</td><td style="text-align: center;"><button type="button" class="btn btn-primary btn-default pull-center"
				value="Modifier" onclick="modif_article('.$row->id.');">
				<span class="fas fa-edit"></span>
				</button></td></tr>';
			}

		}
		$retour = $retour .'</tbody></table></div>';
		return $retour;
	}

	public function retourne_liste_article()
	{

		$retour='<script>$(document).ready(function() {$("#tart").dataTable().fadeIn();} )</script>
	<div class="table-responsive">
	<table id="tart" class="table table-striped table-bordered" cellspacing="0" style="display: none;">
    <thead><tr>
        <th>Titre article</th>
        <th>Page</th>
        <th>Date deb</th>
		<th>Date fin</th>
		<th></th>

    </tr></thead><tbody style="color: white;">';
		$result = $this->vpdo->liste_art_via_idSalarie('%');
		if ($result != false) {
			while ( $row = $result->fetch ( PDO::FETCH_OBJ ) )
			// parcourir chaque ligne sélectionnée
			{

				$retour = $retour . '<tr><td>'.$row->h3.'</td><td>'.$row->title.'</td><td>'.$row->date_deb.'</td><td>'.$row->date_fin.
				'</td><td style="text-align: center;">';
				if ($row->publie==0) {
					$buttonType = 'btn-succes';
					$spanType = 'fa-check';			
				} else {
					$buttonType = 'btn-danger';	
					$spanType = 'fa-times';		
				}
				
				$retour = $retour . '<button type="button" class="btn '.$buttonType.' btn-default pull-center"
				onclick="valide_article("'.$row->id.'-'.$row->publie.');">
				<span class=" fas '.$spanType.' "></span>
				</button></td></tr>';
			}

		}
		$retour = $retour .'</tbody></table></div>';
		return $retour;
	}




	public function retourne_formulaire_article($action)
	{

		$retour=  '
		<form style='.$action[0].' role="form" id="'.$action[1].'" method="post"><h3>'.$action[2].'</h3>
		<div class="form-group">
		<label for="id"> Titre</label>
		<input type="text" class="form-control" id="h3" name="h3" placeholder="Titre">
		</div>
		<div class="form-group">
		<label for="date_deb"> Date Début</label>
		<input type="text" class="form-control" id="date_deb" name="date_deb" placeholder="Date début">
		</div>
		<div class="form-group">
		<label for="date_fin"> Date Fin</label>
		<input type="text" class="form-control" id="date_fin" name="date_fin" placeholder="Date fin">
		</div>
				<div class="form-group">
		<label for="corps"> Article</label>

				<textarea class="form-control" rows="5" id="corps" name="corps" placeholder="Corps article"></textarea>
		</div>
		<button type="submit" class="btn btn-success btn-default"><span class="fas fa-power-off"></span>'.$action[3].'</button>
				<button type="button"" class="btn btn-danger btn-default pull-left" ><span class="fas fa-times"></span> Cancel</button>
				</form>';
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
