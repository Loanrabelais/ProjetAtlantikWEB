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
        $tarifs = $modeleTarif->getTarifs($liaison->NOLIAISON);
        $data['tarifs'] = $tarifs;
        $data['traversee'] = $traversee;
        $data['liaison'] = $liaison;
        $data['nomLiaison'] = $nomLiaison;

        if (!$this->request->is('post')) {
            return view('Templates/Header')
            . view('vue_ReserverTravresee', $data)
            . view('Templates/Footer');
        }
        
        // Si formulaire
        $enregistrements = $_POST['enregistrements'];
        $data['enregistrements'] = $enregistrements;
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
                . view('vue_RapportAjouterReservation', $data)
                . view('Templates/Footer');
        }

        // calcule le total et detecte les sur-capacités
        foreach ($enregistrements as $idx => $enregistrement) {
            $quantite = $enregistrement['Quantite'];
            $prix = $enregistrement['Prix'];
            $montantTotal += $quantite * $prix;
            $data['montantTotal'] = $montantTotal;

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
                . view('vue_RapportAjouterReservation', $data)
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
    
    public function ModifierCompte()
    {
        $session = session();

        $data['TitreDeLaPage'] = 'Modifier un compte';

        if (!$this->request->is('post')) {
            return view('Templates/Header', $data)
            . view('vue_ModifierCompte')
            . view('Templates/Footer');
        }

        /* VALIDATION DU FORMULAIRE */
        $reglesValidation = [
            'txtNOM' => 'required|string|max_length[60]',
            'txtPRENOM' => 'required|string|max_length[60]',
            'txtADRESSE' => 'required|string|max_length[128]',
            'txtCODEPOSTAL' => 'required|integer|max_length[11]',
            'txtVILLE' => 'required|string|max_length[80]',
            'txtTELEPHONEFIXE' => 'permit_empty|string|max_length[16]',
            'txtTELEPHONEMOBILE' => 'permit_empty|string|max_length[16]',

            'txtMEL' => 'required|string|max_length[80]',
            'txtMOTDEPASSE' => 'required|string|max_length[80]'
        ];

        if (!$this->validate($reglesValidation)) {
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/Header')
            . view('vue_ModifierCompte', $data)
            . view('Templates/Footer');
        }

        $donneesAUpdate = array(
            'NOM' => $this->request->getPost('txtNOM'),
            'PRENOM' => $this->request->getPost('txtPRENOM'),
            'ADRESSE' => $this->request->getPost('txtADRESSE'),
            'CODEPOSTAL' => $this->request->getPost('txtCODEPOSTAL'),
            'VILLE' => $this->request->getPost('txtVILLE'),
            'TELEPHONEFIXE' => $this->request->getPost('txtTELEPHONEFIXE'),
            'TELEPHONEMOBILE' => $this->request->getPost('txtTELEPHONEMOBILE'),
            'MEL' => $this->request->getPost('txtMEL'),
            'MOTDEPASSE' => $this->request->getPost('txtMOTDEPASSE')
        );

        $modelClient = new ModeleClient(); //instanciation du modèle
        $modelClient->update(['NOCLIENT' => session('NOCLIENT')], $donneesAUpdate); //update de la table client avec les données du formulaire
        $utilisateurRetourne = $modelClient->first(session('NOCLIENT'));
        // Mise à jour des données de session
        $session->set('MEL', $utilisateurRetourne->MEL);
        $session->set('nom', $utilisateurRetourne->NOM);
        $session->set('prenom', $utilisateurRetourne->PRENOM);
        $session->set('adresse', $utilisateurRetourne->ADRESSE);
        $session->set('codepostal', $utilisateurRetourne->CODEPOSTAL);
        $session->set('ville', $utilisateurRetourne->VILLE);
        $session->set('telephonefixe', $utilisateurRetourne->TELEPHONEFIXE);
        $session->set('telephonemobile', $utilisateurRetourne->TELEPHONEMOBILE);
        $data['MEL'] = $donneesAUpdate['PRENOM'].' '.$donneesAUpdate['NOM'];
        return view('Templates/Header')
            .view('vue_ModifierCompteReussi')
            .view('Templates/Footer');
    }

    public function AfficherHistoriqueReservations()
    {
        $data['TitreDeLaPage'] = 'Historique des réservations';
        $pager = \Config\Services::pager();
        $modelReservation = new ModeleReservation();
        $reservations = $modelReservation->where('NOCLIENT', session('NOCLIENT'))->paginate(4);
        $modelLiaison = new ModeleLiaison();
        $modelTraversee = new ModeleTraversee();
        foreach ($reservations as $reservation) {
            $reservation->traversee = $modelTraversee->where('NOTRAVERSEE', $reservation->NOTRAVERSEE)->first();
            $reservation->liaison = $modelLiaison->getLiaison($reservation->traversee->NOLIAISON);
        }
        $data['pager'] = $pager;
        $data['reservations'] = $reservations;
        return view('Templates/Header')
            .view('vue_HistoriqueReservations', $data)
            .view('Templates/Footer');
    }
}