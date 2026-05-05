<h2><?php echo $TitreDeLaPage ?></h2>
<?php
  if ($TitreDeLaPage=='Saisie incorrecte')
    echo service('validation')->listErrors();
 
  /* set_value : en cas de non validation, les données déjà saisies sont réinjectées dans le formulaire */
  echo form_open('modifiercompte');
  echo csrf_field();
  // ['NOM', 'PRENOM', 'ADRESSE', 'CODEPOSTAL', 'VILLE', 'TELEPHONEFIXE', 'TELEPHONEMOBILE', 'MEL', 'MOTDEPASSE']
    echo form_label('Nom','txtNOM') . "\t";
    echo form_input('txtNOM', set_value('txtNOM', session('nom')));
    echo '<br>';
    echo form_label('Prénom','txtPRENOM') . "\t";
    echo form_input('txtPRENOM', set_value('txtPRENOM', session('prenom')));
    echo '<br>';
    echo form_label('Adresse','txtADRESSE') . "\t";
    echo form_input('txtADRESSE', set_value('txtADRESSE', session('adresse')));
    echo '<br>';
    echo form_label('Code postal','txtCODEPOSTAL') . "\t";
    echo form_input('txtCODEPOSTAL', set_value('txtCODEPOSTAL', session('codepostal')));
    echo '<br>';
    echo form_label('Ville','txtVILLE') . "\t";
    echo form_input('txtVILLE', set_value('txtVILLE', session('ville')));
    echo '<br>';
    echo form_label('Téléphone fixe','txtTELEPHONEFIXE') . "\t";
    echo form_input('txtTELEPHONEFIXE', set_value('txtTELEPHONEFIXE', session('telephonefixe')));
    echo '<br>';
    echo form_label('Téléphone mobile','txtTELEPHONEMOBILE') . "\t";
    echo form_input('txtTELEPHONEMOBILE', set_value('txtTELEPHONEMOBILE', session('telephonemobile')));
    echo '<br>';
    echo form_label('MEL','txtMEL') . "\t";
    echo form_input('txtMEL', set_value('txtMEL', session('MEL')));
    echo '<br>';
    echo form_label('Mot de passe','txtMOTDEPASSE') . "\t";
    echo form_password('txtMOTDEPASSE', '');
    echo '<br>';

  echo form_submit('submit', 'Modifier mon compte');
  echo form_close();
?>