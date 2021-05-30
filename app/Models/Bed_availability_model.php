<?php 

namespace App\Models;

use CodeIgniter\Model;

class Bed_availability_model extends Model
{
    protected $table      = 'bed_availability';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['name', 
                                'address', 
                                'description', 
                                'whatsapp',
                                'phone', 
                                'email', 
                                'bed_available', 
                                'oxygen', 
                                'icu', 
                                'icu_with_ventilator',
                                'verification', 
                                'updated_at', 
                                'created_at', 
                                'reports', 
                                'pincode',
                                'city', 
                                'place'
                                ];


    public function find_bed_availability_in_city($city) {
        $res = $this->where('city', $city)->findAll();

        $time_now = date_create("now");


        for ($i=0; $i < count($res); $i++) { 
            
            // bed available
            if($res[$i]['bed_available'] == 0)
                $res[$i]['bed_available'] = '<span class="badge bg-danger"> No Beds</span>';
            else
                $res[$i]['bed_available'] = '<span class="badge bg-success"> '. $res[$i]['bed_available'] .'</span>';

            // bed with oxygen
            if($res[$i]['oxygen'] == 0)
                $res[$i]['oxygen'] = '<span class="badge bg-danger"> No Bed with oxygen</span>';
            else
                $res[$i]['oxygen    '] = '<span class="badge bg-success"> '. $res[$i]['oxygen'] .'</span>';

            // icu
            if($res[$i]['icu'] == 0)
                $res[$i]['icu'] = '<span class="badge bg-danger"> No ICUs available</span>';
            else
                $res[$i]['icu'] = '<span class="badge bg-success"> '. $res[$i]['icu'] .'</span>';

            // icu
            if($res[$i]['icu_with_ventilator'] == 0)
                $res[$i]['icu_with_ventilator'] = '<span class="badge bg-danger"> No ICUs with ventilator available</span>';
            else
                $res[$i]['icu_with_ventilator'] = '<span class="badge bg-success"> '. $res[$i]['icu_with_ventilator'] .'</span>';


            // verification
            if($res[$i]['verification'] == 0)
                $res[$i]['verification'] = '<span class="badge bg-warning"> <i class="fas fa-mobile"></i> Not Verified</span>';
            else
                $res[$i]['verification'] = '<span class="badge bg-success"> <i class="fas fa-mobile"></i> Phone Verified</span>';

            // updated time
            $updated_time = date_create_from_format("Y-m-d H:i:s", $res[$i]['updated_at']);
            $time_diff = date_diff($updated_time, $time_now, true);

            $res[$i]['ago'] = substr($time_diff->format('%R%a days ago '), 1, -1);
            
            if($res[$i]['ago'] == "0 days ago")
                $res[$i]['ago'] = "Today";            
            if($res[$i]['ago'] == "1 days ago")
                $res[$i]['ago'] = "Yesterday";
            

        }

        return $res;
    }


    public function find_bed_availability_with_pin($pin) {
        $res = $this->where('pincode', $pin)->findAll();
        $time_now = date_create("now");


        for ($i=0; $i < count($res); $i++) { 
            
            // bed available
            if($res[$i]['bed_available'] == 0)
                $res[$i]['bed_available'] = '<span class="badge bg-danger"> No Beds</span>';
            else
                $res[$i]['bed_available'] = '<span class="badge bg-success"> '. $res[$i]['bed_available'] .'</span>';

            // bed with oxygen
            if($res[$i]['oxygen'] == 0)
                $res[$i]['oxygen'] = '<span class="badge bg-danger"> No Bed with oxygen</span>';
            else
                $res[$i]['oxygen'] = '<span class="badge bg-success">'.$res[$i]['oxygen'].'</span>';

            // icu
            if($res[$i]['icu'] == 0)
                $res[$i]['icu'] = '<span class="badge bg-danger"> No ICUs available</span>';
            else
                $res[$i]['icu'] = '<span class="badge bg-success"> '. $res[$i]['icu'] .'</span>';

            // icu
            if($res[$i]['icu_with_ventilator'] == 0)
                $res[$i]['icu_with_ventilator'] = '<span class="badge bg-danger"> No ICUs with ventilator available</span>';
            else
                $res[$i]['icu_with_ventilator'] = '<span class="badge bg-success"> '. $res[$i]['icu_with_ventilator'] .'</span>';


            // verification
            if($res[$i]['verification'] == 0)
                $res[$i]['verification'] = '<span class="badge bg-warning"> <i class="fas fa-mobile"></i> Not Verified</span>';
            else
                $res[$i]['verification'] = '<span class="badge bg-success"> <i class="fas fa-mobile"></i> Phone Verified</span>';

            // updated time
            $updated_time = date_create_from_format("Y-m-d H:i:s", $res[$i]['updated_at']);
            $time_diff = date_diff($updated_time, $time_now, true);

            $res[$i]['ago'] = substr($time_diff->format('%R%a days ago '), 1, -1);
            
            if($res[$i]['ago'] == "0 days ago")
                $res[$i]['ago'] = "Today";            
            if($res[$i]['ago'] == "1 days ago")
                $res[$i]['ago'] = "Yesterday";
            

        }

        return $res;
    }


    public function get_post($id) {
        return $this->where('id', $id)->findAll();
    }


    public function report_post($id) {
        $curr_post = $this->select('reports')->where('id', $id)->find();
        if( !empty($curr_post)) {
            $reports_now = $curr_post[0]['reports'] + 1;
            $this->update($id, ['reports' => $reports_now ]);
            return TRUE;
        }
        return FALSE;    
    }


    public function get_suppliers() {
        $res = $this->findAll();
        $time_now = date_create("now");


        for ($i=0; $i < count($res); $i++) { 

            // reports
            if($res[$i]['reports'] >= 100)
                $res[$i]['reports'] = '<span > '.$res[$i]['reports'].' <i class="fas fa-exclamation-circle"></i></span>';
               

            // 
            $updated_time = date_create_from_format("Y-m-d H:i:s", $res[$i]['updated_at']);
            $time_diff = date_diff($updated_time, $time_now, true);

            $res[$i]['ago'] = substr($time_diff->format('%R%a days ago '), 1, -1);

        }

        return $res;
    }


    // true if entry with this id found
    public function check_id($id){
        return(!empty($this->where('id', $id)->first()));
    }


    public function get_name_from_id($id) {
        return $this->select('name')->where('id', $id)->first();
    }

}