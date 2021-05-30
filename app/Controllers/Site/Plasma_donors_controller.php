<?php
    
namespace App\Controllers\site;

use CodeIgniter\Controller;
use App\Models\Pincodes_model;
use App\Models\Plasma_donor_model;

class Plasma_donors_controller extends Controller {

	public function plasma_donor() {

		// getting all pincodes for form options
		$pincodes_model = new Pincodes_model();
		$all_places = $pincodes_model->places();

		// passing data
		$data = [
			'places' => $all_places,
		];
		return view('site/plasma_donor', $data);
	}

    
	public function search_plasma_donors() {
		if ($this->request->getmethod() == 'post') {
            if($this->validate([
				'city' => 'required',
				'place' => 'required'
			])){		
				$city = $this->request->getPost('city');
                $place = $this->request->getPost('place');
				$donor_model = new Plasma_donor_model();
				

				if($place == "all_places")						// finding suppliers with all places in city
                	$suppliers = $donor_model->find_plasma_donors_in_city($city);
				else {
					// finding pin code of place, to get result of surrounding places	
					$pincodes_model = new Pincodes_model();
					$place_pin = $pincodes_model->get_pin_from_place($place, $city);
					$suppliers = $donor_model->find_plasma_donors_with_pin($place_pin);
				}
				
				return \json_encode($suppliers);			
			}
			else {
				$data = [];
				return json_encode($data);
			}
		}		
	}
}