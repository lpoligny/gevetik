
<h4>Modifier l'article</h4>

<?php 
echo $this->Form->create('Article', array('type' => 'post')); 
	echo $this->Form->input('action', array(
									'type' => 'hidden',
									'value' => 'update',
									));
	echo $this->Form->input('article_id', array(
									'type' => 'hidden',
									'value' => $article['Article']['article_id'],
									));
	echo $this->Form->input('titre', array(
									'type' => 'text',
									'label' => "Titre de l'article",
									'default' => $article['Article']['titre'],
									));
	echo $this->Form->input('resume', array(
									'type' => 'textarea',
									'label' => "Résumé de l'article",
									'default' => $article['Article']['resume'],
									));
	echo $this->Form->input('nombre_page', array(
									'type' => 'text',
									'label' => "Nombre de pages",
									'default' => $article['Article']['nombre_page'],
									));
	echo $this->Form->input('keywords', array(
									'type' => 'text',
									'label' => "Mots-clés",
									'default' => $article['Article']['keywords'],
									));
echo $this->Form->end('Modifier');
?>

<h4>Associer l'article à des auteurs</h4>

<?php 
echo $this->Form->create('Page_payee', array('type' => 'post'));
	echo $this->Form->input('action', array(
									'type' => 'hidden',
									'value' => 'bind',
									));
	echo $this->Form->input('article_id', array(
									'type' => 'hidden',
									'value' => $article['Article']['article_id'],
									));
	$options = array('0' => '-');
	foreach($participants as $participant):
		$options[$participant['Participant']['participant_id']] = $participant['Participant']['nom_complet'];
	endforeach;
	
	echo $this->Form->input('auteur_id', array(
								'options' => $options,
								'label' => "Auteur",
								'default' => 0,
								));

if(!empty($auteurs)){
	?>
	<h4>Liste des auteurs</h4>
	<?php 
	echo $this->Form->create('Page_payee', array('type' => 'post'));
		echo $this->Form->input('action', array(
										'type' => 'hidden',
										'value' => 'unbind',
										));
		echo $this->Form->input('article_id', array(
										'type' => 'hidden',
										'value' => $article['Article']['article_id'],
										));
		?>
		<ul>
			<?php 
			foreach($auteurs as $auteur){
				echo '<li>'
					.$this->Form->label('unbind_'.$auteur['Participant']['participant_id'], $auteur['Participant']['nom_complet'])
					.$this->Form->checkbox('unbind_'.$auteur['Participant']['participant_id'], array(
																				'hiddenField' => false, 
																				'value' => $auteur['Participant']['participant_id']	))
				.'</li>';
			
			}
			?>
		</ul>
		<?php 
	echo $this->Form->end('Mettre à jour les contributeurs');
}
?>