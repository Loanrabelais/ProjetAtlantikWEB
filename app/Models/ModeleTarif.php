<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleTarif extends Model
{
    protected $table = 'tarifer'; // nom de la table mappée
    /* ci-dessus on indique la table a 'mapper' */
    protected $primaryKey = 'NOTARIF'; // clé primaire
    protected $returnType = 'object'; // résultats retournés sous forme d'objet(s)
 
    protected $allowedFields = ['NOPERIODE', 'LETTRECATEGORIE', 'NOTYPE', 'NOLIAISON', 'PRIX'];

    public function getTarifsPourUnTypeEtUnePeriode($NOLIAISON, $NOPERIODE, $LETTRECATEGORIE, $NOTYPE)
    {
        return $this->where(['NOLIAISON'=>$NOLIAISON, 'NOPERIODE'=>$NOPERIODE, 'LETTRECATEGORIE'=>$LETTRECATEGORIE, 'NOTYPE'=>$NOTYPE])->first();
    }// non

    public function getTarifs($NOLIAISON)
    {
        $DATEDUJOUR = date('2019-09-01');
        return $this->join('liaison', 'liaison.NOLIAISON = tarifer.NOLIAISON')
                    ->join('port', 'port.NOPORT = liaison.NOPORT_DEPART')
                    ->join('port as port2', 'port2.NOPORT = liaison.NOPORT_ARRIVEE')
                    ->join('secteur', 'secteur.NOSECTEUR = liaison.NOSECTEUR')
                    ->join('periode', 'periode.NOPERIODE = tarifer.NOPERIODE')
                    ->join('categorie', 'categorie.LETTRECATEGORIE = tarifer.LETTRECATEGORIE')
                    ->join('type', 'type.NOTYPE = tarifer.NOTYPE')
                    ->select('categorie.LETTRECATEGORIE,
                    categorie.LIBELLE AS categorieLIBELLE,
                    type.LETTRECATEGORIE AS typeLETTRECATEGORIE,
                    type.NOTYPE,
                    type.NOTYPE, type.LIBELLE AS typeLIBELLE,
                    periode.DATEDEBUT,
                    periode.DATEFIN,
                    tarifer.TARIF')
                    ->where('tarifer.NOLIAISON', $NOLIAISON)
                    ->where('periode.DATEFIN <=', $DATEDUJOUR)
                    ->findAll();
        // exemple : A Passager A1 - Adulte 01/09/2010 15/06/2011 18.00
    }
}