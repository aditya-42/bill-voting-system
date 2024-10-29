<?php

class UserRepository {
    private $filePath;

    public function __construct() {
        $this->filePath = __DIR__ . '/../data/users.json';
    }

    public function saveUser($user) {
        $users = $this->getAllUsers();
        $users[] = $user;
        file_put_contents($this->filePath, json_encode($users));
    }

    public function findUserByUsername($username) {
        $users = $this->getAllUsers();
        
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        
        return null;
    }

    private function getAllUsers() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        
        $data = file_get_contents($this->filePath);
        return json_decode($data, true) ?? [];
    }
}
?>
