<?php

	// Jonathan

	//debug($infos);

	$res = "";



	/*
		INFOS DE BASE SUR L'EVENT (nom, date de début, de fin, visibilité)
	*/
	$res .= "<div class=\"bloc_infos\"> ";

	$res .= $infos[0]['Evenement']['nom_evenement']." - Du ".$infos[0]['Evenement']['date_debut']." au ".$infos[0]['Evenement']['date_fin']."<br/>";

	$res .= $this -> Form -> input('visible_'.$infos[0]['Evenement']['evenement_id'],array('type' => 'checkbox','label' => "Visible"));

	$res .= "</div> <br/>";





	/*
		AFFECTER DES ORGANISATEURS A L'EVENEMENT
	*/
	$res .= "<div class=\"bloc_orga\">";

	$res .= "<table>";

	$res .= $this -> Html -> tableHeaders(array('Organisateur','Mail'));

	foreach ($infos as $i){
		$data = $i['Participant'];
		$checkbox = $this -> Form ->checkbox('ajouter_orga_'.$i['Organisateur']['organisateur_id']);
		$res .= $this -> Html -> tableCells(array($data['nom_complet'],$data['email_participant'],$checkbox));
	}

	$res .= "</table>";

	$res .= "</div>";





	/*
		BLOC NOUVEL ORGANISATEUR
	*/
	$res .= "<div class=\"bloc_ajout_orga\">";

	$res .= $this -> Form -> create('nv_orga',array('url' => 'admins/ajout_orga'));

	$res .= $this -> Form -> input('nom_nv_orga',array('label' => "Nom du nouvel organisateur"));

	$res .= $this -> Form -> input('email_nv_orga',array('label' => "Email du nouvel organisateur"));

	$res .= $this -> Form -> button('Créer le nouvel organisateur',array('type' => 'submit'));

	$res .= "</div>";



	echo $res;
?>
