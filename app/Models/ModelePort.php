<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModelePort extends Model
{
    protected $table = 'port'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOPORT'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOPORT', 'NOM'];
}