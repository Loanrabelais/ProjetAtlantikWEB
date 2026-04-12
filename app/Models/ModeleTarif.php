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
    $DATEDUJOUR = '2021-06-19';
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
                          type.LIBELLE,
                          periode.DATEDEBUT,
                          periode.DATEFIN,
                          tarifer.TARIF')
                ->where('tarifer.NOLIAISON', $NOLIAISON)
                ->where('periode.DATEDEBUT <=', $DATEDUJOUR)
                ->where('periode.DATEFIN >=', $DATEDUJOUR)
                ->findAll();
    }

    public function getTarifsTest($NOLIAISON)
    {
    $DATEDUJOUR = '2021-06-19';
    return $this->join('liaison', 'liaison.NOLIAISON = tarifer.NOLIAISON')
                ->join('port', 'port.NOPORT = liaison.NOPORT_DEPART')
                ->join('port as port2', 'port2.NOPORT = liaison.NOPORT_ARRIVEE')
                ->join('secteur', 'secteur.NOSECTEUR = liaison.NOSECTEUR')
                ->join('periode', 'periode.NOPERIODE = tarifer.NOPERIODE')
                ->join('type', 'type.NOTYPE = tarifer.NOTYPE AND type.LETTRECATEGORIE = tarifer.LETTRECATEGORIE')
                ->select('type.LETTRECATEGORIE AS typeLETTRECATEGORIE,
                          type.NOTYPE,
                          type.LIBELLE,
                          periode.DATEDEBUT,
                          periode.DATEFIN,
                          tarifer.TARIF')
                ->where('tarifer.NOLIAISON', $NOLIAISON)
                ->where('periode.DATEDEBUT <=', $DATEDUJOUR)
                ->where('periode.DATEFIN >=', $DATEDUJOUR)
                ->findAll();
    }
}