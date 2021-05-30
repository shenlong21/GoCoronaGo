<?php namespace App\Models;

use CodeIgniter\Model;

class Oxygen_supply_model extends Model
{
    protected $table      = 'oxygen_supply';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['name', 'address', 'description','whatsapp', 'phone', 'email', 'verification', 'oxygen_left', 'updated_at', 'created_at', 'reports', 'pincode','city'];

    protected $useTimestamps = true;
    // protected $dateFormat = 'd-M-y : h-i-s a';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';

    // protected $validationRules    = [];
    // protected $validationMessages = [];
    // protected $skipValidation     = false;

    


    public function find_oxygen_suppiers_in_city($city) {
        $res =  $this->where('city', $city)->findAll();
        $time_now = date_create("now");


        for ($i=0; $i < count($res); $i++) { 
            
            // oxygen left
            if($res[$i]['oxygen_left'] == 0)
                $res[$i]['oxygen_left'] = '<span class="badge bg-danger"> <i class="fas fa-lungs"></i> No Oxygen Available</span>';
            elseif($res[$i]['oxygen_left'] == 1)
                $res[$i]['oxygen_left'] = '<span class="badge bg-warning"> <i class="fas fa-lungs"></i> Low Oxygen</span>';
            elseif($res[$i]['oxygen_left'] == 2)
                $res[$i]['oxygen_left'] = '<span class="badge bg-info"> <i class="fas fa-lungs"></i> Average Oxygen Amount</span>';
            elseif($res[$i]['oxygen_left'] == 3)
                $res[$i]['oxygen_left'] = '<span class="badge bg-success"> <i class="fas fa-lungs"></i> Oxygen Available</span>';            
            else
                $res[$i]['oxygen_left'] = '<span class="badge bg-success"> <i class="fas fa-mobile"></i> No Information</span>';


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


    public function find_oxygen_suppiers_with_pin($pin) {
        $res = $this->where('pincode', $pin)->findAll();
        $time_now = date_create("now");

        for ($i=0; $i < count($res); $i++) { 
            
            // oxygen left
            if($res[$i]['oxygen_left'] == 0)
                $res[$i]['oxygen_left'] = '<span class="badge bg-danger"> <i class="fas fa-lungs"></i> No Oxygen Available</span>';
            elseif($res[$i]['oxygen_left'] == 1)
                $res[$i]['oxygen_left'] = '<span class="badge bg-warning"> <i class="fas fa-lungs"></i> Low Oxygen</span>';
            elseif($res[$i]['oxygen_left'] == 2)
                $res[$i]['oxygen_left'] = '<span class="badge bg-info"> <i class="fas fa-lungs"></i> Average Oxygen Amount</span>';
            elseif($res[$i]['oxygen_left'] == 3)
                $res[$i]['oxygen_left'] = '<span class="badge bg-success"> <i class="fas fa-lungs"></i> Oxygen Available</span>';            
            else
                $res[$i]['oxygen_left'] = '<span class="badge bg-success"> <i class="fas fa-mobile"></i> No Information</span>';


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




    // used in admin
    public function get_suppliers() {
        $res = $this->findAll();
        $time_now = date_create("now");


        for ($i=0; $i < count($res); $i++) { 

            // reports
            if($res[$i]['reports'] >= 100)
                $res[$i]['reports'] = '<span > '.$res[$i]['reports'].' <i class="fas fa-exclamation-circle"></i></span>';
               
            // updated time
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




    // users panel use
    // public function oxygen_supply_save($data)

    public function get_name_from_id($id) {
        return $this->select('name')->where('id', $id)->first();
    }


}