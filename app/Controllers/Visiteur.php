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

class Visiteur extends BaseController
{
    public function acceuil()
    {
        return view('Templates/header')
        . view('vue_Acceuil')
        . view('Templates/footer');
    }

    public function SeConnecter()
    {
        $session = session();

        $data['TitreDeLaPage'] = 'Se connecter';

        /* TEST SI FORMULAIRE POSTE OU SI APPEL DIRECT (EN GET) */
        if (!$this->request->is('post')) {
            return view('Templates/header', $data) // Renvoi formulaire de connexion
            . view('vue_SeConnecter')
            . view('Templates/footer');
        }
        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */
 
        /* VALIDATION DU FORMULAIRE */
        $reglesValidation = [
            'txtMEL' => 'required',
            'txtMotDePasse' => 'required'
        ];

        if (!$this->validate($reglesValidation)) {
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/header', $data)
            . view('vue_SeConnecter') // Renvoi formulaire de connexion
            . view('Templates/footer');
        }
        
        $NOM = $this->request->getPost('txtMEL');
        $MdP = $this->request->getPost('txtMotDePasse');
 
        /* on va chercher dans la BDD l'utilisateur correspondant aux id et mot de passe saisis */
        $modelClient = new ModeleClient(); // instanciation modèle
        $condition = ['MEL'=>$NOM,'motdepasse'=>$MdP];
        $utilisateurRetourne = $modelClient->where($condition)->first();
        /* where : méthode, QueryBuilder, héritée de Model (), retourne,
        ici sous forme d'un objet, le résultat de la requête :
        SELECT * FROM utilisateur  WHERE identifiant='$pId' and motdepasse='$MotdePasse
        utilisateurRetourne = objet utilisateur ($returnType = 'object')
        */
 
        if ($utilisateurRetourne != null) {
            /* MEL et mot de passe OK : MEL et profil sont stockés en session */
            $session->set('NOCLIENT', $utilisateurRetourne->NOCLIENT);
            $session->set('MEL', $utilisateurRetourne->MEL);
            $session->set('profil', 'Client');
            $session->set('nom', $utilisateurRetourne->NOM);
            $session->set('prenom', $utilisateurRetourne->PRENOM);
            $session->set('adresse', $utilisateurRetourne->ADRESSE);
            $session->set('codepostal', $utilisateurRetourne->CODEPOSTAL);
            $session->set('ville', $utilisateurRetourne->VILLE);
            $session->set('telephonefixe', $utilisateurRetourne->TELEPHONEFIXE);
            $session->set('telephonemobile', $utilisateurRetourne->TELEPHONEMOBILE);
            $data['MEL'] = $utilisateurRetourne->PRENOM.' '.$utilisateurRetourne->NOM;
            return view('Templates/header', $data)
            . view('vue_ConnexionReussie')
            . view('Templates/footer');
        } else {
            /* MEL et/ou mot de passe OK : on renvoie le formulaire  */
            $data['TitreDeLaPage'] = "MEL ou/et Mot de passe inconnu(s)";
            return view('Templates/header', $data)
            . view('vue_SeConnecter')
            . view('Templates/footer');
        }
    } // Fin seConnecter

    public function SeDeconnecter()
    {
        session()->destroy();
        return redirect()->to('seconnecter');
    }

