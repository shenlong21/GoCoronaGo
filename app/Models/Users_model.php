<?php namespace App\Models;

use CodeIgniter\Model;

class Users_model extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['username', 
                                'name', 
                                'email',
                                'phone', 
                                'password', 
                                'access',
                                'active'
                            ];


    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // rules apply before insert, update
    protected $validationRules    = [
        'username' => 'required|alpha_numeric',
        'name' => 'required|alpha_numeric_space',
        'email' => 'required|valid_email',
        'phone' => 'required',
        'password' => 'required',
        'access' => 'in_list[0,1,2,3]'
    ];


    protected $validationMessages = [
        'username' => [
            'aplha_numeric' => 'Username can only have alphabets and numbers only'
        ],
        'name' => [
            'alpha_numeric_space' => 'Name can only have aplhabets, spaces and number only'
        ]
    ];


    protected $skipValidation     = false;


    // check user if it exists -- used for login 
    public function verify_user($username, $password, $access){

        // check if user with provided credentials
        $user_exist = $this->where('username', $username)
                            ->where('access', $access)
                            ->where('active', 1)
                           ->first();        
        
        // check if username exist
        if(!empty($user_exist))
            if($password === $user_exist['password'])
                return TRUE;
                
        return FALSE;
    }

    // check deactiated
    public function check_deactivated($username, $password){
        $user_exist = $this->select(['username', 'password', 'access'])->where('username', $username)->where('active', 1)->first();

        if( empty($user_exist) )
            return FALSE;
        
        if($user_exist['password'] != $password )
            return FALSE;
        
        if($user_exist['access'] == 0){
            return TRUE;
        }

        return FALSE;
        

    }

    // checks username if exists
    public function check_if_username($username) {
        if(!empty($this->where('username', $username)->first()))
            return TRUE;
        return FALSE;
    }


    // checks email if exists
    public function check_if_email($email) {
        if(!empty($this->where('email', $email)->first()))
            return TRUE;
        return FALSE;
    }


    // checks phone if exists
    public function check_if_phone($phone) {
        if(!empty($this->where('phone', $phone)->first()))
            return TRUE;
        return FALSE;
    }


    public function get_user_details($username) {
        return $this->where('username', $username)->first();
    }


    public function get_all_users() {
        $res = $this->select(['username', 'name', 'email', 'access'])->findAll();

        for( $i = 0; $i < count($res); $i++) {
            // access
            if($res[$i]['access'] == 3){
                $res[$i]['access_level'] = "<i class='fas fa-user-secret fa-2x'></i> Admin";
            }
            elseif($res[$i]['access'] == 2){
                $res[$i]['access_level'] = "<i class='fas fa-user-nurse fa-2x'></i> Moderator";
            }
            elseif($res[$i]['access'] == 1){
                $res[$i]['access_level'] = "<i class='fas fa-user-shield fa-2x'></i> Covid Warrior";
            }
            else{
                $res[$i]['access_level'] = "<i class='fas fa-times-circle fa-2x'></i> Deactivated";
            }
        }

        return $res;

    }

    // return true on successful promotion
    public function promote_user($username) {
        $user = $this->select(['id','username', 'access'])->where('username', $username)->first();

        if(empty($user))
            return FALSE;
        
        $access = $user['access'];
        
        if($access > 2)
            return FALSE;
        
        $access = $access+1;
        
        $data = [
            'access' => $access
        ];

        if($this->update($user['id'], $data))
            return $access;
        
        return FALSE;
    }


    // return access on demotion
    public function demote_user($username) {
        $user = $this->select(['id','username', 'access'])->where('username', $username)->first();

        if(empty($user))
            return FALSE;
        
        $access = $user['access'];
        
        if($access <= 0)
            return FALSE;
        
        $access = $access - 1;


        $data = [
            'access' => $access
        ];

        if($this->update($user['id'], $data))
            return $access;
        else
            return FALSE;
    }

}