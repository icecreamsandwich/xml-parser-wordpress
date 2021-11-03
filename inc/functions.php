<?php
//hook to add an item in the menu admin 
add_action('admin_menu', 'my_admin_setup_menu');

function my_admin_setup_menu()
{
    //1st : title of the page, 2nd : title in the menu menu
    add_menu_page('XML parser', 'XML parser', 'manage_options', 'my_admin', 'my_plugin_init');
    add_submenu_page(
        'my_admin', //  Slug of the parent menu item.
        'Parse the xml file', // The page title.
        'Parse xml file', // The submenu title displayed on dashboard.
        'manage_options', // Minimum capability to view the submenu
        'xml-parser-myrm/inc/parse_xml.php' //A callback function used to display page content.
    );
    /* add_submenu_page(
        'my_admin', //  Slug of the parent menu item.
        'Parse the xml file', // The page title.
        'Show parsed data', // The submenu title displayed on dashboard.
        'manage_options', // Minimum capability to view the submenu
        //'set-post-terms', //Unique name used as a slug for submenu item.
        'xml-parser-myrm/inc/show_data.php' //A callback function used to display page content.
    ); */
    add_menu_page( 'my_admin', 'Properties', 'read', 'http://localhost/wordpress-5.7/category/properties/', '', 'dashicons-text', 100 );
}

function my_plugin_init()
{
?>
    <style>
        .menu_items ul{
            width: 300px;
        }
        .menu_items ul>li {
            display: block;
            height: 50px;
            list-style: none;
            border-radius: 5px;
            text-align: center;
        }
        .menu_items ul>li a{
            font-size: 14px;
            text-decoration: none;
            display: block;
        }
        .plugin_btn {
            height: 50px;
            margin-top: 10px;
            border: 2px solid;
            border-radius: 5px;
            width: 300px;
        }
        .plugin_btn:hover{
            background-color: #b5afba; 
        }
    </style>
<?php
$baseUrl = get_bloginfo('wpurl');
    $page_link1 = '<a href="'.$baseUrl.'/wp-admin/admin.php?page=xml-parser-myrm/inc/parse_xml.php">Parse xml data</a>';
    echo "<h2>XML Parser</h2> <br/><br/><br/>";
    //display the link in the main page
    echo '
    <div class="menu_items">
    <ul>
         <li>
            <button class="plugin_btn">' . $page_link1 . '</button>
         </li>
    </ul>
    </div>';
}