    public function CreerCompte()
    {
        $data['TitreDeLaPage'] = 'Créer un compte';

        if (!$this->request->is('post')) {
            return view('Templates/header', $data)
            . view('vue_CreerCompte')
            . view('Templates/footer');
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

            'txtMEL' => 'required|mail|is_unique[client.MEL]|max_length[80]',
            'txtMOTDEPASSE' => 'required|string|max_length[80]'
        ];

        if (!$this->validate($reglesValidation)) {
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/header', $data)
            . view('vue_CreerCompte')
            . view('Templates/footer');
        }

        session()->destroy();

        $donneesAInserer = array(
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
        
        $modelClient->insert($donneesAInserer);
        $utilisateurRetourne = $modelClient->first();
        $data['MEL'] = $donneesAInserer['PRENOM'].' '.$donneesAInserer['NOM'];
        return view('Templates/header')
            .view('vue_CreerCompteReussi')
            .view('Templates/footer');
    }

    public function AfficherLiaisons()
    {
        $data['TitreDeLaPage'] = 'Afficher les liaisons';
        $modelLiaison = new ModeleLiaison();
        $liaisons = $modelLiaison->getLiaisons();
        $data['liaisons'] = $liaisons;
        return view('Templates/header')
        . view('vue_AfficherLiaisons', $data)
        . view('Templates/footer');
    }

    public function AfficherTarifs($NOLIAISON)
    {
        $data['TitreDeLaPage'] = 'Afficher les tarifs';
        $modelTarif = new ModeleTarif();
        $tarifs = $modelTarif->getTarifs($NOLIAISON);
        $data['tarifs'] = $tarifs;
        $modelPeriode = new ModelePeriode();
        $periodes = $modelPeriode->where('periode.DATEFIN >=', date('Y-m-d'))->findAll();
        $data['periodes'] = $periodes;
        $modelCategorie = new ModeleCategorie();
        $categories = $modelCategorie->findAll();
        $data['categories'] = $categories;
        $modelType = new ModeleType();
        $types = $modelType->findAll();
        $data['types'] = $types;

        return view('Templates/header')
        . view('vue_AfficherTarifs', $data)
        . view('Templates/footer');
    }

    public function AfficherHorairesTraversee($noSecteur = null)
    {
        $data['TitreDeLaPage'] = 'Afficher les horaires de traversée';
        $secteurs = new ModeleSecteur();
        $secteurs = $secteurs->findAll();
        $data['secteurs'] = $secteurs;
        if ($noSecteur != null) { // Si un secteur est sélectionné

            $modliaisons = new ModeleLiaison();
            $res = $modliaisons->where('NOSECTEUR', (int)$noSecteur)->get();
            $liaisons = $res->getResult();

            if (!empty($liaisons)) { // Si des liaisons existent pour ce secteur
                $modPort = new ModelePort();
                foreach ($liaisons as $liaison) {
                    $res = $modPort->where('NOPORT', $liaison->NOPORT_DEPART)->get();
                    $liaison->PORT_DEPART = $res->getResult()[0];
                    $res = $modPort->where('NOPORT', $liaison->NOPORT_ARRIVEE)->get();
                    $liaison->PORT_ARRIVEE = $res->getResult()[0];
                }

                $modPeriode = new ModelePeriode();
                foreach ($liaisons as $liaison) {
                    $periodes = $modPeriode->findAll();
                }

                $data['liaisons'] = $liaisons;
                $data['periodes'] = $periodes;
            }
            $data['secteurSelectionne'] = $noSecteur;

            return view('Templates/header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/footer');
        }
        elseif ($this->request->is('post')) { // Si le formulaire est soumis
            $noLiaison = $this->request->getPost('liaison_id');
            $date = $this->request->getPost('date');
            $modLiaison = new ModeleLiaison();
            $res = $modLiaison->where('NOLIAISON', (int)$noLiaison)->get();
            $liaison = $res->getResult()[0];
            $modelTraversee = new ModeleTraversee();
            $traversees = $modelTraversee->getLesTraverseesBateaux($noLiaison, $date);
            $modelCategorie = new ModeleCategorie();
            $categories = $modelCategorie->findAll();
            foreach ($traversees as $traversee) {
                $traversee->cats = [];
                foreach ($categories as $categorie) {
                    $cat = clone $categorie;
                    $capaciteMax = $modelTraversee->getCapaciteMaximale($traversee->NOTRAVERSEE, $cat->LETTRECATEGORIE);
                    $quantiteEnregistree = $modelTraversee->getQuantiteEnregistree($traversee->NOTRAVERSEE, $cat->LETTRECATEGORIE);
                    $cat->PLACESDISPONIBLES = $capaciteMax - $quantiteEnregistree;
                    $traversee->cats[] = $cat;
                }
            }
            $data['categories'] = $categories;
            $data['traversees'] = $traversees;

            return view('Templates/header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/Footer');
        }
        else {
            $data['secteurSelectionne'] = null;
            $data['liaisons'] = null;
            $data['periodes'] = null;
            return view('Templates/header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/Footer');
        }
    }
}