<?php
class ProductController extends BaseController
{
    /**
     * "/products/list" Endpoint - Get all products
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if(strtoupper($requestMethod) == 'GET'){
            try {
                $ProductModel = new ProductModel();            
                $arrProducts = $ProductModel->getProducts();
                $responseData = json_encode($arrProducts);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong, please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 unprocessable Entity';
        }

        //send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData, array('Content-Type: application/json',
                'HTTP/1.1 200 OK')
            );
        }else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', $strErrorHeader));
        }
    }
    /**
     * "/products/create" Endpoint - Create new product
     */
    public function createAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        if(strtoupper($requestMethod) == 'POST'){
            try {
                    $sku = htmlspecialchars(strip_tags($_POST['SKU']));
                    $name =htmlspecialchars(strip_tags($_POST['Name']));
                    $value =strip_tags($_POST['Value']);
                    $price = htmlspecialchars(strip_tags($_POST['Price']));
                    $type = htmlspecialchars(strip_tags($_POST['Type']));
                    $ProductModel = new ProductModel();
                    $newProduct = $ProductModel->createProduct($sku, $name, $price, $value, $type);
                    $responseData = json_encode($newProduct);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'. Something went wrong, please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 unprocessable Entity';
        }

        //send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData, array('Content-Type: application/json',
                'HTTP/1.1 200 OK')
            );
        }else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', $strErrorHeader));
        }
    }

    /**
     * "/products/delete" Endpoint - Delete product(s)
     */

     public function removeAction()
     {
         $strErrorDesc = '';
         $requestMethod = $_SERVER["REQUEST_METHOD"];
         if (strtoupper($requestMethod) == 'DELETE') {
             try {
                $data = json_decode(file_get_contents("php://input"));
                $param = $data;
                // var_dump($data);
                $ProductModel = new ProductModel(); 
                $toDelete = "'".implode("','", $param)."'";
                $removeProduct = $ProductModel->deleteProduct($toDelete);
                $responseData = json_encode($removeProduct);                 
                } catch (Error $e) {
                 $strErrorDesc = $e->getMessage().'. Something went wrong, please contact support.';
                 $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
             }
             
         }else {
             $strErrorDesc = 'Method not supported';
             $strErrorHeader = 'HTTP/1.1 422 unprocessable Entity';
         }
              //send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData, array('Content-Type: application/json',
                'HTTP/1.1 200 OK')
            );
        }else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', $strErrorHeader));
        }

     }
}

?>