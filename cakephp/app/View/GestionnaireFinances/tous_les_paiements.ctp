<?php
	//debug($infos);
	$res = $this -> Form -> create('ValiderPaiements',array('url' => '/gestionnaireFinances/maj_paiements'));

	$res .= "<table>";

	$res .= $this -> Html -> tableHeaders(array('R&eacute;f&eacute;rence','Montant','Valid&eacute;'));

	foreach($infos as $ligne){

		$checked = ($ligne['Paiement']['validation'] == 1) ? true : false ;
		$data = $ligne['Paiement'];
		$checkbox = $this -> Form ->checkbox($data['paiement_id'],array('checked' => $checked));

		$res .= $this -> Html -> tableCells(array($data['reference_paiement'],$data['total'],$checkbox));

	}

	$res .= "</table>";

	$res .= $this -> Form -> button('Valider les changements',array('type' => 'submit'));

	echo $res;
?>
