<?php

abstract class AdminBase {

    /**
     * Метод, который проверяет пользователя на то, является ли он администратором
     * @return boolean
     */

    public function __construct() {
        
        // Проверяем, авторизирован ли пользователь. Если нет, он будет переадресован.
        $userId = User::checkLogged();

        // Получаем информацию о текущем пользователе
        $user = User::getUserById($userId);

        // Если у роль текущего пользователя "admin", пускаем его в админпанель.
        if ($user['role'] === 'admin')
            return true;
        
        // Иначе завершаем работу с сообщением о закрытом доступе.
        die('Access denied');
    }

}
