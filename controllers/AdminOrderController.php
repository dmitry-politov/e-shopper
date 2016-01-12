<?php

/**
 * Контроллер AdminOrderController
 * Управление заказами в админпанели
 */
class AdminOrderController extends AdminBase {

    /**
     * Action для страницы "Управление заказами"
     */
    public function actionIndex() {
        // Получаем список заказов
        $orders = Order::getOrderList();

        // Подключаем вид
        require_once ROOT . '/views/admin_order/index.php';
        return true;
    }

    /**
     * Action для страницы "Удалить заказ"
     */
    public function actionDelete($id) {
        // Обработка формы
        if (isset($_POST['submit'])) {

            // Если форма отправлена
            // Удаляем заказ
            Order::deleteOrder($id);
           
            // Перенаправляем пользователя на страницу управлениями товарами
            header('Location: /admin/order/');
        }

        // Подключаем вид
        require_once ROOT . '/views/admin_order/delete.php';
        return true;
    }

    /**
     * Action для страницы "Редактирование заказа"
     */
    public function actionUpdate($id) {

        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);
        $options = array();

        // Флаг ошибок в форме
        $errors = false;

        // Обработка формы
        if (isset($_POST['submit'])) {

            $options['user_name'] = $_POST['user_name'];
            $options['user_phone'] = $_POST['user_phone'];
            $options['user_comment'] = $_POST['user_comment'];
            $options['date'] = $_POST['date'];
            $options['status'] = $_POST['status'];

            // При необходимости можно валидировать значения нужным образом
            if (!isset($options['user_name']) || empty($options['user_name']))
                $errors[] = 'Неправильно введено имя';
            if ($errors === false) {

                // Если ошибок нет, сохраняем изменения
                Order::updateOrder($options, $id);


                // Перенаправляем пользователя на страницу управления заказами
                header('Location: /admin/order/');
            }
        }
        // Подключаем вид
        require_once ROOT . '/views/admin_order/update.php';
        return true;
    }

    /**
     * Action для страницы "Просмотр заказа"
     */
    public function actionView($id) {

        // Получаем данные о конкретном заказе
        $order = Order::getOrderById($id);

        // Получаем массив с идентификаторами и количеством товаров
        $productsInOrder = json_decode($order['products'], true);

        // Получаем массив с ключами товаров
        $productsIds = array_keys($productsInOrder);

        // Получаем список товаров в заказе
        $products = Product::getProductsByIds($productsIds);

        // Подключаем вид
        require_once ROOT . '/views/admin_order/view.php';
        return true;
    }

}
