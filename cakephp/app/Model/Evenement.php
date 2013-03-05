<?php

class Evenement extends AppModel{
	
	public $name = 'Evenement';
	
	public $useTable = 'evenement';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Organisateur' => array(
								'className' => 'Organisateur',
								),
				
				);
	
	public $hasMany = array(
				'Categorie' => array(
								'className' => 'Categorie',
								'order' => 'Evenement.date_creation DESC',
								'limit' => 10,
								
				'Article' => array(
								'className' => 'Article',
								),
				);
	
	public $hasAndBelongsToMany = array(
				'Participant' => array(
								'className' => 'Participant',
								'joinTable' => 'Reservation',
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
				'nom_evenement' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un nom pour cet évènement.",
											),
								),
				'remise' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'La remise doit être un nombre.',
											'allowEmpty' => true,
											),
								),
				'date_evenement' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								),
				);
	
	
	public function beforeSave(){
		$date_creation = new Date($this->data['Evenement']['date_creation']);
		$date_evenement = new Date($this->data['Evenement']['date_evenement']);
		
		
		if($date_evenement<=$date_creation)
			return false;
		
		return true;
	}
}

?>