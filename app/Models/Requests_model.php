<?php namespace App\Models;

use CodeIgniter\Model;

class Requests_model extends Model
{
    protected $table      = 'requests';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['username', 
                                'message',
                                'created_at'
                            ];


    // rules apply before insert, update
    protected $validationRules    = [
        'username' => 'required|alpha_numeric',
    ];

    protected $skipValidation     = false;

    public function get_requests() {
        $res = $this->select(['requests.username', 'requests.message', 'requests.created_at', 'users.access'])->join('users', 'requests.username = users.username', 'left')->findAll();

        for ($i=0; $i < count($res); $i++) { 
            if($res[$i]['access'] == 3){
                $res[$i]['access'] = "Admin";
            }
            else if($res[$i]['access'] == 2){
                $res[$i]['access'] = "Moderator";
            }
            else if($res[$i]['access'] == 1){
                $res[$i]['access'] = "Covid Warrior";
            }
            else{
                $res[$i]['access'] = "No Access";
            }
        }


        return $res;
    }

    public function check_req($username){
        $res = $this->where('username',$username)->first();
        if(!empty($res))
            return TRUE;
        
        return FALSE;
    }


    // returns true on successful discard
    public function discard_request($username){
        $res = $this->where('username',$username)->first();
        if(!empty($res)){
            $this->delete($res['id']);
            return TRUE;
        }
        return FALSE;
    }

}