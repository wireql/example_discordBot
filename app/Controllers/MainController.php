<?php

namespace Application\Controllers;

use Application\Models\User;

class MainController {

    public static function checkAuth($user_id = null, $guild_id = null) {

        $result = new User();
        
        return $result->checkAuth($user_id, $guild_id);

    }

    public static function getUserInfo($user_id = null) {
        
        $result = new User();
        $user = $result->getUserInfo($user_id);

        if($user['code'] == 200) {
            return [
                "data" => $user['data']
            ];
        }
        
        return [
            "data" => null
        ];
        
    }

}