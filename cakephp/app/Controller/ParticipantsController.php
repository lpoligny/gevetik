<?php
/** BENJAMIN RABILLER
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');

class ParticipantsController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Participants';
	public $participantID = 0;
	//public $helpers = array('Html', 'Form');
	
	public $uses = array();
	
	public $donneeParticipant = '';
	public $nomParticipant = '';

	function beforeFilter(){
		parent::beforeFilter();
		
		$params = $this->params->params;
		if(array_key_exists('nom_participant', $params)){
			$this->nomParticipant = $this->params['nom_participant'];
			
			$res = $this->Participant->find('first', array(
													'conditions' => array('Participant.nom_participant' => $this->nomParticipant),
													));
			$this->donneeParticipant = $res;
			$this->participantID = $res['Participant']['participant_id'];
		}
	}
	
	
	public function index() {

	}

}
