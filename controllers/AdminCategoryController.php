<?php

/**
 * Контроллер AdminCategoryController
 * Управление категориями товаров в админпанели
 */
class AdminCategoryController extends AdminBase {

    /**
     * Action для страницы "Управление категориями"
     */
    public function actionIndex() {
        // Получаем список категорий
        $categories = Category::getCategoriesList();

        // Подключаем вид
        require_once ROOT . '/views/admin_category/index.php';
        return true;
    }

    /**
     * Action для страницы "Удалить категорию"
     */
    public function actionDelete($id) {
        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена
            // Удаляем категорию
            Category::deleteCategory($id);
            // Перенаправляем пользователя на страницу управлениями категориями
            header('Location: /admin/category/');
        }
        require_once ROOT . '/views/admin_category/delete.php';
        return true;
    }

    /**
     * Action для страницы "Добавить категорию"
     */
    public function actionCreate() {

        // Получаем список категорий для выпадающего списка
        $categories = Category::getCategoriesList();
        $options = array();
        // Флаг ошибок в форме
        $errors = false;

        // Обработка формы
        if (isset($_POST['submit'])) {
            // Если форма отправлена
            // Получаем данные из формы
            $options['name'] = $_POST['name'];
            $options['sort_order'] = $_POST['sort_order'];
            $options['status'] = $_POST['status'];

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['name']) || empty($options['name']))
                $errors[] = 'Неправильно введено имя';

            if ($errors === false) {
                // Если ошибок нет, добавляем новую категорию
                Category::createCategory($options);

                // Перенаправляем пользователя на страницу управления товарами
                header('Location: /admin/category/');
            }
        }

        require_once ROOT . '/views/admin_category/create.php';
        return true;
    }

    /**
     * Action для страницы "Редактировать категорию"
     */
    public function actionUpdate($id) {

        // Получаем данные о конкретной категории
        $category = Category::getCategoryById($id);
        $options = array();

        // Флаг ошибок в форме
        $errors = false;
        // Обработка формы
        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['sort_order'] = $_POST['sort_order'];
            $options['status'] = $_POST['status'];

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['name']) || empty($options['name']))
                $errors[] = 'Неправильно введено имя';

            if ($errors === false) {
                // Если ошибок нет, сохраняем изменения 
                Category::updateCategory($options, $id);

                // Перенаправляем пользователя на страницу управления категориями
                header('Location: /admin/category/');
            }
        }

        require_once ROOT . '/views/admin_category/update.php';
        return true;
    }

}
