<?php

	// Jonathan


	//debug($infos);

	$options = array();

	foreach($infos as $i){
		$options[$i['Evenement']['evenement_id']] = $i['Evenement']['nom_evenement'];
	}

	$res = "";

	$res .= $this -> Form -> create('select_evt',array('url' => 'modifier_orga_evenement'));

	$res .= $this -> Form -> select('id_evt',$options);

	$res .= $this -> Form -> button('Valider',array('type' => 'submit'));

	$res .= $this -> Html -> link('Créer un nouvel évènement','/admins/nouvel_evenement');

	echo $res;
?>
