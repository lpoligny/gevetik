<?php

	// Jonathan

	debug($infos);
	//debug($evt_id);
	debug($deja);


	$diff = array();
	foreach($infos as $cle => $valeur){
		foreach($deja as $cled => $valeurd){
			if($valeur['Organisateur']['participant_id'] == $valeurd['Organisateur']['participant_id']){
				$diff[] = $valeur['Organisateur']['participant_id'];
			}
		}
	}

	$res = "";



	/*
		INFOS DE BASE SUR L'EVENT (nom, date de début, de fin, visibilité)
	*/
	$res .= "<div class=\"bloc_infos\"> ";

	$res .= $evenement['Evenement']['nom_evenement']." - Du ".$evenement['Evenement']['date_debut']." au ".$evenement['Evenement']['date_fin']."<br/>";

	$res .= $this -> Form -> create('visible',array('url' => 'modifier_visibilite'));

	$res .= $this -> Form -> input('evenement_id',array("type" => 'hidden','value' => $evenement['Evenement']['evenement_id']));

	$checked = $evenement['Evenement']['visible'];

	$res .= $this -> Form -> input('visible',array('type' => 'checkbox','label' => "Visible",'checked' => $checked));

	$res .= $this -> Form -> button('Valider',array('type' => 'submit'));

	$res .= $this -> Form -> end();

	$res .= "</div> <br/>";





	/*
		AFFECTER DES ORGANISATEURS A L'EVENEMENT
	*/
	$res .= "<div class=\"bloc_orga\">";

	$res .= $this -> Form -> create('gerer_orga',array('url' => 'gerer_organisateurs'));

	$res .= $this -> Form -> input('evenement_id',array("type" => 'hidden','value' => $evenement['Evenement']['evenement_id']));

	$res .= "<table>";

	$res .= $this -> Html -> tableHeaders(array('Organisateur','Mail','Ajouter'));

	$cells = array();

	foreach ($infos as $cle => $valeur){
		$participant = $valeur['Participant'];
		$nom = $participant['prenom_participant'].' '.$participant['nom_participant'];

		$checked = (in_array($participant['participant_id'],$diff)) ? true : false;
		$checkbox = $this -> Form ->checkbox($valeur['Participant']['participant_id'],array('checked' => $checked));

		$cells[] = array($nom,$participant['email_participant'],$checkbox);
	}

	$res .= $this -> Html -> tableCells($cells);

	$res .= "</table>";

	$res .= $this -> Form -> button('Valider',array('type' => 'submit'));

	$res .= $this -> Form -> end();

	$res .= "</div>";





	/*
		BLOC NOUVEL ORGANISATEUR
	*/
	/*$res .= "<div class=\"bloc_ajout_orga\">";

	$res .= $this -> Form -> create('nv_orga',array('url' => 'admins/ajout_orga'));

	$res .= $this -> Form -> input('nom_nv_orga',array('label' => "Nom du nouvel organisateur"));

	$res .= $this -> Form -> input('email_nv_orga',array('label' => "Email du nouvel organisateur"));

	$res .= $this -> Form -> button('Créer le nouvel organisateur',array('type' => 'submit'));

	$res .= "</div>";*/



	echo $res;
?>
