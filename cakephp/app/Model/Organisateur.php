<?php

class Organisateur extends AppModel{
	
	public $name = 'Organisateur';
	
	public $useTable = 'organisateur';
	
	public $primaryKey = 'organisateur_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $belongsTo = array(
				'Participant' => array(
								'className' => 'Participant',
								),
				'Evenement' => array(
								'className' => 'Evenement',
								),
				);
				
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
	
	public function getOrganisateurs($evenement_id){
		$res = $this->find('all', array(
									'conditions' => array('Organisateur.evenement_id' => $evenement_id)
									));
		
		return $res;
	}
}

?>