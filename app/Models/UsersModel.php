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
        'role_id',
        'added_by',
        'status',

    ];

    protected $useTimestamps = true;


    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'password' => 'permit_empty|min_length[8]',
        'role_id' => 'required|integer',
        'status' => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The name is required.',
            'min_length' => 'The name must be at least 3 characters.',
            'max_length' => 'The name cannot exceed 255 characters.'
        ],
        'email' => [
            'required' => 'The email is required.',
            'valid_email' => 'The email must be valid.',
            'is_unique' => 'The email address is already in use.'
        ],
        'username' => [
            'required' => 'The username is required.',
            'min_length' => 'The username must be at least 3 characters.',
            'max_length' => 'The username cannot exceed 100 characters.',
            'is_unique' => 'The username is already in use.'
        ],
        'password' => [
            'min_length' => 'The password must be at least 8 characters.'
        ],
        'role_id' => [
            'required' => 'The role is required.',
            'integer' => 'The role must be a valid role.'
        ],
        'status' => [
            'required' => 'The status is required.',
            'in_list' => 'The status must be Active or Inactive.'
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
