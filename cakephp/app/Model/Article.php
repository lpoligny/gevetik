<?php

class Article extends AppModel{
	
	public $name = 'Article';
	
	public $useTable = 'article';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasOne = array(
				'Evenement' => array(
								'className' => 'Evenement',
								),
				'Page_payee' => array(
								'className' => 'Page_payee',
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
				'nom_titre' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un titre pour cet article.",
											),
								),
				'resume' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier un résumé pour cet article.",
											),
								),
				'nombre_page' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nombre de page.",
											),
								'numeric' => array(
											'rule' => array('naturalNumber', false),
											'message' => "Le nombre de page doit être un nombre entier.",
											),
								),
				'extra_page' => array(
								'numeric' => array(
											'rule' => array('naturalNumber', true),
											'message' => "Le nombre de page supplémentaire doit être un nombre entier.",
											'allowEmpty' => true
											),
								),
				);
}

?>