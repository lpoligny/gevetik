<?php

class Option extends AppModel{
	
	public $name = 'Option';
	
	public $useTable = 'option';
	
	public $primaryKey = 'option_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $belongsTo = array(
				'Categorie' => array(
								'className' => 'Categorie',
								),
				);
	
	public $hasMany = array(
				'Option_paiement' => array(
								'className' => 'Option_paiement',
								)
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
				'nom_option' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un nom pour cette option.",
											),
								),
				'quantite_minimum' => array(
								'value' => array(
											'rule' => array('naturalNumber', true),
											'message' => 'La quantité minimum doit être un nombre entier.',
											'allowEmpty' => true,
											),
								),
				'quantite_maximum' => array(
								'value' => array(
											'rule' => array('naturalNumber', false),
											'message' => 'La quantité maximum doit être un nombre entier.',
											'allowEmpty' => true,
											),
								),
				'prix_unitaire' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un prix pour cette option.",
											),
								'value' => array(
											'rule' => array('numeric'),
											'message' => "Le prix unitaire doit être un nombre.",
											),
								),
				);
	
	
	public function beforeSave(){
		//ajout des valeurs par défaut
		if(empty($this->data['Option']['quantite_minimum']))
			$this->data['Option']['quantite_minimum'] = 0;

		if(empty($this->data['Option']['quantite_maximum']))
			$this->data['Option']['quantite_maximum'] = $this->data['Option']['quantite_minimum'];
		
		//vérification de la validiter des valeurs
		if($this->data['Option']['quantite_minimum']>$this->data['Option']['quantite_maximum'])
			return false;
		
		return true;
	}
	
	public function getOptions($categorie_id){
		$options = $this->find('all', array(
										'conditions' => array('Option.categorie_id' => $categorie_id)
										));
		return $options;
	}
}

?>