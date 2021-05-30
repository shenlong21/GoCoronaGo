<?php
    
namespace App\Controllers\Site;

use CodeIgniter\Controller;
use App\Models\Oxygen_supply_model;
use App\Models\Tiffin_service_model;
use App\Models\Bed_availability_model;
use App\Models\Plasma_donor_model;
use App\Controllers\BaseController;


class Posts_controller extends BaseController {
    
    public function index() {
        $category = $this->request->getGet('category');
        $id = $this->request->getGet('number');

        if( is_null($category) || is_null($id) ){
            return view('site/error_page');
        }

        if( $category == "oxygen_supply" ){                        
            $oxygen_supply_model = new Oxygen_supply_model();
            $post = $oxygen_supply_model->get_post($this->request->getGet('number'));

            if( empty($post))
                return view('site/error_page');

            $name = $post[0]['name'];
            $url_name = \url_title($name,'-',TRUE);
            
            $slug = "oxygen-supply-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

            return redirect()->to("post/$slug");
        }

        // for tiffin service
        else if( $category == "tiffin_service" ){                        
            $tiffin_service_model = new Tiffin_service_model();
            $post = $tiffin_service_model->get_post($this->request->getGet('number'));

            if( empty($post))
                return view('site/error_page');

            $name = $post[0]['name'];
            $url_name = \url_title($name,'-',TRUE);
            
            $slug = "tiffin-service-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

            return redirect()->to("post/$slug");
        }

         // for bed availability
        else if( $category == "bed_availability" ){                        
            $bed_availability_model = new Bed_availability_model();
            $post = $bed_availability_model->get_post($this->request->getGet('number'));

            if( empty($post))
                return view('site/error_page');

            $name = $post[0]['name'];
            $url_name = \url_title($name,'-',TRUE);
            
            $slug = "bed-availability-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

            return redirect()->to("post/$slug");
        }

        // for plasma donors
        else if( $category == "plasma_donor" ){                        
            $plasma_donor_model = new Plasma_donor_model();
            $post = $plasma_donor_model->get_post($this->request->getGet('number'));

            if( empty($post))
                return view('site/error_page');

            $name = $post[0]['name'];
            $url_name = \url_title($name,'-',TRUE);
            
            $slug = "plasma-donor-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

            return redirect()->to("post/$slug");
        }
        else {
            return view('site/error_page');
        }
    }


    public function show_post () {
        $uri = \uri_string();
        $post_name_temp = \explode('/', $uri);

        // dumb validation
        if($post_name_temp[0] != "post")
            return view('site/error_page');

        $post_slug = $post_name_temp[1];
        $post_array = explode('-',$post_slug);

        if($post_array[0] == "oxygen" && $post_array[1] == "supply"){
            $id = $post_array[2];           

            $oxygen_supply_model = new Oxygen_supply_model();
            $post = $oxygen_supply_model->get_post($id);

            if(empty($post)){
                return view('site/error_page');
            }

            $data = [
                'p' => $post[0],
                'previous_page' => 'oxygen_supply',
                'category' => 'Oxygen Supply',
            ];
            
            return view('site/post', $data); 
        }

        // for tiffin service
        else if($post_array[0] == "tiffin" && $post_array[1] == "service"){
            $id = $post_array[2];           

            $tiffin_service_model = new Tiffin_service_model();
            $post = $tiffin_service_model->get_post($id);

            if(empty($post)){
                return view('site/error_page');
            }

            $data = [
                'p' => $post[0],
                'previous_page' => 'tiffin_service',
                'category' => 'Tiffin Service',
            ];
            
            return view('site/post', $data); 
        }

        // bed availability
        else if($post_array[0] == "bed" && $post_array[1] == "availability"){
            $id = $post_array[2];           

            $bed_availability_model = new Bed_availability_model();
            $post = $bed_availability_model->get_post($id);

            if(empty($post)){
                return view('site/error_page');
            }

            $data = [
                'p' => $post[0],
                'previous_page' => 'bed_availability',
                'category' => 'Bed Availability',
            ];
            
            return view('site/post', $data); 
        }

        // plasma donor
        else if($post_array[0] == "plasma" && $post_array[1] == "donor"){
            $id = $post_array[2];           

            $plasma_donor_model = new Plasma_donor_model();
            $post = $plasma_donor_model->get_post($id);

            if(empty($post)){
                return view('site/error_page');
            }

            $data = [
                'p' => $post[0],
                'previous_page' => 'plasma_donor',
                'category' => 'Plasma Donor',
            ];
            
            return view('site/post', $data); 
        }

        else {
            return view('site/error_page', ['message' => 'No post found for this url']);
        }
        
    }


