<?php
require_once ("class.SimpleXLSX.php");
require_once ("db.settings.php");
require_once ("class.db.php");

// create connection

$connection = mysqli_connect('localhost', 'root', '123456', 'streamliner');

if(mysqli_connect_errno()){
	echo 'failed to connect to mysql' . mysqli_connect_errno();
}

$target_file = "Missing.Adapters.in.Streamliner.-.2.xlsx";

$excelSpreadsheet = SimpleXLSX::parse($target_file);

$adapters_data = $excelSpreadsheet->rows(0);

unset ($adapters_data[0]);

foreach ($adapters_data as $adapter_owners_info)
{
	$component_model = $adapter_owners_info[0];
	$component_model_std = $adapter_owners_info[1];
	$component_catalog_name = $adapter_owners_info[2];
	$component_pid = $adapter_owners_info[3];
	$component_model_category_id = 1; # 1 = adapters
}

#echo '<pre>' . print_r($adapters_data, true) . '</pre>';

#print($component_model_category_id);

$insertQuery = "INSERT INTO `m_product_models` (`id`, `model`, `model_std`, `catalog_name`, `pid`, `model_product_category_id`) VALUES (NULL, '{$component_model}', '{$component_model_std}', '{$component_catalog_name}', '{$component_pid}', 1)";


db::get()->query($insertQuery);
/*
if(mysqli_query($connection, $insertQuery)){
	echo 'success!';
} else {
	echo 'error!';
}
*/
#die($insertQuery);
