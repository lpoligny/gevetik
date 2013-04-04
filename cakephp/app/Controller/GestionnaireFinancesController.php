<?php



	// Jonathan


	class GestionnaireFinancesController extends AppController{

		function login(){
			if($this->request->is('post')){
				$sent = $this -> request -> data['GestionnaireFinances'];

				$data = $this -> GestionnaireFinance -> find('first',array(
										'conditions' => array(
											'login' => $sent['login'],
											'password' => Security::hash($sent['password'])
										)
									)
				);

				// A ameliorer !
				$this -> logout();

				if($this->Auth->login($data)){
					$this -> redirect(array('action' => 'paiements_en_attente'));
				}
				else{
					$this -> Session -> setFlash(__('Login ou mot de passe incorrect.'));
				}
			}
		}

		function paiements_en_attente(){

			$this -> loadModel('Reservation');

			$data = $this -> Reservation -> find('all',array('conditions' => array('Paiement.validation' => 0)));

			$this -> set('infos',$data);
		}

		function tous_les_paiements(){

			$this -> loadModel('Reservation');

			$data = $this -> Reservation -> find('all');

			$this -> set('infos',$data);
		}

		function inscrire(){
			if($this->request->is('post')){
				$data = $this -> request -> data['GestionnaireFinances'];
				$data['password'] = Security::hash($data['password']);

				$this -> GestionnaireFinance -> save($data);
			}
		}

		function maj_paiements(){
			if($this -> request ->is('post') && !empty($this -> request -> data['ValiderPaiements'])){
				//$this -> set('infos',$this -> request -> data);

				$data = $this -> request -> data['ValiderPaiements'];
				$this -> loadModel('Paiement');

				foreach($data as $id => $valeur){

					$save['paiement_id'] = $id;
					$save['validation'] = $valeur;
	
					$this -> Paiement -> save($save);	
				}

				$this -> set('infos','Mises à jour effectuées');
			}
			else{
				$this -> set('infos','Aucune donnée envoyée !');
			}
		}

		function logout(){
			$this -> Auth -> logout();
		}
	}
?>
