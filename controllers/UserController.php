<?php

/**
 * Контроллер UserController
 */
class UserController {

    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin() {
        // Переменные для формы
        $email = '';
        $password = '';

        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkEmail($email))
                $errors[] = 'Неверная форма email';

            if (!User::checkPassword($password))
                $errors[] = 'Пароль короче 6 символов';

            // Проверяем, существует ли пользователь
            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
            } else {
                //Если данные правильные  - запоминаем пользователя (сессия)
                User::auth($userId);

                //Перенаправляем пользователя в закрытую часть - кабинет
                header("Location: /cabinet/");
            }
        }
        require_once (ROOT . '/views/user/login.php');
        return true;
    }

    public function actionLogout() {
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION['user']);
        Cart::clear();
        // Перенаправляем пользователя на главную страницу
        header('Location:/');
    }

    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister() {
        // Переменные для формы
        $name = '';
        $email = '';
        $password = '';
        $result = false;

        if (isset($_POST['submit'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkName($name))
                $errors[] = 'Имя не должно быть короче 2-х символов';

            if (!User::checkEmail($email))
                $errors[] = 'Неправильный email';

            if (!User::checkPassword($password))
                $errors[] = 'Неправильный пароль';

            if (User::checkEmailExist($email))
                $errors[] = 'Такой email уже используется';


            if ($errors == false)
            // Если ошибок нет
            // Регистрируем пользователя
                $result = User::register($name, $email, $password);
        }
        require_once (ROOT . '/views/user/register.php');
        return true;
    }

}
