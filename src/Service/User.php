<?php


namespace App\Service;


class User
{
    public function createUser($request): bool
    {
        try {
            $result = json_decode(file_get_contents('users.json'), true);
            if ($result && key_exists($request->get('email'), $result)){
                return false;
            }
            $result[$request->get('email')] = $request->get('password');
            $json_data = json_encode($result);
            file_put_contents('users.json', $json_data);
            return true;
        } catch (\Exception $ex) {
            return false;
        }

    }

    public function loginUser($request): bool
    {
        try {
            $result = json_decode(file_get_contents('users.json'), true);
            if ($result[$request->get('email')] == $request->get('password')){
                return true;
            }
            return false;
        } catch (\Exception $ex) {
            return false;
        }
    }
}