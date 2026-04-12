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
            return view('Templates/Header', $data) // Renvoi formulaire de connexion
            . view('vue_SeConnecter')
            . view('Templates/Footer');
        }
        /* SI FORMULAIRE NON POSTE, LE CODE QUI SUIT N'EST PAS EXECUTE */
 
        /* VALIDATION DU FORMULAIRE */
        $reglesValidation = [
            'txtMEL' => 'required',
            'txtMotDePasse' => 'required'
        ];

        if (!$this->validate($reglesValidation)) {
            $data['TitreDeLaPage'] = "Saisie incorrecte";
            return view('Templates/Header', $data)
            . view('vue_SeConnecter') // Renvoi formulaire de connexion
            . view('Templates/Footer');
        }
        
        $NOM = $this->request->getPost('txtMEL');
        $MdP = $this->request->getPost('txtMotDePasse');
 
        /* on va chercher dans la BDD l'utilisateur correspondant aux id et mot de passe saisis */
        $modUtilisateur = new ModeleClient(); // instanciation modèle
        $condition = ['MEL'=>$NOM,'motdepasse'=>$MdP];
        $utilisateurRetourne = $modUtilisateur->where($condition)->first();
        /* where : méthode, QueryBuilder, héritée de Model (), retourne,
        ici sous forme d'un objet, le résultat de la requête :
        SELECT * FROM utilisateur  WHERE identifiant='$pId' and motdepasse='$MotdePasse
        utilisateurRetourne = objet utilisateur ($returnType = 'object')
        */
 
        if ($utilisateurRetourne != null) {
            /* MEL et mot de passe OK : MEL et profil sont stockés en session */
            $session->set('MEL', $utilisateurRetourne->MEL);
            $session->set('profil', 'Client');
            $session->set('nom', $utilisateurRetourne->NOM);
            $session->set('prenom', $utilisateurRetourne->PRENOM);
            $session->set('adresse', $utilisateurRetourne->ADRESSE);
            $session->set('codepostal', $utilisateurRetourne->CODEPOSTAL);
            $session->set('ville', $utilisateurRetourne->VILLE);
            $data['MEL'] = $utilisateurRetourne->PRENOM.' '.$utilisateurRetourne->NOM;
            return view('Templates/Header', $data)
            . view('vue_ConnexionReussie')
            . view('Templates/Footer');
        } else {
            /* MEL et/ou mot de passe OK : on renvoie le formulaire  */
            $data['TitreDeLaPage'] = "MEL ou/et Mot de passe inconnu(s)";
            return view('Templates/Header', $data)
            . view('vue_SeConnecter')
            . view('Templates/Footer');
        }
    } // Fin seConnecter

    public function SeDeconnecter()
    {
        session()->destroy();
        return redirect()->to('seconnecter');
    }

    public function CreerCompte()
    {
        $session = session();

        $data['TitreDeLaPage'] = 'Créer un compte';

        if (!$this->request->is('post')) {
            return view('Templates/Header', $data)
            . view('vue_CreerCompte')
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
            return view('Templates/Header', $data)
            . view('vue_CreerCompte')
            . view('Templates/Footer');
        }

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
        
        $donnees['clientAjoute'] = $modelClient->insert($donneesAInserer, false);        
        $session->set('MEL', $donneesAInserer['MEL']);
        $session->set('profil', 'Client');
        $data['MEL'] = $donneesAInserer['PRENOM'].' '.$donneesAInserer['NOM'];
        return view('Templates/Header')
            .view('vue_CreerCompteReussi', $donnees)
            .view('Templates/Footer');
    }

    public function AfficherLiaisons()
    {
        $data['TitreDeLaPage'] = 'Afficher les liaisons';
        $modelLiaison = new ModeleLiaison();
        $liaisons = $modelLiaison->getLiaisons();
        $data['liaisons'] = $liaisons;
        return view('Templates/Header')
        . view('vue_AfficherLiaisons', $data)
        . view('Templates/Footer');
    }

    public function AfficherTarifs($NOLIAISON)
    {
        $data['TitreDeLaPage'] = 'Afficher les tarifs';
        $modelTarif = new ModeleTarif();
        $tarifs = $modelTarif->getTarifs($NOLIAISON);
        $data['tarifs'] = $tarifs;
        $modelPeriode = new ModelePeriode();
        $periodes = $modelPeriode->findAll();
        $data['periodes'] = $periodes;
        $modelCategorie = new ModeleCategorie();
        $categories = $modelCategorie->findAll();
        $data['categories'] = $categories;
        $modelType = new ModeleType();
        $types = $modelType->findAll();
        $data['types'] = $types;
        $modelTarif = new ModeleTarif();
        $tarif = $modelTarif->findAll();
        $data['tarif'] = $tarif;

        return view('Templates/Header')
        . view('vue_AfficherTarifs', $data)
        . view('Templates/Footer');
    }

    public function AfficherHorairesTraversee($noSecteur = null)
    {
        $data['TitreDeLaPage'] = 'Afficher les horaires de traversée';
        $secteurs = new ModeleSecteur();
        $secteurs = $secteurs->findAll();
        $data['secteurs'] = $secteurs;
        if ($noSecteur != null) { // Si un secteur est sélectionné
            $modSecteur = new ModeleSecteur();
            $res = $modSecteur->where('NOSECTEUR', (int)$noSecteur)->get();
            $secteur = $res->getResult();

            $modliaisons = new ModeleLiaison();
            $res = $modliaisons->where('NOSECTEUR', (int)$noSecteur)->get();
            $liaisons = $res->getResult();

            if (!empty($liaisons)) {
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
            $data['secteurSelectionne'] = $secteur;

            return view('Templates/Header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/Footer');
        }
        elseif ($this->request->is('post')) { // Si le formulaire est soumis
            $noLiaison = $this->request->getPost('liaison_id');
            $noPeriode = $this->request->getPost('periode_id');
            $modLiaison = new ModeleLiaison();
            $res = $modLiaison->where('NOLIAISON', (int)$noLiaison)->get();
            $liaison = $res->getResult()[0];
            $modPeriode = new ModelePeriode();
            $res = $modPeriode->where('NOPERIODE', (int)$noPeriode)->get();
            $periode = $res->getResult()[0];
            $modelTraversee = new ModeleTraversee();
            $traversees = $modelTraversee->getLesTraverseesBateaux($noLiaison, $periode);
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

            return view('Templates/Header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/Footer');
        }
        else {
            $data['secteurSelectionne'] = null;
            $data['liaisons'] = null;
            $data['periodes'] = null;
            return view('Templates/Header')
            . view('vue_AfficherHorairesTraversee', $data)
            . view('Templates/Footer');
        }
    }
}