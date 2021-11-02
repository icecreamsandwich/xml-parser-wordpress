<?php
global $wpdb;
/* $path = preg_replace('/wp-content.*$/', '', __DIR__);
include_once($path . 'wp-load.php');
include_once($path . 'wp-config.php'); */
$xml = simplexml_load_file(WP_PLUGIN_DIR . "/xml-parser-myrm/inc/sample.xml");
$json_string = json_encode($xml);
$parsed__xml = json_decode($json_string, TRUE);
if ($xml === false) {
  echo "Failed loading XML: ";
  foreach (libxml_get_errors() as $error) {
    echo "<br>", $error->message;
  }
} else {
  echo "<br/>parsing file.....<br/>";
  try {
    foreach ($parsed__xml as $key => $value) {
      $reference_number = $value['reference_number'];
      $offering_type = $value['offering_type'];
      $property_type = $value['property_type'];
      $price_on_application = $value['price_on_application'];
      $price = $value['price'];

      $wpdb->insert("xml_data_customtbl", array(
        "reference_number" => $reference_number,
        "offering_type" => $offering_type,
        "property_type" => $property_type,
        "price_on_application" => $price_on_application,
        "price" => $price,
      ));
      if($wpdb->insert_id){
        echo "<br/>parsing finished.....<br/>";
        echo "data successfully imported to db";
      }
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
