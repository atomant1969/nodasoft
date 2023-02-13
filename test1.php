<?php

namespace Manager;

class User
{
    const limit = 10;

    /**
     * Возвращает пользователей старше заданного возраста.
     * @param int $ageFrom
     * @return array
     */
    function getUsers(int $ageFrom): array
    {
        $ageFrom = (int)trim($ageFrom);

        return \Gateway\User::getUsers($ageFrom);
    }

    /**
     * Возвращает пользователей по списку имен.
     * @return array
     */
    public static function getByNames(): array
    {

        $hmac = hash_hmac('sha1', $_GET['names'], '2023');

        if($hmac != $_GET['validate']) {
            $users = [];
            $namesurldecode = urldecode($_GET['names']);
            $namesexplode = explode('&', $namesurldecode);

            foreach ($namesexplode as $name) {
                $nameval = explode('=', $name);

                $users[] = \Gateway\User::user($nameval[1]);
            }
        }else{
            die('Access error');
        }


        return $users;
    }

    /**
     * Добавляет пользователей в базу данных.
     * @param $users
     * @return array
     */
    public function users($users): array
    {
        $ids = [];
        \Gateway\User::getInstance()->beginTransaction();
        foreach ($users as $user) {
            try {
                \Gateway\User::add($user['name'], $user['lastName'], $user['age']);
                \Gateway\User::getInstance()->commit();
                $ids[] = \Gateway\User::getInstance()->lastInsertId();
            } catch (\Exception $e) {
                \Gateway\User::getInstance()->rollBack();
            }
        }

        return $ids;
    }
}