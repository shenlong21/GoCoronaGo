<?php
    
namespace App\Controllers\site;

use CodeIgniter\Controller;
use App\Models\Pincodes_model;
use App\Models\Oxygen_supply_model;

class Oxygen_supply_controller extends Controller {

	// using as default controller
	public function index() {

		// getting all pincodes for form options
		$pincodes_model = new Pincodes_model();
		$all_places = $pincodes_model->places();

		// passing data
		$data = [
			'places' => $all_places,
		];
		return view('site/oxygen_supply', $data);
	}
	
	public function oxygen_supply() {

		// getting all pincodes for form options
		$pincodes_model = new Pincodes_model();
		$all_places = $pincodes_model->places();

		// passing data
		$data = [
			'places' => $all_places,
		];
		return view('site/oxygen_supply', $data);
	}

    
	public function search_oxygen_supplier() {
		// sleep(1);
		if ($this->request->getmethod() == 'post') {
            if($this->validate([
				'city' => 'required',
				'place' => 'required'
			])){		
				$city = $this->request->getPost('city');
                $place = $this->request->getPost('place');
				$oxygen_supply_model = new Oxygen_supply_model();

				if($place == "all_places")						// finding suppliers with all places in city
                	$suppliers = $oxygen_supply_model->find_oxygen_suppiers_in_city($city);
				else {
					// finding pin code of place, to get result of surrounding places	
					$pincodes_model = new Pincodes_model();
					$place_pin = $pincodes_model->get_pin_from_place($place, $city);
					$suppliers = $oxygen_supply_model->find_oxygen_suppiers_with_pin($place_pin);
				}
				
				return \json_encode($suppliers);			
			}
			else {				
				return json_encode([]);
			}
		}		
	}
}