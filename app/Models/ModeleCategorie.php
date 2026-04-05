<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleCategorie extends Model
{
    protected $table = 'categorie'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOTYPE'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['LETTRECATEGORIE','LIBELLE'];
}