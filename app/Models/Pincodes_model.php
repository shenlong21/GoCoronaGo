<?php namespace App\Models;

use CodeIgniter\Model;

class Pincodes_model extends Model
{
    protected $table      = 'pincodes';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
    protected $allowedFields = ['name', 'pincode','city'];

    public function places() {
        return $this->select(['name', 'pincode'])->findAll();
    }

    public function get_place_name($pin) {
        return  $this->select('name')->where('pincode', $pin)->findAll();
    }

    public function get_pin_from_place($place, $city) {
        $res =  $this->select('pincode')->where('city', $city)->where('name', $place)->findAll();
        return $res[0]['pincode'];
    }
}