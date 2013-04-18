<?php /** BENJAMIN RABILLER**/ ?>

<div class="users form">
<?php echo $this->Form->create('Participant');?>
<h1>Inscritpion pour l'evenement <?php echo $nom_evenement.' du '.$date_debut_evenement.' au '.$date_fin_evenement; ?></h1>
    <fieldset>
        <legend><?php echo __('Inscription participant'); ?></legend>
        <?php echo $this->Form->input('prenom_participant', array('label' => 'Prenom'));
			echo $this->Form->input('nom_participant', array('label' => 'Nom'));
			echo $this->Form->input('profession', array('label' => 'Profession'));
			echo $this->Form->input('email_participant', array('label' => 'Email'));
        		echo $this->Form->input('mot_de_passe', array('label' => 'Mot de passe', 'type' => 'password'));
			echo $this->Form->input('password_confirm', array('label' => 'Confirmation du mot de passe','type' => 'password'));

    ?>
    </fieldset>
<?php echo $this->Form->end(__('Valider'));?>
</div>
