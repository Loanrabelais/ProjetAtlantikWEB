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
use App\Models\ModeleReservation;
use App\Models\ModeleEnregistrer;

class Client extends BaseController
{
    public function ReserverTraversee($noTraversee = null)
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

        if (!$this->request->is('post')) {
            return view('Templates/Header')
            . view('vue_ReserverTravresee.php', $data)
            . view('Templates/Footer');
        }
        $enregistrements = array();
        $montantTotal = 0;
        foreach ($_POST['enregistrements'] as $enregistrement){
            $enregistrements[] = $enregistrement;
            $montantTotal += $enregistrement['Quantite']*$enregistrement['Prix'];
        }
        $reglesValidation = [
            'enregistrement' => 'permit_empty'
        ];
        if (!$this->validate($reglesValidation)) {
            /* formulaire non validé, on renvoie le formulaire */
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/Header')
            . view('vue_ReserverTravresee', $data)
            . view('Templates/Footer');
        }
        $reservationAInserer = array(
            'NOTRAVERSEE' => $traversee->NOTRAVERSEE,
            'NOCLIENT' => $_SESSION['NOCLIENT'],
            'DATEHEURE' => $traversee->DATEHEUREDEPART,
            'MONTANTTOTAL' => $montantTotal,
            'PAYE' => 0
        );
        $modelRerservation = new ModeleReservation();
        $reservationAjoute = $modelRerservation->insert($reservationAInserer, false);
        $data['reservationAjoute'] = $reservationAjoute;
        foreach ($enregistrements as $enregistrement){
            if ($enregistrement['Quantite'] != 0){
                $enregistrementAInserer = array(
                    'NORESERVATION' => 9001,
                    'LETTRECATEGORIE' => $enregistrement['Lettrecategorie'],
                    'NOTYPE' => $enregistrement['Notype'],
                    'QUANTITERESERVEE' => $enregistrement['Quantite'],
                    'QUANTITEEMBARQUEE' => 0
                );
                $modelEnregistrer = new ModeleEnregistrer();
                $modelEnregistrer->insert($enregistrementAInserer,false);
            }
        }

        return view('Templates/Header')
            .view('vue_RapportAjouterReservation', $data)
            .view('Templates/Footer');
    }
}