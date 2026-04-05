<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleSecteur extends Model
{
    protected $table = 'secteur'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOSECTEUR'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOSECTEUR', 'NOM'];
}