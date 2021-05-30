<?php namespace App\Models;

use CodeIgniter\Model;

class Activities_model extends Model
{
    protected $table      = 'activities';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';

    protected $allowedFields = ['username',
                                'access',
                                'domain',
                                'entity',
                                'act',
                                'time'
                            ];


    // rules apply before insert, update
    protected $validationRules    = [
        'username' => 'required|alpha_numeric',
        'domain' => 'required|in_list[oxygen_supply, bed_availability, tiffin_sevice, plasma_donor, users]',
        'act' => 'required|in_list[added, deleted, updated, promoted, demoted]',
        'access' => 'required|in_list[1,2,3]'
    ];

    protected $skipValidation     = false;


    public function get_oxygen_activities() {
        $res = $this->where('domain', 'oxygen_supply')->orderBy('id', 'desc')->findAll(20);

        for ($i=0; $i < count($res); $i++) {
            $res[$i]['domain'] = "Oxygen Supply";
        }
        return $res;
    }

    public function get_bed_activities() {
        $res = $this->where('domain', 'bed_availability')->orderBy('id', 'desc')->findAll(20);

        for ($i=0; $i < count($res); $i++) {
            $res[$i]['domain'] = "Bed Availability";
        }
        return $res;
    }

    public function get_tiffin_activities() {
        $res = $this->where('domain', 'tiffin_sevice')->orderBy('id', 'desc')->findAll(20);

        for ($i=0; $i < count($res); $i++) {
            $res[$i]['domain'] = "Tiffin Services";
        }
        return $res;
    }

    public function get_plasma_activities() {
        $res = $this->where('domain', 'plasma_donor')->orderBy('id', 'desc')->findAll(20);

        for ($i=0; $i < count($res); $i++) {
            $res[$i]['domain'] = "Plasma Donors";
        }
        return $res;
    }

    public function get_user_activites($user) {
        return $res->where('username', $user)->orderBy('id', 'desc')->findAll(20);
    }


    public function get_last_activities(){
        $res = $this->orderBy('id', 'desc')->findAll(20);

        for ($i=0; $i < count($res); $i++) {
            if($res[$i]['domain'] == "oxygen_supply")
                $res[$i]['domain'] = "Oxygen Supply";
            elseif($res[$i]['domain'] == "bed_availability")
                $res[$i]['domain'] = "Bed Availability";
            elseif($res[$i]['domain'] == "tiffin_sevice")
                $res[$i]['domain'] = "Tiffin Services";
            elseif($res[$i]['domain'] == "plasma_donor")
                $res[$i]['domain'] = "Plasma Donors";
            else
                $res[$i]['domain'] = "No Domain ";
        }
        return $res;
    }

    public function add_activity($domain, $act, $entity) {
        $activity = [
			'username' => session('username'),
			'domain' => $domain,
            'entity' => $entity,
			'act' => $act,
			'access' => session('access')
		];
		$this->insert($activity);
    }

    public function get_all_activities() {
        $res = $this->orderBy('id', 'desc')->findAll(100);

        for ($i=0; $i < count($res); $i++) {
            if($res[$i]['domain'] == "oxygen_supply")
                $res[$i]['domain'] = "Oxygen Supply";
            elseif($res[$i]['domain'] == "bed_availability")
                $res[$i]['domain'] = "Bed Availability";
            elseif($res[$i]['domain'] == "tiffin_sevice")
                $res[$i]['domain'] = "Tiffin Services";
            elseif($res[$i]['domain'] == "plasma_donor")
                $res[$i]['domain'] = "Plasma Donors";
            else
                $res[$i]['domain'] = "No Domain ";
        }
        return $res;
    }

}
