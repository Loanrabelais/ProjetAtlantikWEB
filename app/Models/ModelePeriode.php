<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModelePeriode extends Model
{
    protected $table = 'periode'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOPERIODE'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOPERIODE', 'DATEDEBUT', 'DATEFIN'];
} 