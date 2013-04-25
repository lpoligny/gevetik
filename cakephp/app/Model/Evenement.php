<?php

class Evenement extends AppModel{
	
	public $name = 'Evenement';
	
	public $useTable = 'evenement';
	
	public $primaryKey = 'evenement_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasMany = array(
				'Categorie' => array(
								'className' => 'Categorie',
								),
				'Article' => array(
								'className' => 'Article',
								),
				'Reservation' => array(
								'className' => 'Reservation',
								),
				'Organisateur' => array(
								'className' => 'Organisateur',
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
				'slug_evenement' => array(
								'unique' => array(
											'rule' => array('validSlug'),
											'message' => "Cette identifiant d'évènement est déjà utilisé.",
											),
								),
				'remise' => array(
								'value' => array(
											'rule' => array('numeric'),
											'message' => 'La remise doit être un nombre.',
											'allowEmpty' => true,
											),
								),
				'date_remise' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date limite pour la remise.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date limite valide pour avoir droit à la remise.",
											),
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date limite de remise ne peut se situer avant aujourd'hui.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date limite de remise ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_debut' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de début d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date de début d'évènement ne peut se situer avant aujourd'hui.",
											),
								),
				'date_fin' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date de fin d'évènement.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide pour cette évènement.",
											),
								'logic_calendar' => array(
											'rule' => array('validInterval'),
											'message' => "Votre date de fin d'évènement peut se situer avant la date de début de l'évenement.",
											),
								),
				'date_soumission_debut' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_date' => array(
											'rule' => array('validPlanning', 'today'),
											'message' => "Votre date ne peut se situer avant aujourd'hui.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_soumission_fin' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validSoumission'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_acceptation' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validPlanning'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				'date_acceptation_definitive' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier une date.",
											),
								'date' => array(
											'rule' => array('date'),
											'message' => "Vous devez spécifier une date valide.",
											),
								'logic_calendar' => array(
											'rule' => array('validAcceptation'),
											'message' => "Votre date ne peut se situer après la date de début de l'évenement.",
											),
								),
				);
	
	/*
	 *Méthodes de validation
	 */
	 

	/**
	 * Vérifie si un idenficateur d'évènement est unique en générant un identifiant à partir du nom de l'évènement.
	 */
	public function validSlug($check){
		if(empty($check['slug_evenement'])){
			$this->data['Evenement']['slug_evenement'] = $this->slugify($this->data['Evenement']['nom_evenement']);
			$check['slug_evenement'] = $this->data['Evenement']['slug_evenement'];
		}
		
		$evenement_id = (array_key_exists('evenement_id', $this->data['Evenement']))?$this->data['Evenement']['evenement_id'] :0;
		if($this->find('count', array('conditions' => array('evenement_id !='=> $evenement_id,
															'slug_evenement' => $check['slug_evenement'])))
															>0)
			return false;
		return true;
	}
	
	
	public function validPlanning($check_date, $date_start = ''){
		$date_debut_evenement = new DateTime($this->data['Evenement']['date_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		if(!empty($date_start) && !is_array($date_start)):
			$date_start = new DateTime($date_start);
			return ($date_start <= $check_date);
		endif;
		
		return ($check_date <= $date_debut_evenement);
	}
	
	public function validInterval($check_date){
		$date_debut_evenement = new DateTime($this->data['Evenement']['date_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_debut_evenement <= $check_date);
	}
	
	public function validSoumission($check_date){
		$date_soumission_debut = new DateTime($this->data['Evenement']['date_soumission_debut']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_soumission_debut <= $check_date);
	}

	public function validAcceptation($check_date){
		$date_soumission_debut = new DateTime($this->data['Evenement']['date_acceptation_definitive']);
		if(is_array($check_date))
			$check_date = current($check_date);
		$check_date = new DateTime($check_date);
		
		return ($date_soumission_debut <= $check_date);
	}
	
	public function beforeSave($options = array()){
		if(!array_key_exists('slug_evenement', $this->data['Evenement']) || empty($this->data['Evenement']['slug_evenement']))
			$this->data['Evenement']['slug_evenement'] = $this->slugify($this->data['Evenement']['nom_evenement']);
		
		$i = 1;
		$slug = $this->data['Evenement']['slug_evenement'];
		while(!$this->validSlug(array('slug_evenement' => $slug))){
			$slug = $this->data['Evenement']['slug_evenement'].$i;
			$i++;
		}
		
		$this->data['Evenement']['slug_evenement'] = $slug;
		return true;
	}

	
	/*
	 *Méthode du modèle
	 */
	public function creerEvenement($nom_evenement, $organisateur_id, $date_debut){
		$data = array(
			'nom_evenement' => $nom_evenement,
			'date_debut' => $date_debut,
			'date_fin' => $date_debut,
			'date_soumission_debut' => $date_debut,
			'date_soumission_fin' => $date_debut,
			'date_acceptation' => $date_debut,
			'date_acceptation_definitive' => $date_debut,
			'date_remise' => $date_debut,
			);
		$this->create();
		
		if(!$this->save($data))
			return false;
		
		$evenement_id = $this->getInsertID();
		
		$data = array(
				'participant_id' => $organisateur_id,
				'evenement_id' => $evenement_id,
				'est_organisateur' => 1,
				);
		//création de l'organisateur	
		$this->Organisateur->create();
		if(!$this->Organisateur->save($data)){
			$this->delete($evenement_id);
			return false;
		}
			
		//création de la catégorie Normal
		if(!$this->Categorie->creerCategorie($evenement_id, 'Normal')){
			$this->delete($evenement_id);
			return false;
		}
	
		return true;
	}
	
	public function getEvenement($evenement_idenfier){
	
		if(is_numeric($evenement_idenfier))
			$res = $this->find('first', array(
												'conditions' => array('Evenement.evenement_id' => $evenement_idenfier),
												));
		else
			$res = $this->find('first', array(
													'conditions' => array(
																	'OR' => array(
																		'Evenement.nom_evenement' => $evenement_idenfier,
																		'Evenement.slug_evenement' => $evenement_idenfier),
													)));
		
		//si l'évènement n'existe pas										
		if(!$res)
			return null;
		
		$res['Evenement']['parsed_description'] = $this->parseDescription($res['Evenement']);
		$res['Evenement']['parsable_fields'] = $this->getParsableFields();
		return $res;
	}
	
	public function slugify($str){
		//replacement basique
		$replace = array('ê', 'é', 'è', 'à', 'ç');
		$by = array('e', 'e', 'e', 'a', 'c');
		$slug = str_replace($replace, $by, $str);
		
		//remplacement par regex
		$pattern =  array('/@/', '#[/\s&\\\\]#', '/[^-_\d\w]/');
		$replace = array('_at_', '_', '');
		$slug = strtolower(preg_replace($pattern, $replace, $slug));
		
		return $slug;
	}
	
	public function getParsableFields(){
		return array(
				'nom_evenement' => "Nom de l'évènement",
				'adresse' => "Adresse de l'évènement",
				'date_debut' => "date de début de l'évènement",
				'date_fin' => "date de fin de l'évènement",
				// 'date_remise' => 'date_remise',
				);
	}
	
	public function parseDescription($evenement){
		$parsable_fields = $this->getParsableFields();
		
		$replace = array();
		$by = array();
		foreach($parsable_fields as $field => $desc){
			$replace[] =  '['.$field.']';
			$by[] = $evenement[$field];
		}
		
		return str_replace($replace, $by, $evenement['description']);
	}

}

?>
