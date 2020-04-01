<?php
	$dataProvinsiIndonesia = file_get_contents("https://opendata.arcgis.com/datasets/0c0f4558f1e548b68a1c82112744bad3_0.geojson");
  $kasusProvinsiIndonesia = json_decode($dataProvinsiIndonesia, TRUE);

  $geojsonProvinsi = file_get_contents("data/provinsi_polygon.geojson");
  $pointProvinsi = json_decode($geojsonProvinsi, TRUE);

  
	foreach ($pointProvinsi['features'] as $key => $first_value) {
    foreach ($kasusProvinsiIndonesia['features'] as $second_value) {
      if($first_value['properties']['Kode_Provi']==$second_value['properties']['Kode_Provi']){
      	$pointProvinsi['features'][$key]['properties']['Kasus_Positif'] = $second_value['properties']['Kasus_Posi'];
        $pointProvinsi['features'][$key]['properties']['Kasus_Sembuh'] = $second_value['properties']['Kasus_Semb'];
        $pointProvinsi['features'][$key]['properties']['Kasus_Meninggal'] = $second_value['properties']['Kasus_Meni'];
    	} else {}
		}
	}
	$combined_output = json_encode($pointProvinsi); 

	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	echo $combined_output;
?>