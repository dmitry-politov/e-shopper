<?php

/**
 * Контроллер CabinetController
 * Кабинет пользователя
 */

class CabinetController {
    
    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionIndex() {
        
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        
        // Получаем ифнормацию о пользователе из БД
        $user = User::getUserById($userId);
        
        // Подключаем вид
        require_once (ROOT.'/views/cabinet/index.php');
        return true;
    }
    
    /**
     * Action для страницы "Редактирование данных пользователя"
     */
    
    public function actionEdit() {
        // Получаем идентификатор пользователя из сессии
        $userId = User::checkLogged();
        
        // Получаем ифнормацию о пользователе из БД
        $user = User::getUserById($userId);

        // Заполняем переменные для полей формы
        $name = $user['name'];
        $password = $user['password'];
        
        // Флаг результата
        $result = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы редактирования
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            // Флаг ошибок
            $errors = false;
            
            // Валидируем значения
            if (!User::checkName($name))
                $errors[] = 'Имя д.б. не короче 2-х символов';

            if (!User::checkPassword($password))
                $errors[] = 'Пароль короче 6 символов';


            if ($errors === false) {
                
                // Если ошибок нет, сохраняем изменения профиля
                $result = User::edit($userId, $name, $password);
            }
        }


        // Подключаем вид
        require_once (ROOT . '/views/cabinet/edit.php');
        return true;
    }

}
