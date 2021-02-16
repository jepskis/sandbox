<?php
require_once ("class.SimpleXLSX.php");
require_once ("db.settings.php");
require_once ("class.db.php");


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

#write if statement that will check for the model_vendor and model_type and get the ID 

$sql_component_select = "SELECT id FROM m_product_models WHERE model LIKE '%{$component_model}%'";

$insertQuery = "INSERT INTO `m_product_models` (`id`, `model`, `model_std`, `catalog_name`, `pid`, `model_product_category_id`) VALUES (NULL, '{$component_model}', '{$component_model_std}', '{$component_catalog_name}', '{$component_pid}', 1)";


db::get()->query($insertQuery);
#die($insertQuery);
echo "done!";
