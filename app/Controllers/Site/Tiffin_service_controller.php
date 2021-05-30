<?php
    
namespace App\Controllers\site;

use CodeIgniter\Controller;
use App\Models\Pincodes_model;
use App\Models\Tiffin_service_model;

class Tiffin_service_controller extends Controller {

	public function tiffin_service() {

		// getting all pincodes for form options
		$pincodes_model = new Pincodes_model();
		$all_places = $pincodes_model->places();

		// passing data
		$data = [
			'places' => $all_places,
		];
		return view('site/tiffin_service', $data);
	}	
	
	
	public function search_tiffin_service() {

		if ($this->request->getmethod() == 'post') {
            if($this->validate([
				'city' => 'required',
				'place' => 'required'
			])){		
				$city = $this->request->getPost('city');
                $place = $this->request->getPost('place');
				$tiffin_service_model = new Tiffin_service_model();
				

				if($place == "all_places")						// finding suppliers with all places in city
                	$suppliers = $tiffin_service_model->find_tiffin_service_in_city($city);
				else {
					// finding pin code of place, to get result of surrounding places	
					$pincodes_model = new Pincodes_model();
					$place_pin = $pincodes_model->get_pin_from_place($place, $city);
					$suppliers = $tiffin_service_model->find_tiffin_service_with_pin($place_pin);
				}
				
				return \json_encode($suppliers);			
			}
			else {				
				return json_encode([]);
				
			}
		}		
	}
}