<?php

namespace Application\Models;

use Application\DataBase\DB;
use PDO;

class User {

    private $db;

    public function __construct() {
        $this->db = new DB();
    }

    public function checkAuth($user_id, $guild_id) {
        try {
            $stmt = $this->db->db->prepare("SELECT * FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(!isset($result[0])) {

                $stmt = $this->db->db->prepare("INSERT INTO users (user_id, chat_id) VALUES (?, ?)");
                $stmt->execute([$user_id, $guild_id]);
                
                return [
                    "code" => 201
                ];
                

            }else {

                $stmt = $this->db->db->prepare("UPDATE users SET message_count = ? WHERE user_id = ?");
                $stmt->execute([$result[0]['message_count'] + 1, $user_id]);


                return [
                    "code" => 200
                ];
            }

        } catch (\Throwable $th) {
            return [
                "message" => "Something error: " . $th->getMessage()
            ];
        }
    }

    public function getUserInfo($user_id) {
        try {
            $stmt = $this->db->db->prepare("SELECT * FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if(isset($result[0])) {

                return [
                    "code" => 200,
                    "data" => $result[0]
                ];

            }else {

                return [
                    "code" => 404
                ];

            }

        } catch (\Throwable $th) {
            return [
                "message" => "Something error: " . $th->getMessage()
            ];
        }
    }

}