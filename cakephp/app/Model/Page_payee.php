<?php

class Page_payee extends AppModel{
	
	public $name = 'Page_payee';
	
	public $useTable = 'page_payee';
	
	public $primaryKey = 'page_payee_id';
	
	/**
	 * Définition des liens entre les modèles
	 * http://book.cakephp.org/2.0/en/models/associations-linking-models-together.html
	 */
	public $belongsTo = array(
						'Article' => array(
							'className' => 'Article',
							),
						'Participant' => array(
							'className' => 'Participant',
							'foreignKey' => 'auteur_id',
							),
						'Paiement' => array(
								'className' => 'Paiement',
								'foreignKey' => 'paiement_id',
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

	public function payer($page_payee_id, $extra_a_payer, $type_paiement, $reference_paiement = ''){
		if($extra_a_payer<=0)
			return true;
		
		App::uses('Paiement', 'Model');		
		$Paiement = new Paiement();
		$data = array(
				'extra_page_payee' => $extra_a_payer,
				);
		$payeur = $this->find('first', array('conditions' => array('Page_payee.page_payee_id' => $page_payee_id)));
		$paiement_id = $payeur['Page_payee']['paiement_id'];
		
		$data = array(
				'reference_paiement' => $reference_paiement,
				'type' => $type_paiement,
				'total' => $extra_a_payer*100,
				);
		if($paiement_id==0){
			$data['page_payee_id'] = $page_payee_id;
			if(empty($reference_paiement))
				$reference_paiement = uniqid();
				
			$Paiement->create();
			if(!$Paiement->save($data))
				return false;
			$paiement_id = $Paiement->getInsertID();
		}
		else{
			$data['total']+= $payeur['Paiement']['total'];
			$data['validation'] = 0;
			
			$Paiement->id = $paiement_id;
			if(!$Paiement->save($data))
				return false;
		}
		
		$data = array(
				'paiement_id' => $paiement_id,
				'extra_page_payee' => $extra_a_payer+$payeur['Page_payee']['extra_page_payee'],
				);
		$this->id = $page_payee_id;
		if(!$this->save($data)){
			if($payeur['Page_payee']['paiement_id']==0):
				$Paiement->delete($paiement_id);
			else:
				$Paiement->id = $paiement_id;
				$Paiement->save($payeur['Page_payee']);
			endif;
			return false;
		}
		return true;
	}
}

?>