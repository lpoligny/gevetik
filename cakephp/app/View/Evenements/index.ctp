<?php /** BENJAMIN RABILLER**/ ?>

<h1>Accueil de l'evenement : <?php echo $nom_evenement.' du '.$date_debut_evenement.' au '.$date_fin_evenement; ?></h1>
<div class="users form">
<?php echo $this->Form->create('Participant');?>
    <fieldset>
			<?php echo $this->Form->input('email_participant', array('label' => 'Email'));
        		echo $this->Form->input('mot_de_passe', array('label' => 'Mot de passe', 'type' => 'password'));

    ?>
    </fieldset>
<?php echo $this->Form->end(__('Connexion'));?>
</div>
