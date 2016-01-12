<?php

/**
 * Контроллер CatalogController
 * Каталог товаров
 */

class CatalogController {
    
    /**
     * Action для страницы "Каталог товаров"
     */


    public function actionIndex() {
        
        // Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();

        // Список последних товаров
        $latestProducts = array();
        $latestProducts = Product::getLatestProducts();
        
        require_once (ROOT.'/views/catalog/index.php');
        return true;
    }

    
    /**
     * Action для страницы "Категория товаров"
     */

    public function actionCategory($categoryId, $page = 1){
        
        // Список категорий для левого меню
        $categories = array();
        $categories = Category::getCategoriesList();
        
        // Список товаров в категории
        $categoryProducts = array();
        $categoryProducts = Product::getProductListByCategory($categoryId, $page);

        // Общее количетсво товаров (необходимо для постраничной навигации)
        $total = Product::getTotalProductsInCategory($categoryId);
       
        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        
        require_once (ROOT.'/views/catalog/category.php');
        return true;
    }
    
}
