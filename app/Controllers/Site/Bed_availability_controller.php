<?php
    
namespace App\Controllers\site;

use CodeIgniter\Controller;
use App\Models\Pincodes_model;
use App\Models\Bed_availability_model;

class Bed_availability_controller extends Controller {

	public function bed_availability() {

		// getting all pincodes for form options
		$pincodes_model = new Pincodes_model();
		$all_places = $pincodes_model->places();

		// passing data
		$data = [
			'places' => $all_places,
		];
		return view('site/bed_availability', $data);
	}

	public function search_bed_availability() {

		if ($this->request->getmethod() == 'post') {
            if($this->validate([
				'city' => 'required',
				'place' => 'required'
			])){		
				$city = $this->request->getPost('city');
                $place = $this->request->getPost('place');
				$bed_availability_model = new Bed_availability_model();
				
				if($place == "all_places")						// finding suppliers with all places in city
                	$suppliers = $bed_availability_model->find_bed_availability_in_city($city);
				else {
					// finding pin code of place, to get result of surrounding places	
					$pincodes_model = new Pincodes_model();
					$place_pin = $pincodes_model->get_pin_from_place($place, $city);
					$suppliers = $bed_availability_model->find_bed_availability_with_pin($place_pin);
				}
				
				return \json_encode($suppliers);			
			}
			else {				
				return json_encode([]);
			}
		}		
	}
}