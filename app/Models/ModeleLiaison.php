<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleLiaison extends Model
{
    protected $table = 'liaison'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOLIAISON'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOLIAISON', 'NOPORT_DEPART', 'NOSECTEUR', 'NOPORT_ARRIVEE', 'DISTANCE'];

    public function getLiaisons()
    {
        return $this->join('port', 'port.NOPORT = liaison.NOPORT_DEPART')
                    ->join('port as port2', 'port2.NOPORT = liaison.NOPORT_ARRIVEE')
                    ->join('secteur', 'secteur.NOSECTEUR = liaison.NOSECTEUR')
                    ->select('secteur.NOM as Nomsecteur, liaison.NOLIAISON, liaison.DISTANCE, port.NOM as PORT_DEPART, port2.NOM as PORT_ARRIVEE')
                    ->findAll();
        // exemple : Belle-Ile-en-Mer 15 8.3 Quiberon Le Palais
    }
}