<?php //L'UC marche et la gestion des erreures est opérationel par contre le feedback du user est à revoire
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
        
        // Si formulaire
        $enregistrements = $_POST['enregistrements'];
        $montantTotal = 0;
        $overbooked = [];

        $reglesValidation = [
            'enregistrements.*.Quantite' => 'required|integer',
        ];

        // valide les inputs
        if (!$this->validate($reglesValidation)) {
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            $data['errors'] = $this->validator->getErrors();
            return view('Templates/Header')
                . view('vue_ReserverTravresee', $data)
                . view('Templates/Footer');
        }

        // calcule le total et detecte les sur-capacités
        foreach ($enregistrements as $idx => $enregistrement) {
            $quantite = $enregistrement['Quantite'];
            $prix = $enregistrement['Prix'];
            $montantTotal += $quantite * $prix;

            $capMax = $modelTraversee->getCapaciteMaximale($traversee->NOTRAVERSEE, $enregistrement['Lettrecategorie']);
            $capEnreg = $modelTraversee->getQuantiteEnregistree($traversee->NOTRAVERSEE, $enregistrement['Lettrecategorie']);

            if ($quantite > ($capMax - $capEnreg)) {
                $overbooker[] = [
                    'index' => $idx,
                    'Lettrecategorie' => $enregistrement['Lettrecategorie'],
                    'demandee' => $quantite,
                    'disponible' => max(0, $capMax - $capEnreg)
                ];
            }
        }

        // si overbooker, retourne la vue
        if (!empty($overbooker)) {
            $data['TitreDeLaPage'] = "Capacité dépassée";
            $data['overbooked'] = $overbooked;
            return view('Templates/Header')
                . view('vue_ReserverTravresee', $data)
                . view('Templates/Footer');
        }

        //Insertion de la reservation
        $reservationAInserer = array(
            'NOTRAVERSEE' => $traversee->NOTRAVERSEE,
            'NOCLIENT' => $_SESSION['NOCLIENT'],
            'DATEHEURE' => $traversee->DATEHEUREDEPART,
            'MONTANTTOTAL' => $montantTotal,
            'PAYE' => 0
        );

        //insertion des enregistrements (table enregistrer)
        $modelRerservation = new ModeleReservation();
        $noReservationAjoute = $modelRerservation->insert($reservationAInserer);
        $data['noReservationAjoute'] = $noReservationAjoute;
        foreach ($enregistrements as $enregistrement){
            if ($enregistrement['Quantite'] != 0){
                $enregistrementAInserer = array(
                    'NORESERVATION' => $noReservationAjoute,
                    'LETTRECATEGORIE' => $enregistrement['Lettrecategorie'],
                    'NOTYPE' => $enregistrement['Notype'],
                    'QUANTITERESERVEE' => $enregistrement['Quantite'],
                    'QUANTITEEMBARQUEE' => 0
                );
                $modelEnregistrer = new ModeleEnregistrer();
                $modelEnregistrer->insert($enregistrementAInserer,false);
            }
        }
        $data['TitreDeLaPage'] = 'Reservation ajoutée';
        return view('Templates/Header')
            .view('vue_RapportAjouterReservation', $data)
            .view('Templates/Footer');
    }
}