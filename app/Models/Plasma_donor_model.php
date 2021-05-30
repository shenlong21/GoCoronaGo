<?php namespace App\Models;

use CodeIgniter\Model;

class Plasma_donor_model extends Model
{
    protected $table      = 'plasma_donors';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['name',
                                'phone',
                                'whatsapp',
                                'age',
                                'verification', 
                                'reports',
                                'pincode',
                                'city'];

  
    public function find_plasma_donors_in_city($city) {
        $res = $this->where('city', $city)->findAll();
            $res = $this->where('city', $city)->findAll();
            $time_now = date_create("now");
    
            for ($i=0; $i < count($res); $i++) { 
        
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


    public function find_plasma_donors_with_pin($pin) {
        $res = $this->where('pincode', $pin)->findAll();
            $time_now = date_create("now");
    
            for ($i=0; $i < count($res); $i++) { 
        
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


    public function get_plasma_donors() {
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