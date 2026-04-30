<?php
namespace App\Models;
use CodeIgniter\Model;
 
class ModeleEnregistrer extends Model
{
    protected $table = 'enregistrer';
    protected $primaryKey = 'NORESERVATION';
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $allowedFields = ['NORESERVATION', 'LETTRECATEGORIE', 'NOTYPE', 'QUANTITERESERVEE', 'QUANTITEEMBARQUEE'];
}