<?php

class Categorie extends AppModel{
	
	public $name = 'Categorie';
	
	public $useTable = 'categorie';
	
	public $primaryKey = 'categorie_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Evenement' => array(
								'className' => 'Evenement',
								),
				);
				
	public $hasMany = array(
				'Option' => array(
								'className' => 'Option',
								),
				);
				
	/**
	 * Définition du comportement du modèle
	 * http://book.cakephp.org/2.0/en/models/behaviors.html
	 */
	//public $actAs;
	
	
	/**
	 // * Définition des règles de validation du modèle
	 * http://book.cakephp.org/2.0/en/models/data-validation.html
	 */
	public $validate = array(
				'nom_categorie' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un nom pour cette catégorie.",
											),
								),
				);
	
	public function creerCategorie($evenement_id, $nom_categorie){
		
		$data = array(
				'evenement_id' => $evenement_id,
				'nom_categorie' => $nom_categorie,
				);
		$this->create();
		if(!$this->save($data))
			return false;
			
		//création de l'option entrée
		$data = array(
				'categorie_id' => $this->getInsertID(),
				'nom_option' => 'Entrée',
				'prix_unitaire' => 0,
				'quantite_maximum' => 0,
				'quantite_minimum' => 0,
				);
				
		$this->Option->create();
		return $this->Option->save($data);
	}
	
}

?>