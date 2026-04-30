<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleReservation extends Model
{
    protected $table = 'reservation'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NORESERVATION'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOTRAVERSEE', 'NOCLIENT', 'DATEHEURE', 'MONTANTTOTAL', 'PAYE', 'MODEREGLEMENT'];
}
