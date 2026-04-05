<h2><?php echo $TitreDeLaPage ?></h2>
<?php
  if ($TitreDeLaPage=='Saisie incorrecte')
    echo service('validation')->listErrors();
 
  /* set_value : en cas de non validation, les données déjà saisies sont réinjectées dans le formulaire */
  echo form_open('creercompte');
  echo csrf_field();
  // ['NOM', 'PRENOM', 'ADRESSE', 'CODEPOSTAL', 'VILLE', 'TELEPHONEFIXE', 'TELEPHONEMOBILE', 'MEL', 'MOTDEPASSE']
    echo form_label('Nom','txtNOM') . "\t";
    echo form_input('txtNOM', set_value('txtNOM'));
    echo '<br>';
    echo form_label('Prénom','txtPRENOM') . "\t";
    echo form_input('txtPRENOM', set_value('txtPRENOM'));
    echo '<br>';
    echo form_label('Adresse','txtADRESSE') . "\t";
    echo form_input('txtADRESSE', set_value('txtADRESSE'));
    echo '<br>';
    echo form_label('Code postal','txtCODEPOSTAL') . "\t";
    echo form_input('txtCODEPOSTAL', set_value('txtCODEPOSTAL'));
    echo '<br>';
    echo form_label('Ville','txtVILLE') . "\t";
    echo form_input('txtVILLE', set_value('txtVILLE'));
    echo '<br>';
    echo form_label('Téléphone fixe','txtTELEPHONEFIXE') . "\t";
    echo form_input('txtTELEPHONEFIXE', set_value('txtTELEPHONEFIXE'));
    echo '<br>';
    echo form_label('Téléphone mobile','txtTELEPHONEMOBILE') . "\t";
    echo form_input('txtTELEPHONEMOBILE', set_value('txtTELEPHONEMOBILE'));
    echo '<br>';
    echo form_label('MEL','txtMEL') . "\t";
    echo form_input('txtMEL', set_value('txtMEL'));
    echo '<br>';
    echo form_label('Mot de passe','txtMOTDEPASSE') . "\t";
    echo form_password('txtMOTDEPASSE', set_value('txtMOTDEPASSE'));
    echo '<br>';

  echo form_submit('submit', 'Créer un compte');
  echo form_close();
?>