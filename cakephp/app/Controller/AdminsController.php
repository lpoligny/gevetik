<?php
	class AdminsController extends AppController{
		function login(){
			if($this->request->is('post')){
				$sent = $this -> request -> data['Admins'];

				$data = $this -> Admin -> find('first',array(
										'conditions' => array(
											'login' => $sent['login'],
											'password' => Security::hash($sent['password'])
										)
									)
				);

				// A ameliorer !
				$this -> logout();

				if($this->Auth->login($data)){
					$this -> redirect(array('action' => 'nouvel_evenement'));
				}
				else{
					$this -> Session -> setFlash(__('Login ou mot de passe incorrect.'));
				}
			}
		}

		function logout(){
			$this -> Auth -> logout();
		}

		function modifier_evenement(){
			$this -> loadModel('Organisateur');
			$data = $this -> Organisateur -> find('all');

			$this -> set('infos',$data);
		}

		function nouvel_evenement(){

		}

		function confirmer_ajout_conf(){
			if($this -> request -> is('post')){
				$sent = $this -> request -> data['ajout_conf'];

				$this -> loadModel('Evenement');

				$this -> Evenement -> save($sent);

				$this -> set('infos','L\'évènement à bien été ajouté');
			}
			else{
				$this -> set('infos','Aucune donnée envoyée');
			}
		}

		function index(){
			$this -> loadModel('Evenement');
			$data = $this -> Evenement -> find('all');

			$this -> set('infos',$data);
		}
	}
?>
