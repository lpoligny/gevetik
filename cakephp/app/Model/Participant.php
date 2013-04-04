<?php
/** BENJAMIN RABILLER**/
class Participant extends AppModel{

	public $name = 'Participant';
	
	public $useTable = 'participant';
	
	public $primaryKey = 'participant_id';
	
	public $displayField = 'nom_complet';
	
	public $virtualFields = array(
				'nom_complet' => "CONCAT(Participant.nom_participant, ' ', Participant.prenom_participant)",
				);
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $hasMany = array(
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
				'prenom_participant' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le prénom pour ce participant.",
											),
								/*'char' => array(
											'rule' => array('char'),
											'message' => "Le prénom du participant ne peut contenir que des caractères.",
											),*/
								),
				'nom_participant' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le nom du participant.",
											),
								/*'char' => array(
											'rule' => array('char'),
											'message' => "Le nom du participant ne peut contenir que des caractères.",
											),*/
								),
				'email_participant' => array(
								'email' => array(
											'rule' => array('email'),
											'message' => "L'email de l'organisateur est invalide.",
											),
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le email pour cet organisateur.",
											),
								'unique' => array(
											'rule' => array('isUnique'),
											'message' => "Il existe déjà un participant avec cet email.",
											),
								),
				'mot_de_passe' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier le mot de passe pour ce participant.",
											),
								'minLength' => array(
										  'rule' => array('minLength', '8'),
										  'message' => 'Le mot de passe doit être égal ou supérieur à 8 caractères.',
											),
								),
				 'password_confirm' => array(
								 'rule' => array('checkPasswords'), //checkPassords définie ci-dessous
								 'message' => 'Le mot de passe entré ne correspond pas au mot de passe de confirmation'
				 ),
				'profession' => array(
								'required' => array(
											'rule' => array('notEmpty'),
											'message' => "Vous devez spécifier la profession pour ce participant.",
											),
								),
				);
	
	/**
	 * méthode de vérification : Elle vérifie si check est composé de caractères (caractères accentués compris).
	 * /!\ Cette méthode est une copie du modèle Organisateur.
	 */
	public function char($check){
		//return preg_match('#^[^\d[:space:][:punct:]_-]*$#', $check); tester si alpha prends les caractères accentués.
		return preg_match('#^[[:alpha:]]*$#', $check);
	}

	public function beforeSave($options = array('')) {
	    if (isset($this->data[$this->alias]['mot_de_passe'])) {
		   $this->data[$this->alias]['mot_de_passe'] = AuthComponent::password($this->data[$this->alias]['mot_de_passe']);
	    }
	    return true;
	}
	/**
	*  Methode de vérification : Elle compare le mot de passe entré dans le formulaire à celui du champ du mot de passe de confirmation
	*  
	**/
	function checkPasswords($data) {
		   if($this->data['Participant']['mot_de_passe'] !== $data['password_confirm']) {
		       return false;
		   }else {
		       return true;
		   }
	}
}

?>
