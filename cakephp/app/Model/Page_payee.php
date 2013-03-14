<?php

class Page_payee extends AppModel{
	
	public $name = 'Page_payee';
	
	public $useTable = 'page_payee';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Article' => array(
								'className' => 'Article',
								),
				'Auteur' => array(
								'className' => 'Auteur',
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
				'extra_page_payee' => array(
								'natural' => array(
											'rule' => array('naturalNumber', true),
											'message' => 'Le nombre de page payée doit être un nombre entier.',
											'allowEmpty' => true,
											),
								),
				);
}

?>