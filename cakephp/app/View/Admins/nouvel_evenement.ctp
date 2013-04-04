<?php
	//debug($infos);

	$res = "";

	$res .= $this -> Form -> create('ajout_conf',array('url' => '/admins/confirmer_ajout_conf'));

	$res .= $this -> Form -> input('nom_evenement',array('label' => 'Nom du nouvel évènement'));

	$res .= $this -> Form -> input('description',array('type' => 'textarea','label' => 'Description du nouvel évènement'));

	$res .= $this -> Form -> input('date_debut',array('type' => 'date','label' => 'Date de début de l\'évènement', 'dateFormat' => 'Y-M-D', 'minYear' => date('Y')));

	$res .= $this -> Form -> input('date_fin',array('type' => 'date','label' => 'Date de fin de l\'évènement', 'dateFormat' => 'Y-M-D', 'minYear' => date('Y')));

	$res .= $this -> Form -> button('Enregistrer le nouvel évènement',array('type' => 'submit'));

	echo $res;
?>
