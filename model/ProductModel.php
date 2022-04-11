<?php
    require_once PROJECT_ROOT_PATH . "/model/Database.php";

    class ProductModel extends Database{

        public function getProducts()
        {
            return $this -> select("SELECT * FROM product");
        }
        public function createProduct($sku, $name, $price, $value, $type)
        {
            return $this -> insert("INSERT INTO PRODUCT VALUES ('$sku', '$name', '$price', '$value', '$type')");
        }
        public function deleteProduct($params)
        {        
            return $this ->remove("DELETE FROM PRODUCT WHERE SKU IN ($params)");
        }
    }

?>  