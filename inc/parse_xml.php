<?php
global $wpdb;
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
      $title = $value['title_en'];
      $description = $value['description_en'];
      $image = $value['photo']['url'];
      if ($wpdb->insert("xml_data_customtbl", array(
        "reference_number" => $reference_number,
        "offering_type" => $offering_type,
        "property_type" => $property_type,
        "price_on_application" => $price_on_application,
        "price" => $price,
        "image" => $image,
      ))) {
        echo "<br/>parsing finished.....<br/>";
        echo "data successfully imported to db";
        //create post programmatically
        $my_post = array(
          'post_title'    => $title,
          'post_content'  => $description,
          'post_type'   => 'post',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_category' => array(5)
        );
        // Insert the post into the database
        if ($postId = wp_insert_post($my_post)) {
          echo "<br/>post id=$postId<br/>";
          echo "<br/>featured image : $image<br/>";
          $attach_id = uploadImageFromUrl($image, $postId);
          if (set_post_thumbnail($postId, $attach_id)) {
            echo "<br/>image attached to the post<br/>  ";
          }
          echo "<br/>post created successfully!<br/>";
        }
      }
    }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}


function uploadImageFromUrl($imageURL, $post_id)
{
  include_once(ABSPATH . 'wp-admin/includes/admin.php');
  $file = array();
  $file['name'] = $imageURL;
  $file['tmp_name'] = download_url($imageURL);

  if (is_wp_error($file['tmp_name'])) {
    @unlink($file['tmp_name']);
    var_dump($file['tmp_name']->get_error_messages());
  } else {
    $attachmentId = media_handle_sideload($file, $post_id);

    if (is_wp_error($attachmentId)) {
      @unlink($file['tmp_name']);
      var_dump($attachmentId->get_error_messages());
    }
    echo "<br/> Media uploaded<br/>";
    return $attachmentId;
  }
}
