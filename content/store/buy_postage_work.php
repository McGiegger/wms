<?php
include('system_load.php');

$important  = new ImportantFunctions();
$product = new Product();
$totalQuantities = 0;
$storeName = null;
if (isset($_GET['assign_id']) && isset($_GET['cart_id'])) {
    $assignId = $_GET['assign_id'];
    $cartId = $_GET['cart_id'];
    $assignResponse = ($important->getDataThroughAssignId($assignId));
    if ($assignResponse == null) {
        return 'Something bad happend, Please try again later';
    }
    $orderId = ($important->getDataThroughAssignId($assignId)['order_id']);
    $cartData = $important->getDataThroughCartAssigning($cartId);
    if ($cartData == null)
        return 'Something really bad happend';

    $response = $important->CallAPI('GET', "orders/" . $orderId);

    // $storeName = $response->order_source->order_source_nickname;
    $storeID = $response->advancedOptions->storeId;
    $skus = array();
    foreach ($response->items as $key => $value) {
        $skus[] =  $value->sku;
        $id =   $product->get_product_info_through_sku($value->sku, 'product_id');
        $important->add_inventory(0, $value->quantity, $id);
        $totalQuantities += $value->quantity;
    }






    $date = date('Y-m-d H:i:s');
    $carrierID =  $cartData['carrier_id'];
    $serviceID = $cartData['service_code'];
    $shipDate = $date;
    $totalWeight = $cartData['total_weight'];
    $printLabelObjecst = "{\n  \"orderId\": $orderId,\n  \"carrierCode\": \"$carrierID\",\n  \"serviceCode\": \"$serviceID\",\n  \"packageCode\": \"package\",\n  \"confirmation\": \"none\",\n  \"shipDate\": \"$shipDate\",\n  \"weight\": {\n    \"value\": \"$totalWeight\",\n    \"units\": \"ounces\"\n  },\n  \"dimensions\": null,\n  \"insuranceOptions\": null,\n  \"internationalOptions\": null,\n  \"advancedOptions\": null,\n  \"testLabel\":\"false\"\n}";

    $response =  $important->CallAPI('POST', 'orders/createlabelfororder', ($printLabelObjecst));

    if ($response->ExceptionMessage) {
        echo '<div class="alert alert-danger">';
        echo $response->ExceptionMessage;
        echo '</div>';
        return;
    }





    // $important->storeOwes($assignResponse['order_no'], $storeName, $response->shipment_cost->amount, $totalQuantities);


    //Decode pdf content
    $pdf_decoded = base64_decode($response->labelData);
    $pdf = fopen($response->shipmentId . '.pdf', 'w');
    fwrite($pdf, $pdf_decoded);

    $file = $response->shipmentId . '.pdf';

    $pathname = $file;
    $important->storeShippingLabelInfo($response->label_id, $response->shipmentId, $response->shipDate, $response->trackingNumber, $pathname, $assignId, $assignResponse['order_no'], $response->shipmentCost, $storeID);
    HEADER('LOCATION: finished_orders.php?message=success');
}
