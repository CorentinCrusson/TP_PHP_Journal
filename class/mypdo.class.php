<?php
class mypdo extends PDO{

    private $PARAM_hote='localhost'; // le chemin vers le serveur
    private $PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
    private $PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter
    private $PARAM_nom_bd='tourisme_france';
    private $connexion;
    public function __construct() {
    	try {

    		$this->connexion = new PDO('mysql:host='.$this->PARAM_hote.';dbname='.$this->PARAM_nom_bd, $this->PARAM_utilisateur, $this->PARAM_mot_passe,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    		//echo '<script>alert ("ok connex");</script>)';echo $this->PARAM_nom_bd;
    	}
    	catch (PDOException $e)
    	{
    		echo 'hote: '.$this->PARAM_hote.' '.$_SERVER['DOCUMENT_ROOT'].'<br />';
    		echo 'Erreur : '.$e->getMessage().'<br />';
    		echo 'N° : '.$e->getCode();
    		$this->connexion=false;
    		//echo '<script>alert ("pbs acces bdd");</script>)';
    	}
    }
    public function __get($propriete) {
    	switch ($propriete) {
    		case 'connexion' :
    			{
    				return $this->connexion;
    				break;
    			}
    	}
    }

    public function liste_article($title)
    {

		$requete='select g.intitule,s.nom,s.prenom, a.date_redaction,a.h3,a.corps from article a,page p, grade g, salarie s where a.page=p.id and p.title="'.$title.'" AND a.salarie = s.id AND s.grade = g.id AND publie = 1 AND NOW() BETWEEN date_deb AND date_fin ORDER BY num_ordre ASC;';

    	$result=$this->connexion->query($requete);
    	if ($result)

    	{

    			return ($result);
   		}
    	return null;
    }

    public function liste_art_journaliste($journaliste)
    {
        $requete='select a.h3,p.title,a.date_deb,a.date_fin,a.id FROM article a,page p,salarie s WHERE p.id = a.page AND a.salarie = s.id AND s.login = "'.$journaliste.'"';

      	$result=$this->connexion->query($requete);
      	if ($result)

      	{

      			return ($result);
     		}
      	return null;
    }

    public function liste_article_a_valider()
    {

		    $requete='select DISTINCT a.h3,p.title,a.date_deb,a.date_fin,a.id FROM article a,page p,salarie s WHERE a.publie=0';
      	$result=$this->connexion->query($requete);
      	if ($result)

      	{

      			return ($result);
     		}
      	return null;
    }

    public function liste_dep()
    {

    	$requete='SELECT departement_code,departement_nom,libel FROM departement,region,departement_region WHERE departement_code= code_dep and code_reg=code order by departement_code;';

    	$result=$this->connexion->query($requete);
    	if ($result)

    	{

    		return ($result);
    	}
    	return null;
    }

    public function create_article($tab)
    {
      $errors         = array();
      $data 			= array();
      $corps=utf8_encode($tab['corps']);
        $requete='insert into article(h3,corps,date_deb,date_fin,num_ordre,page,publie,salarie) values('
        .$this->connexion ->quote($tab['titre']) .','
        .$this->connexion ->quote($corps) .','
        .$this->connexion ->quote($tab['date_deb']) .','
        .$this->connexion ->quote($tab['date_fin']) .','
        .$this->connexion ->quote(0) .','
        .$this->connexion ->quote(3) .','
        .$this->connexion ->quote(1) .','
        .$_SESSION['type'] .');';

       $nblignes=$this->connexion -> exec($requete);
      if ($nblignes !=1)
      {
        $errors['requete']='Pas de insert d\'article :'.$requete;
      }



      if ( ! empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
      } else {

        $data['success'] = true;
        $data['message'] = 'Création article ok!';
      }
      return $data;
    }

    public function modif_article($tab)
    {
        	$errors         = array();
    	$data 			= array();
    $corps=utf8_encode($tab['corps']);
    	$requete='update article '
    	.'set h3='.$this->connexion ->quote($tab['titre']) .','
    	.'date_deb='.$this->connexion ->quote($tab['date_deb']) .','
    	.'date_fin='.$this->connexion ->quote($tab['date_fin']) .','
    	.'corps='.$this->connexion ->quote($corps)
 		.' where id='.$_SESSION['id_article'] .';';

     $nblignes=$this->connexion -> exec($requete);
    if ($nblignes !=1)
    {
    	$errors['requete']='Pas de modifications d\'article :'.$requete;
    }



    	if ( ! empty($errors)) {
    		$data['success'] = false;
    		$data['errors']  = $errors;
    	} else {

    		$data['success'] = true;
    		$data['message'] = 'Modification article ok!';
    	}
    	return $data;
    }


    public function trouve_toutes_les_ville_via_un_departement($id){
      $id = $id.'%';
      $requete= 'SELECT ville_id, ville_nom_reel FROM villes_france_free WHERE ville_code_postal LIKE "'.$id.'" order by ville_nom_reel';

      $result=$this->connexion->query($requete);
    	if ($result)

    	{

    		return ($result);
    	}
      return null;
    }

    public function trouve_infos_ville_via_idVille($id) {
      $requete= 'SELECT ville_departement,ville_code_postal, ville_nom_reel,ville_latitude_deg,ville_longitude_deg FROM villes_france_free WHERE ville_id='.$id;

      $result=$this->connexion->query($requete);
    	if ($result)

    	{

    		return ($result);
    	}
      return null;
    }

    public function trouve_article_via_id($id)
    {
      $requete='select a.h3,a.date_deb,a.date_fin,a.corps from article a
    			where a.id='.$id.';';

    	$result=$this->connexion ->query($requete);
    	if ($result)

    	{

    		return ($result);
    	}
    	return null;

    }

    public function publie_article($tab)
    {
      $requete='UPDATE article SET publie=1 WHERE id='.$tab['idArticle'];

      $result=$this->connexion ->query($requete);
      if ($result)
      {
        if ($result->rowCount()==1)
        {
          return ($result);
        }
      }
      return null;

    }

    public function connect($tab)
        {

        		$requete='select * from salarie where login="'.$tab['id'].'" and mp=MD5("'.$tab['mp'].'") and grade='.$tab['categ'].';';

        	$result=$this->connexion ->query($requete);
        	if ($result)
        	{
        		if ($result-> rowCount()==1)
        		{
        			return ($result);
        		}
        	}
        	return null;
        }

}
?>
