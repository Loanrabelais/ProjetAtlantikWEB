<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Visiteur::acceuil');
$routes->get('acceuil', 'Visiteur::acceuil');
$routes->get('seconnecter', 'Visiteur::SeConnecter');
$routes->post('seconnecter', 'Visiteur::SeConnecter');
$routes->get('deconnecter', 'Visiteur::SeDeconnecter');
$routes->get('creercompte', 'Visiteur::CreerCompte');
$routes->post('creercompte', 'Visiteur::CreerCompte');
$routes->get('afficherliaisons', 'Visiteur::AfficherLiaisons');
$routes->get('affichertarifs/(:num)', 'Visiteur::AfficherTarifs/$1');
$routes->match(['get', 'post'], 'afficherhorairestraversee', 'Visiteur::AfficherHorairesTraversee');
$routes->get('afficherhorairestraversee/(:num)', 'Visiteur::AfficherHorairesTraversee/$1');
$routes->match(['get', 'post'], 'reservertraversee', 'Client::ReserverTraversee', ["filter"=> "filtreclient"]);
$routes->get('reservertraversee/(:num)', 'Client::ReserverTraversee/$1', ["filter"=> "filtreclient"]);
