<?php

require_once 'conect.php';



class ImportProduct
{

    public function getProductForId($data)
    {
        $cURL = curl_init();

        $param = http_build_query($data);

        $url = 'http://localhost/002/convert-db/public/api/groups/'.$param.'?api_token=p2lbgWkFrykA4QyUmpHihzmc5BNzIABq';

        //var_dump($param);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL, CURLOPT_URL, $url);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL, CURLOPT_HTTPGET, true);

        curl_setopt($cURL, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

        $result = curl_exec($cURL);

        curl_close($cURL);

        return $result;
    }
}

$productId = new ImportProduct();
$param = $_GET;
$products = json_decode($productId->getProductForId($param));


/*
  *
  =============================================================
          Show All product API
  =============================================================
  *
  */

foreach ($products as $key => $product) {

    $val = [
        'product_id' => $product->id,
        'group_id' => $product->group_id,
        'category_id' => $product->category_id,
        'locale' => $product->locale,
        'robots_id' => $product->robots_id,
        'slug' => $product->slug,
        'name' => $product->name,
        'meta_title' => $product->meta_title,
        'meta_description' => $product->meta_description,
        'seo_description' => $product->seo_description,
        'uuid' => $product->uuid,
        'price' => $product->price,
        'min_price' => $product->min_price,
        'package' => $product->package,
        'package_type' => $product->package_type,
        'dosage' => $product->dosage,
    ];

    $value[] = json_decode(json_encode($val, JSON_FORCE_OBJECT));

}


for ($i = 0; $i < count($products); $i++) {

    /*
    *
    =============================================================
        Old - Or - New Product
    =============================================================
    *
    */
    $sql_name = "SELECT product_id, name FROM oc_product_description WHERE name = :name ";

    $name_old = $connection->prepare($sql_name);
    $name_old->bindParam(':name', $value[$i]->name);

    $name_old->execute();
    $row = $name_old->fetch();

    if ($value[$i]->name == $row['name']) {

        $sql_option = "SELECT * FROM oc_product_option WHERE product_id = :product_id ";
        $id_option = $connection->prepare($sql_option);
        $id_option->bindParam(':product_id', $row['product_id']);
        $id_option->execute();
        $option_row = $id_option->fetch();

        if($option_row['option_id'] == 15  || $option_row['product_id'] == $row['product_id']) {

        } else {
            /* Add new Option Value */
            $add_option_15 = "INSERT INTO `oc_product_option`( `product_id`, `option_id`, `required`) VALUES (:product_id ,:option_id ,:required )";

            $stmt_3 = $connection->prepare($add_option_15);
            $stmt_3->bindValue(':product_id', $row['product_id']);
            $stmt_3->bindValue(':option_id', 15);
            $stmt_3->bindValue(':required', 1);
            $stmt_3->execute();

            echo ('++ option '.$row['name']).' Add new Option Value 15 '.'<br />';
        }

        if($option_row['option_id'] == 16  || $option_row['product_id'] == $row['product_id']) {

        } else {
            /* Add new Option Value */
            $add_option_16 = "INSERT INTO `oc_product_option`( `product_id`, `option_id`, `required`) VALUES (:product_id ,:option_id ,:required )";

            $stmt_4 = $connection->prepare($add_option_16);
            $stmt_4->bindValue(':product_id', $row['product_id']);
            $stmt_4->bindValue(':option_id', 16);
            $stmt_4->bindValue(':required', 1);
            $stmt_4->execute();

            echo ('++ option '.$row['name']).'Add new Option Value 16 '.'<br />';
        }


        if ($row['product_id'] == $option_row['product_id']) {

            /* Add new Option*/

            $sql_option_value = "SELECT * FROM oc_product_option p LEFT JOIN oc_option_value_description pd ON (p.option_id = pd.option_id) WHERE p.product_id = :product_id AND pd.name = :name ";
            $id_option = $connection->prepare($sql_option_value);
            $id_option->bindParam(':product_id', $option_row['product_id']);
            $id_option->bindParam(':name', $value[$i]->package);
            $id_option->execute();
            $option_value_row = $id_option->fetch();

            var_dump($option_value_row);


            $product_option_value = "SELECT * FROM oc_product_option_value WHERE product_id = :product_id AND price = :price";
            $product_option = $connection->prepare($product_option_value);
            $product_option->bindParam(':product_id', $option_row['product_id']);
            $product_option->bindParam(':price', $value[$i]->price);
            $product_option->execute();
            $product_value_row = $product_option->fetch();

            if($product_value_row['price'] == $value[$i]->price || $product_value_row['product_id'] == $option_row['product_id']) {

            } else {

            //var_dump($option_value_row);
             $add_option_value = "INSERT INTO `oc_product_option_value`( `product_option_id`, `product_id`, `option_id`, `option_value_id` , `quantity`, `subtract`, `price`, `price_prefix`, `points`, `points_prefix`, `weight`, `weight_prefix`) VALUES (:product_option_id, :product_id, :option_id, :option_value_id, :quantity, :subtract, :price , :price_prefix, :points, :points_prefix, :weight , :weight_prefix )";

            $option_value = $connection->prepare($add_option_value);
            $option_value->bindValue(':product_option_id', $option_value_row['product_option_id']);
            $option_value->bindValue(':product_id', $option_row['product_id']);
            $option_value->bindValue(':option_id', $option_value_row['option_id']);
            $option_value->bindValue(':option_value_id', $option_value_row['option_value_id']);
            $option_value->bindValue(':quantity', 100 );
            $option_value->bindValue(':subtract', 1 );
            $option_value->bindValue(':price', $value[$i]->price);
            $option_value->bindValue(':price_prefix', '+');
            $option_value->bindValue(':points', 0);
            $option_value->bindValue(':points_prefix', '+');
            $option_value->bindValue(':weight',  '0.00000000');
            $option_value->bindValue(':weight_prefix', '+');

            $option_value->execute();

            echo ('+++ option '.$row['name']).' Add new Option '.'<br />';
            }
        } else {

        }




        $text = ($connection->lastInsertId().')  '.' --- '.$value[$i]->name);
        echo $text.'<br /><br /><br />';

    } else {

        /*
        *
        =============================================================
                Add new product in DataBase
        =============================================================
        *
        */
        $sql = "INSERT INTO oc_product ( model, quantity , image , price , status ,date_added, date_modified) VALUES (  :model, :quantity , :image , :price ,:status , :date_added, :date_modified)";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':model', $value[$i]->uuid);
        $stmt->bindValue(':quantity', '1000');
        $stmt->bindValue(':image', 'catalog/demo/product/'.$value[$i]->group_id.'-min.jpg');
        $stmt->bindValue(':price', $value[$i]->price);
        $stmt->bindValue(':status', '1');
        $stmt->bindValue(':date_added', '2019-08-29 10:10:10');
        $stmt->bindValue(':date_modified', '2019-08-29 11:11:11');
        $stmt->execute();

        $text = ($connection->lastInsertId().')  '.' ++ '.$value[$i]->name);
        echo $text.'<br />';
        $rows = $connection->lastInsertId();

        /*
        *
       =============================================================
               Add description product
       =============================================================
       *
       */

        $sql2 = "INSERT INTO oc_product_description ( product_id, language_id, name, description, meta_title, meta_description) VALUES ( :product_id, :language_id, :name, :description, :meta_title, :meta_description )";

        $stmt_2 = $connection->prepare($sql2);

        $stmt_2->bindValue(':product_id', $rows);
        if ($value[$i]->locale = 'en') {
            $stmt_2->bindValue(':language_id', '1');
        } elseif ($value[$i]->locale = 'de') {
            $stmt_2->bindValue(':language_id', '2');
        } else {
            $stmt_2->bindValue(':language_id', '3');
        }
        $stmt_2->bindValue(':name', $value[$i]->name);
        $stmt_2->bindValue(':description', $value[$i]->meta_description);
        $stmt_2->bindValue(':meta_title', $value[$i]->meta_title);
        $stmt_2->bindValue(':meta_description', $value[$i]->meta_description);

        $stmt_2->execute();

        echo ('++ option '.$row['name']). ' Add description product' . '<br />';
    }

}
