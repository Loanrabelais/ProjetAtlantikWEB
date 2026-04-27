<?php
namespace App\Controllers;

use App\Models\ModeleClient;
use App\Models\ModeleLiaison;
use App\Models\ModelePort;
use App\Models\ModeleSecteur;
use App\Models\ModeleCategorie;
use App\Models\ModeleTarif;
use App\Models\ModeleType;
use App\Models\ModelePeriode;
use App\Models\ModeleTraversee;
use App\Models\ModeleRerservation;

class Client extends BaseController
{
    public function ReserverTraversee($noTraversee = null)
    {
        $data['TitreDeLaPage'] = 'Reserver une traversée';

        if (!$this->request->is('post')) {
            $modelTraversee = new ModeleTraversee();
            $traversee = $modelTraversee->where('NOTRAVERSEE', (int)$noTraversee)->first();
            $modelLiaison = new ModeleLiaison();
            $liaison = $modelLiaison->where('NOLIAISON', (int)$traversee->NOLIAISON)->first();
            $nomLiaison = $modelLiaison->getLiaison($liaison->NOLIAISON);
            $modeleTarif = new ModeleTarif();
            $tarifs = $modeleTarif->getTarifsTest($liaison->NOLIAISON);
            $data['tarifs'] = $tarifs;
            $data['traversee'] = $traversee;
            $data['liaison'] = $liaison;
            $data['nomLiaison'] = $nomLiaison;
            return view('Templates/Header')
            . view('vue_ReserverTravresee.php', $data)
            . view('Templates/Footer');
        }
        $reglesValidation = [
            'Quantite_Adulte' => 'required|integer',
            // vide ou integer
        ];
        if (!$this->validate($reglesValidation)) {
            /* formulaire non validé, on renvoie le formulaire */
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/Header')
            . view('vue_ReserverTravresee', $data)
            . view('Templates/Footer');
        }
        $donneesAInserer = array(
            'NOTRAVERSEE' => ,
            'NOCLIENT' => $_SESSION['NOCLIENT'],
            'DATEHEURE' => ,
            'MONTANTTOTAL' => 0
        );
        die(var_dump($donneesAInserer));
        $modelRerservation = new ModelRerservation();
        $donnees['produitAjoute'] = $modelProduit->insert($donneesAInserer, false);

        return view('Templates/Header')
            .view('vue_RapportAjouterReservation', $data)
            .view('Templates/Footer');
    }
}