<?php

	// Jonathan

	//debug($infos);

	$res = "";

	$res .= $this -> Form -> create('ajout_conf',array('url' => '/admins/confirmer_ajout_conf'));

	$res .= $this -> Form -> input('nom_evenement',array('label' => 'Nom du nouvel évènement'));

	$res .= $this -> Form -> input('description',array('type' => 'textarea','label' => 'Description du nouvel évènement'));



	$res .= '<div class="bloc_orga">';
	$res .= "<table>";
	$res .= $this -> Html -> tableHeaders(array('Organisateur','Ajouter'));
	
	$cells = array();

	foreach($infos as $cle => $valeur){

		$participant = $valeur['Participant'];
		$nom = $participant['prenom_participant'].' '.$participant['nom_participant'];
		$checkbox = $this -> Form ->checkbox($participant['participant_id']);

		$cells[] = array($nom,$checkbox);
	}

	$res .= $this -> Html -> tableCells($cells);

	$res .= '</table>';
	$res .= '</div>';



	$res .= $this -> Form -> input('date_debut',array('type' => 'date','label' => 'Date de début de l\'évènement', 'dateFormat' => 'Y-M-D', 'minYear' => date('Y')));

	$res .= $this -> Form -> input('date_fin',array('type' => 'date','label' => 'Date de fin de l\'évènement', 'dateFormat' => 'Y-M-D', 'minYear' => date('Y')));

	$res .= $this -> Form -> button('Enregistrer le nouvel évènement',array('type' => 'submit'));

	$res .= $this -> Html -> link('Revenir à l\'index','/admins/index');

	echo $res;
?>
