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

class Client extends BaseController
{
    public function ReserverTraversee($noTraversee)
    {
        $data['TitreDeLaPage'] = 'Reserver une traversée';
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
}