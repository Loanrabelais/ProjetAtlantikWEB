<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleType extends Model
{
    protected $table = 'type'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOTYPE'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['LETTRECATEGORIE', 'NOTYPE', 'LIBELLE'];
}