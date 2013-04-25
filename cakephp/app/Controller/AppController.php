<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $components = array('Auth' => array('authorize' => 'Controller'),'Session');
	
	function beforeFilter(){
		parent::beforeFilter();
	
		//allow page de connexion participant/admin/finance
		//allow page accueil + page accueil d'event
		if(!$this->Auth->loggedIn())
			$this->isAuthorized();
	}
	
	
	public function isAuthorized($user = null) {
		if($user==null)
			$user = array(
					'groupe' => 'unknown',
					'participant_id' => 0,
					'id' => 0,
					);
		$controller = $this->request->params['controller'];
		$action = $this->request->params['action'];
		
		switch($controller){
			/* Gestion de la permission des évènements traités dans EvenementsController */
			case 'admins':
				if($user['groupe']!='admin')
					throw new ForbiddenException("Vous n'êtes pas autorisé à accéder à cette section.");
				break;
			case 'gestionnaireFinances':
				if($user['groupe']!='finance')
					throw new ForbiddenException("Vous n'êtes pas autorisé à accéder à cette section.");
				break;
		}
	
        return true;
    }
	
	public function initializeLogin(){
		if(!$this->Auth->loggedIn())
			return false;
		
		//on détermine le groupe de l'utilisateur : admin|finance|participant
		$this->loadModel('Participant');
		$user = $this->Participant->find('first', array('conditions' => array('email_participant' => $this->Auth->user('username'))));
		if(!$user){
			$this->loadModel('GestionnaireFinance');
			$user = $this->GestionnaireFinance->find('first', array('conditions' => array('login' => $this->Auth->user('username'))));
			
			if(!$user)
				return false;
				
			//l'utilisateur appartient au groupe finance
			$this->Session->write('Auth.User.groupe', 'finance');
			$this->Session->write('Auth.User.id', $user['GestionnaireFinance']['id']);
		}
		else{
		//c'est un participant
			$this->Session->write('Auth.User.groupe', 'participant');
			$this->Session->write('Auth.User.id', $user['Participant']['participant_id']);
			$this->Session->write('Auth.User.participant_id', $user['Participant']['participant_id']);
		}
		
		return true;
	}
	
}
