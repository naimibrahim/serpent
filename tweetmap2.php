<?php
//start session
session_start(); 
//check user login ke tak
if (isset($_SESSION['loggedin-**(&WJQU*STKLSPQUWQW']) && $_SESSION['loggedin-**(&WJQU*STKLSPQUWQW'] == true) {
  // $keyword = $_GET['k'];
$temp_id = new MongoId($_SESSION["id"]) ;
include('db_config.php');
$collection = $db->users_posts; //select collection (table) users_post
$collection2 = $db->posts; //select collection (table) dari posts
   
// $term = array('geo' => 'ne:null' ); //pilih search term dari keyword yang dihantar melalui GET
$term = array('geo' => array('$ne' => null) ); //pilih search term dari keyword yang dihantar melalui GET
// $term += array('sentimen' => array('$exists' => false)); //hanya paparkan yang tiada sentimen
$cursor = $collection2->find($term); //cursor utk users_post
$cursor_count = $collection2->count($term); //cursor utk users_post
   $cursor->limit(25);
   echo $cursor_count;
   print_r($cursor);
   foreach ($cursor as $document) {
                    // $term2 = array('_id' => $document["postId"]); //pilih search term dari keyword yang dihantar melalui GET
						// print "<pre>";
						// var_dump($term2);
						// print "</pre>";
					// $cursor2 = $collection2->find($term2); //cursor utk posts
					// foreach ($cursor2 as $document2) {
						/* print "<pre>";
						print_r($document);
						print "</pre>"; */
						
						echo $document['coordinates']['coordinates'][0];
						echo "<br>";
						echo $document['coordinates']['coordinates'][1];
						echo "<br>";
					// }
   
   }
   // exit;
// }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Heatmaps</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        background-color: #fff;
        border: 1px solid #999;
        left: 25%;
        padding: 5px;
        position: absolute;
        top: 10px;
        z-index: 5;
      }
    </style>
  </head>

  <body>
    <div id="floating-panel">
      <button onclick="toggleHeatmap()">Toggle Heatmap</button>
      <button onclick="changeGradient()">Change gradient</button>
      <button onclick="changeRadius()">Change radius</button>
      <button onclick="changeOpacity()">Change opacity</button>
    </div>
    <div id="map"></div>
    <script>

      // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">

      var map, heatmap;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 3.1390, lng: 101.6869},
          mapTypeId: 'satellite'
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });
      }

      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }

      // Heatmap data: 500 Points
      function getPoints() {
        return [
			<?php
			$i = 0;
					foreach ($cursor as $document) {
						$i++;
							// $term2 = array('_id' => $document["postId"]); //pilih search term dari keyword yang dihantar melalui GET
								// print "<pre>";
								// var_dump($term2);
								// print "</pre>";
							// $cursor2 = $collection2->find($term2); //cursor utk posts
							// foreach ($cursor2 as $document2) {
								/* print "<pre>";
								print_r($document);
								print "</pre>"; */
								
								// echo $document['coordinates']['coordinates'][0];
								// echo $document['coordinates']['coordinates'][1];
							// }
		   
					
          // new google.maps.LatLng(37.782551, -122.445368),

		  
		  echo "new google.maps.LatLng(". $document['coordinates']['coordinates'][1] .", " . $document['coordinates']['coordinates'][0] . ")" . ($i != $cursor_count ? ',' : '') . PHP_EOL;
		}
		  ?>
          
        ];
      }
    </script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrnQ1j8mX_uTzEFSQWkKEl3D8sPZcvZ8U&libraries=visualization&callback=initMap">
    </script>
  </body>
</html>
<?php } ?>	
