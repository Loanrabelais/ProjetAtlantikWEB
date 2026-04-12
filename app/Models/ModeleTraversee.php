<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleTraversee extends Model
{
    protected $table = 'traversee'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOTRAVERSEE'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOLIAISON', 'NOBATEAU', 'DATEHEUREDEPART', 'DATEHEUREARRIVEE', 'CLOTUREEMBARQUEMENT'];

    public function getLesTraverseesBateaux($noLiaison, $periode = null)
    {
        if ($periode != null)
        {
        return $this->join('bateau', 'bateau.NOBATEAU = traversee.NOBATEAU')
            ->select('traversee.NOTRAVERSEE, traversee.DATEHEUREDEPART, bateau.NOM AS NOMBATEAU')
            ->where('NOLIAISON', (int)$noLiaison)
            ->where('DATEHEUREDEPART >=', $periode->DATEDEBUT)
            ->where('DATEHEUREDEPART <=', $periode->DATEFIN)
            ->get()->getResult();
        }
        else{
            return $this->join('bateau', 'bateau.NOBATEAU = traversee.NOBATEAU')
            ->select('traversee.NOTRAVERSEE, traversee.DATEHEUREDEPART, bateau.NOM AS NOMBATEAU')
            ->where('NOLIAISON', (int)$noLiaison)
            ->get()->getResult();
        }
    }

    public function getCapaciteMaximale($noTraversee, $lettreCategorie): int
    {
        $ligne = $this->join('bateau', 'bateau.NOBATEAU = traversee.NOBATEAU')
            ->join('contenir', 'contenir.NOBATEAU = bateau.NOBATEAU')
            ->join('categorie', 'categorie.LETTRECATEGORIE = contenir.LETTRECATEGORIE')
            ->select('contenir.CAPACITEMAX')
            ->where('traversee.NOTRAVERSEE', $noTraversee)
            ->where('categorie.LETTRECATEGORIE', $lettreCategorie)
            ->first();

        return (int) $ligne->CAPACITEMAX;
    }

    public function getQuantiteEnregistree($noTraversee, $lettreCategorie): int
    {
        $ligne = $this->join('reservation', 'reservation.NOTRAVERSEE = traversee.NOTRAVERSEE')
            ->join('enregistrer', 'enregistrer.NORESERVATION = reservation.NORESERVATION')
            ->select('SUM(enregistrer.QUANTITERESERVEE) AS total')
            ->where('traversee.NOTRAVERSEE', (int)$noTraversee)
            ->where('enregistrer.LETTRECATEGORIE', $lettreCategorie)
            ->first();

        return (int) $ligne->total;
    }
}