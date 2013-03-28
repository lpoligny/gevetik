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
	
	
}

?>