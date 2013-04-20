<?php

	// Jonathan


	debug($infos);

	$options = array();

	foreach($infos as $i){
		$options[] = $i['Evenement']['nom_evenement'];
	}

	$res = "";

	$res .= $this -> Form -> input('Visualiser un évènement',array('options' => $options));

	$res .= $this -> Html -> link('Créer un nouvel évènement','/admins/nouvel_evenement');

	echo $res;
?>
