<?php

/**
 * Контроллер ProductController
 * Товар
 */


class ProductController {
    /**
     * Action для страницы просмотра товара
     * @param integer $productId <p>id товара</p>
     */

    public function actionView($id) {

        // Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();
        
        // Получаем инфомрацию о товаре
        $product = Product::getProductById($id);
        
        require_once (ROOT.'/views/product/view.php');
        return true;
    }

}