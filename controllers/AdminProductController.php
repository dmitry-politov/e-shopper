<?php

/**
 * Контроллер AdminProductController
 * Управление товарами в админпанели
 */
class AdminProductController extends AdminBase {

    /**
     * Action для страницы "Управление товарами"
     */
    public function actionIndex() {
        // Получаем список товаров
        $productsList = Product::getProductList();

        // Подключаем вид
        require_once ROOT . '/views/admin_product/index.php';
        return true;
    }

    /**
     * Action для страницы "Удалить товар"
     */
    public function actionDelete($id) {
        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена
            // Удаляем товар
            Product::deleteProduct($id);

            // Перенаправляем пользователя на страницу управлениями товарами
            header('Location: /admin/product/');
        }

        // Подключаем вид
        require_once ROOT . '/views/admin_product/delete.php';
        return true;
    }

    /**
     * Action для страницы "Добавить товар"
     */
    public function actionCreate() {
        // Получаем список категорий для выпадающего списка
        $categories = Category::getCategoriesList();
        $options = array();
        // Флаг ошибок в форме
        $errors = false;
        // Обработка формы
        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['name']) || empty($options['name']))
                $errors[] = 'Неправильно введено имя';
            if ($errors === false) {
                // Если ошибок нет, добавляем товар
                $id = Product::createProduct($options);

                // Если запись добавлена
                if ($id) {
                    // Проверяем. загружалось ли через форму изображение
                    if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                        // Если загружалось, переместим его в нужную папку, дадим новое имя
                        move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/shop/upload/images/{$id}.jpg");
                    }
                }
                // Перенаправляем пользователя на страницу управления товарами
                header('Location: /admin/product/');
            }
        }
        // Подключаем вид
        require_once ROOT . '/views/admin_product/create.php';
        return true;
    }

    /**
     * Action для страницы "Редактировать товар"
     */
    public function actionUpdate($id) {
        // Получаем список категорий для выпадающего списка
        $categories = Category::getCategoriesList();

        // Получаем данные о конкретном заказе
        $product = Product::getProductById($id);
        $options = array();
        // Флаг ошибок в форме
        $errors = false;
        // Обработка формы
        if (isset($_POST['submit'])) {
            $options['name'] = $_POST['name'];
            $options['code'] = $_POST['code'];
            $options['price'] = $_POST['price'];
            $options['category_id'] = $_POST['category_id'];
            $options['brand'] = $_POST['brand'];
            $options['availability'] = $_POST['availability'];
            $options['description'] = $_POST['description'];
            $options['is_new'] = $_POST['is_new'];
            $options['is_recommended'] = $_POST['is_recommended'];
            $options['status'] = $_POST['status'];

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['name']) || empty($options['name']))
                $errors[] = 'Неправильно введено имя';
            if ($errors === false) {
                // Если ошибок нет, сохраняем изменения
                Product::updateProduct($options, $id);

                // Проверяем. загружалось ли через форму изображение
                if (is_uploaded_file($_FILES['image']['tmp_name'])) {

                    // Если загружалось, переместим его в нужную папку, дадим новое имя
                    move_uploaded_file($_FILES['image']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/upload/images/{$id}.jpg");
                }

                // Перенаправляем пользователя на страницу управления товарами
                header('Location: /admin/product/');
            }
        }
        // Подключаем вид
        require_once ROOT . '/views/admin_product/update.php';
        return true;
    }

}
