<?php

class Paiement extends AppModel{
	
	public $name = 'Paiement';
	
	public $useTable = 'paiement';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Auteur' => array(
								'className' => 'Auteur',
								),
				'Reservation' => array(
								'className' => 'Reservation',
								),
				);
	
	public $hasAndBelongsToMany = array(
				'Option' => array(
								'className' => 'Option',
								'joinTable' => 'Option_paiement',
								),
				);
	

				
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
	
	/**
	 * Définition des règles de validation du modèle
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 */
	public $validate = array(
				'total' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'Le total doit être un nombre.',
											'allowEmpty' => true,
											),
								),
				'type' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'La remise doit être un nombre.',
											'allowEmpty' => true,
											),
								),
				'validation' => array(
								'boolean' => array(
											'rule' => array('boolean'),
											'message' => "Vous devez spécifier si le paiement est validé.",
											),
								'allowEmpty' => true,
								),
				);
	
	
	public function beforeSave(){
		if(empty($this->data['Paiement']['validation']))
			$this->data['Paiement']['validation'] = false;
		
		return true;
	}
}

?>