    public function report_post () {

        if($this->request->getMethod() == 'post') {

            if($this->validate([
                'category' => 'required|alpha_numeric_punct',
                'number' => 'required|decimal'
            ])){

                // report the post
                if($this->request->getPost('category') == 'oxygen_supply') {
                    // report post from oxygen supply
                    $oxygen_supply_model = new Oxygen_supply_model();
                    $update = $oxygen_supply_model->report_post($this->request->getPost('number'));
                    
                    if($update){
                        $post = $oxygen_supply_model->get_post($this->request->getPost('number'));

                        if(empty($post)){
                            return view('site/error_page');
                        }

                        $name = $post[0]['name'];
                        $url_name = \url_title($name,'-',TRUE);
                        
                        $slug = "oxygen-supply-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

                        $this->session->setFlashdata('report_response', 'success');
                        return redirect()->to("post/$slug");
                    }
                    else {
                        return view('site/error_page');
                    }
                }

                // for tiffin service
                else if($this->request->getPost('category') == 'tiffin_service') {
                    // report post from oxygen supply
                    $tiffin_service_model = new Tiffin_service_model();
                    $update = $tiffin_service_model->report_post($this->request->getPost('number'));
                    
                    if($update){
                        $post = $tiffin_service_model->get_post($this->request->getPost('number'));

                        if(empty($post)){
                            return view('site/error_page');
                        }
                        
                        $name = $post[0]['name'];
                        $url_name = \url_title($name,'-',TRUE);
                        
                        $slug = "tiffin-service-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

                        $this->session->setFlashdata('report_response', 'success');
                        return redirect()->to("post/$slug");
                    }
                    else {
                        return view('site/error_page');
                    }
                }

                // for bed availability                
                else if($this->request->getPost('category') == 'bed_availability') {
                    // report post from bed_availability
                    $bed_availability_model = new Bed_availability_model();
                    $update = $bed_availability_model->report_post($this->request->getPost('number'));
                    
                    if($update){
                        $post = $bed_availability_model->get_post($this->request->getPost('number'));

                        if(empty($post)){
                            return view('site/error_page');
                        }
                        
                        $name = $post[0]['name'];
                        $url_name = \url_title($name,'-',TRUE);
                        
                        $slug = "bed-availability-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;

                        $this->session->setFlashdata('report_response', 'success');
                        return redirect()->to("post/$slug");
                    }
                    else {
                        return view('site/error_page');
                    }
                }


                // plasma donor
                else if($this->request->getPost('category') == 'plasma_donor') {
                    // report post from plama donor
                    $plasma_donor_model = new Plasma_donor_model();
                    $update = $plasma_donor_model->report_post($this->request->getPost('number'));
                    
                    if($update){
                        $post = $plasma_donor_model->get_post($this->request->getPost('number'));

                        if(empty($post)){
                            return view('site/error_page');
                        }
                        
                        $name = $post[0]['name'];
                        $url_name = \url_title($name,'-',TRUE);
                        
                        $slug = "plasma-donor-".$post[0]['id']."-".$post[0]['pincode']."-".$url_name;
                        
                        $this->session->setFlashdata('report_response', 'success');
                        return redirect()->to("post/$slug");
                    }
                    else {
                        return view('site/error_page');
                    }
                }

            }
            else {
                // send error
                return view('site/error_page');
            }
        }
    }
}

?>