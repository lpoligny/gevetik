<?php

	// Jonathan

	debug($infos);
	//debug($evt_id);

	$res = "";



	/*
		INFOS DE BASE SUR L'EVENT (nom, date de début, de fin, visibilité)
	*/
	$res .= "<div class=\"bloc_infos\"> ";

	$res .= $infos['Evenement']['nom_evenement']." - Du ".$infos['Evenement']['date_debut']." au ".$infos['Evenement']['date_fin']."<br/>";

	$res .= $this -> Form -> create('visible',array('url' => 'modifier_visibilite'));

	$res .= $this -> Form -> input('evenement_id',array("type" => 'hidden','value' => $evt_id['id_evt']));

	$checked = $infos['Evenement']['visible'];

	$res .= $this -> Form -> input('visible',array('type' => 'checkbox','label' => "Visible",'checked' => $checked));

	$res .= $this -> Form -> button('Valider',array('type' => 'submit'));

	$res .= $this -> Form -> end();

	$res .= "</div> <br/>";





	/*
		AFFECTER DES ORGANISATEURS A L'EVENEMENT
	*/
	$res .= "<div class=\"bloc_orga\">";

	$res .= $this -> Form -> create('gerer_orga',array('url' => 'gerer_organisateurs'));

	$res .= $this -> Form -> input('evenement_id',array("type" => 'hidden','value' => $evt_id['id_evt']));

	$res .= "<table>";

	$res .= $this -> Html -> tableHeaders(array('Organisateur','Mail'));

	foreach ($infos as $i){
		$data = $i['Participant'];
		$checkbox = $this -> Form ->checkbox('gerer_orga_'.$i['Organisateur']['organisateur_id']);
		$res .= $this -> Html -> tableCells(array($data['nom_complet'],$data['email_participant'],$checkbox));
	}

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
