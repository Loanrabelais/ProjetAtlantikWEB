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
use DeepCopy\f001\A;

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
}