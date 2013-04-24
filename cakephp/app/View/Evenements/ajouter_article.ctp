
<h4>Ajouter des articles</h4>

<?php 
echo $this->Form->create('Article', array('type' => 'post'));
	echo $this->Form->input('evenement_id', array(
									'type' => 'hidden',
									'value' => $evenement_id,
									));
	echo $this->Form->input('titre', array(
									'type' => 'text',
									'label' => "Titre de l'article",
									));
	echo $this->Form->input('resume', array(
									'type' => 'textarea',
									'label' => "Résumé de l'article",
									));
	echo $this->Form->input('nombre_page', array(
									'type' => 'text',
									'label' => "Nombre de pages",
									));
	echo $this->Form->input('keywords', array(
									'type' => 'text',
									'label' => "Mots-clés",
									));
echo $this->Form->end('Ajouter l\'article');
?>