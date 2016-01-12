<?php

class Cart {
    
    /**
     * Добавление товара в корзину (сессию)
     * @param int $id <p>id товара</p>
     * @return integer <p>Количество товаров в корзине</p>
     */
    
    public static function addProduct($id) {
        // Приводим $id к типу integer
        $id = intval($id);

        // Инициализируем пустой массив для товаров в корзине
        $productsInCart = array();

        // Если в корзине уже есть товары (они хранятся в сессии)
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }
        //  Проверяем есть ли уже такой товар в корзине 
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else
        // Если нет, добавляем id нового товара в корзину с количеством 1
            $productsInCart[$id] = 1;
        
        // Записываем массив с товарами в сессию
        $_SESSION['products'] = $productsInCart;
        
        // Возвращаем количество товаров в корзине
        return self::cartItems();
    }
    
    /**
     * Удаляет товар с указанным id из корзины
     * @param integer $id <p>id товара</p>
     */
    
    public static function deleteFromCart($id) {
        // Если корзина не пуста и товаров с указанным $id больше одного, удаляем один товар с указанным $id
        if (isset($_SESSION['products']) && $_SESSION['products'][$id] > 1)
            $_SESSION['products'][$id] --;
        // Если корзина не пуста и товар с указанным $id только один, удаляем его из корзины
        elseif (isset($_SESSION['products']) && $_SESSION['products'][$id] = 1);
            unset($_SESSION['products'][$id]);
    }

    /**
     * Подсчет количество товаров в корзине (в сессии)
     * @return int <p>Количество товаров в корзине</p>
     */

    public static function cartItems() {
            // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;

            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else
            // Если товаров нет, вернем 0
            return 0;
    }

    /**
     * Возвращает массив с идентификаторами и количеством товаров в корзине<br/>
     * Если товаров нет, возвращает false;
     * @return mixed: boolean or array
     */

    public static function getProductsInCart() {
        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }
    
    /**
     * Получаем общую стоимость переданных товаров
     * @param array $products <p>Массив с информацией о товарах</p>
     * @return integer <p>Общая стоимость</p>
     */

    public static function getTotalPrice($products) {
        if ($products) {
            $sum = 0;

            // Проходим по переданному в метод массиву товаров
            foreach ($products as $product) {
                // Находим общую стоимость: цена товара * количество товара
                $id = $product['id'];
                $sum = $sum + $product['price'] * self::getProductsInCart()[$id];
            }

            return $sum;
        }
    }

    /**
     * Очищает корзину
     */

    public static function clear() {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }
    
}
