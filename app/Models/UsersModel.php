<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'email',
        'username',
        'password',
        'roleId',
        'parentId',
        'addedBy',
        'status',
        'authType',
        'createdAt',
        'passwordUpdated',
        'updatedAt',
        'deletedAt',
        'operatorId',
        'partnerId',
        'countryId'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'createdAt';
    protected $updatedField = 'updatedAt';
    protected $deletedField = 'deletedAt';

    protected $validationRules = [
        //        'name' => 'required|min_length[3]|max_length[255]',
//        'email' => 'required|valid_email|is_unique[users.email,users.id,{userId}]',
//        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,users.id,{userId}]',
//        'password' => 'permit_empty|min_length[8]',
//        'roleId' => 'required|integer',
//        'status' => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'The email address is already in use.',
        ],
        'username' => [
            'is_unique' => 'The username is already in use.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Custom method to find user by email.
     */

    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verifyPassword($input, $hash)
    {
        return true;
        return password_verify($input, $hash);
    }

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function getUserWithRole($username)
    {
        return $this->select('users.*, roles.roleName')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.username', $username)
            ->orWhere('users.email', $username)
            ->first();
    }

    public function loginInfo($username)
    {
        return $this->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->where('users.status', 'active')
            ->where('users.username', $username)
            ->orWhere('users.email', $username)
            
            ->first();
    }

    public function usersDataTableList($params)
    {
        $length = isset($params['length']) && is_numeric($params['length']) ? (int) $params['length'] : 10;
        $start = isset($params['start']) && is_numeric($params['start']) ? (int) $params['start'] : 0;

        $builder = $this->join('roles', 'roles.id = users.role_id', 'left')
            ->join('operators', 'users.operatorId = operators.id', 'left')
            ->select('users.name,
             users.email,
              DATE_FORMAT(users.createdAt, "%d-%m-%Y") as createdAt,
            users.id as userId,
            CONCAT(operators.operatorName, " - ", operators.shortCode) as operatorName,
             roles.roleName');

        if (!empty($params['search']['value'])) {
            $searchValue = $params['search']['value'];
            $builder->groupStart()
                ->like('users.name', $searchValue)
                ->orLike('users.email', $searchValue)
                ->orLike('roles.roleName', $searchValue)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $users = $builder->orderBy('users.id', 'DESC')
            ->limit($length, $start)
            ->findAll();

        $total = $this->countAll();

        return [
            'users' => $users,
            'total' => $total,
            'totalFiltered' => $totalFiltered,
        ];

    }

    public function operatorUsersDataTableList($params)
    {
        $this->where('operatorId', session()->get('loggedIn')['operatorId']);
        $length = isset($params['length']) && is_numeric($params['length']) ? (int) $params['length'] : 10;
        $start = isset($params['start']) && is_numeric($params['start']) ? (int) $params['start'] : 0;

        $builder = $this->join('roles', 'roles.id = users.role_id', 'left')->select('users.name, users.email, DATE_FORMAT(users.createdAt, "%d-%m-%Y") as createdAt,users.id as userId, roles.roleName')
            ->where([
                'operatorId' => session()->get('loggedIn')['operatorId']
            ]);


        if (!empty($params['search']['value'])) {
            $searchValue = $params['search']['value'];
            $builder->groupStart()
                ->like('users.name', $searchValue)
                ->orLike('users.email', $searchValue)
                ->orLike('roles.roleName', $searchValue)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $users = $builder->orderBy('users.id', 'DESC')
            ->limit($length, $start)
            ->findAll();

        $total = $this->countAllResults();

        return [
            'users' => $users,
            'total' => $total,
            'totalFiltered' => $totalFiltered,
        ];

    }

    public function getOperatorUsersCount($operatorId)
    {
        return $this->where('operatorId', $operatorId)->countAllResults();
    }

    public function getPartnersOperators()
    {
        $length = isset($params['length']) && is_numeric($params['length']) ? (int) $params['length'] : 10;
        $start = isset($params['start']) && is_numeric($params['start']) ? (int) $params['start'] : 0;

        $builder = $this->join('roles', 'roles.id = users.role_id', 'left')
            ->join('operators', 'users.operatorId = operators.id', 'left')
            ->select('users.name,
             users.email,
              DATE_FORMAT(users.createdAt, "%d-%m-%Y") as createdAt,
            users.id as userId,
            CONCAT(operators.operatorName, " - ", operators.shortCode) as operatorName,
             roles.roleName');

        if (!empty($params['search']['value'])) {
            $searchValue = $params['search']['value'];
            $builder->groupStart()
                ->like('users.name', $searchValue)
                ->orLike('users.email', $searchValue)
                ->orLike('roles.roleName', $searchValue)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $users = $builder->orderBy('users.id', 'DESC')
            ->limit($length, $start)
            ->findAll();

        $total = $this->countAll();

        return [
            'users' => $users,
            'total' => $total,
            'totalFiltered' => $totalFiltered,
        ];
    }
}
