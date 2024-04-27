<?php

namespace App;

use PDO;
use PDOException;

class UserManagement
{
    private $pdo;
    private $table = 'users';

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($data)
    {
        try {
            // Hash the password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Prepare SQL query to insert a new user
            $sql = "INSERT INTO {$this->table} (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            // Check if the error is due to a duplicate username or email
            if ($e->errorInfo[1] === 1062) {
                Session::set('error','Username or email already exists.');
            } else {
                Session::set('error', $e->getMessage());
            }
        }
    }

    public function read(array $conditions = [], int $page = 1, int $perPage = 10, $searchKey = "")
    {
        try {
            $where = '';
            $params = [];
            if(!empty($conditions)){
                $where = " WHERE ";
                foreach ($conditions as $key => $value) {
                    $where .= "$key = :$key AND ";
                    $params[$key] = trim($value);
                }
            }
            if(!empty($searchKey)){
                    $where .= " WHERE username like :searchKey OR email LIKE :searchKey";
                    $params["searchKey"] = "%$searchKey%";
            }else{
                $where = rtrim($where, 'AND ');
            }

            // Calculate the offset
            $offset = ($page - 1) * $perPage;
    
            // Prepare SQL query with pagination
            $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM {$this->table}";
            if (!empty($where)) {
                $sql .= $where;
            }
            $sql .= " LIMIT :perPage OFFSET :offset";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
            
            foreach ($params as $key => &$value) {
                $stmt->bindParam(":$key", $value, PDO::PARAM_STR);
            }

            $stmt->execute();
    
            // Fetch user data
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $totalCount = $this->pdo->query("SELECT FOUND_ROWS()")->fetchColumn();

            return ['users' => $users, 'totalCount' => $totalCount];
        } catch (PDOException $e) {
            return ['users'=>[],'totalCount'=>0, 'error'=>$e->getMessage()];
        }
    }

    public function update($id, $data)
    {
        try {
            $setData = '';
            $params = [];
            foreach ($data as $key => $value) {
                $setData .= "$key = :$key, ";
                if($key == 'password'){
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                $params[$key] = $value;
            }
            $setData = rtrim($setData, ', ');
            // Prepare SQL query to update an existing user
            $sql = "UPDATE {$this->table} SET {$setData} WHERE id = :id";
        
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id,
                ...$params
            ]);
        } catch (PDOException $e) {
            // Check if the error is due to a duplicate username or email
            if ($e->errorInfo[1] === 1062) {
                Session::set('error','Username or email already exists.');
            } else {
                Session::set('error',$e->getMessage());
            }
        }
    }

    public function delete($id)
    {
        try {
            // Prepare SQL query to update an existing user
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                'id' => $id
            ]);
        } catch (PDOException $e) {
            Session::set('error',$e->getMessage());
        }
    }
}
