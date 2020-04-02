<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Menampilkan data json menjadi peta dalam kasus data COVID-19 dengan sumber dari https://api.kawalcorona.com">
  <meta name="author" content="unsorry">

  <link href="https://unsorry.net/assets-date/images/favicon.png" rel="shortcut icon" type="image/png">
  <title>Polygon Provinsi</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css">
  <link rel="stylesheet" href="assets/lib/Leaflet.Basemap/L.Control.Basemaps.css">
  <link rel="stylesheet" href="assets/app.css">
</head>
<body>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
  <script src="assets/lib/Leaflet.Basemap/L.Control.Basemaps-min.js"></script>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#"><i class="fas fa-map-marker-alt"></i> Kasus Covid-19</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fas fa-map-marked-alt"></i> Centroid Provinsi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboardcircleprovinsi.php"><i class="fas fa-circle"></i></i> Circle Provinsi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" data-toggle="modal" data-target="#infoModal"><i class="fas fa-info-circle"></i> Info</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Modal -->
  <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark text-light">
          <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-info-circle"></i> Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card alert-dark p-3">
            Peta ini menggunakan data kasus COVID-19 dari <a href="https://bnpb-inacovid19.hub.arcgis.com/datasets/covid19-indonesia-per-provinsi/" target="_blank">https://bnpb-inacovid19.hub.arcgis.com/datasets/covid19-indonesia-per-provinsi/</a> yang digabungkan dengan file <a href="data/provinsi_polygon.geojson" target="_blank">provinsi_polygon.geojson</a> menggunakan PHP menjadi geojson layer baru berupa <a href="geojson_polygon.php" target="_blank">geojson_polygon.php</a> yang secara otomatis ketika ada perubahan data dari <a href="https://bnpb-inacovid19.hub.arcgis.com/datasets/covid19-indonesia-per-provinsi/" target="_blank">https://bnpb-inacovid19.hub.arcgis.com/datasets/covid19-indonesia-per-provinsi/</a> maka info kasus positif, kasus sembuh, dan kasus meninggal akan otomatis berubah.<br>
            Klasifikasi jumlah kasus mengikuti klasifikasi dari BNPB.
            <hr>
            <a href="https://github.com/anshori/geojsoncombine-corona" type="button" class="btn btn-primary btn-sm btn-block" target="_blank"><i class="fab fa-github"></i> Source Code</a>
          </div>
        </div>
        <div class="modal-footer">
            <div class="col text-left">
              <a class="btn btn-link btn-sm" type="button" href="https://unsorry.net" target="_blank">unsorry@2020</a>
            </div>
            <div class="col text-right">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row row-map">
      <div class="col-sm">
        <div id="map"></div>
      </div>
    </div>
    <div class="row row-info">
      <?php
        $dataProvinsiIndonesia = file_get_contents("https://opendata.arcgis.com/datasets/0c0f4558f1e548b68a1c82112744bad3_0.geojson");
        $kasusProvinsiIndonesia = json_decode($dataProvinsiIndonesia, TRUE);

        $totalpositif = 0;
        $totalsembuh = 0;
        $totalmeninggal = 0;

        foreach($kasusProvinsiIndonesia['features'] as $item){
          $totalpositif += $item['properties']['Kasus_Posi'];
          $totalsembuh += $item['properties']['Kasus_Semb'];
          $totalmeninggal += $item['properties']['Kasus_Meni'];
        }
      ?>
      <div class="col-sm-4 text-center text-warning bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-sad-tear fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL POSITIF</strong></h5>
            <h5><?php echo $totalpositif; ?> orang</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4 text-center text-success bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-smile fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL SEMBUH</strong></h5>
            <h5><?php echo $totalsembuh; ?> orang</h5>
          </div>
        </div>
      </div>
      <div class="col-sm-4 text-center text-danger bg-dark">
        <div class="row p-3">
          <div class="col-3">
            <i class="far fa-frown fa-4x"></i>
          </div>
          <div class="col text-left">
            <h5><strong>TOTAL MENINGGAL</strong></h5>
            <h5><?php echo $totalmeninggal; ?> orang</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    /* Initial Map */
    var map = L.map('map').setView([-2.4058653,117.5021489],5);

    var _attribution = '<a href="https://unsorry.net" target="_blank">unsorry@2020</a>';
    
    /* Tile Basemap */
    var basemaps = [
      L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'ESRI | ' + _attribution
      }),
      L.tileLayer('https://{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3'],
        attribution: 'Google | ' + _attribution
      }),
      L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3'],
        attribution: 'Google | ' + _attribution
      }),
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'OSM | ' + _attribution
      }),
    ];

    /* GeoJSON Polygon */
    var kasuscorona = L.geoJson(null, {
      style: function (feature) {
        if (feature.properties.Kasus_Positif <= 5) {
          return {
            opacity: 1,
            color: 'gray',
            weight: 1.0,
            fillOpacity: 0.8,
            fillColor: 'rgb(254, 242, 0)'
          }
        }
        else if (feature.properties.Kasus_Positif >= 6 && feature.properties.Kasus_Positif <= 19) {
          return {
            opacity: 1,
            color: 'gray',
            weight: 1.0,
            fillOpacity: 0.8,
            fillColor: 'rgb(195, 187, 34)'
          }
        }
        else if (feature.properties.Kasus_Positif >= 20 && feature.properties.Kasus_Positif <= 50) {
          return {
            opacity: 1,
            color: 'gray',
            weight: 1.0,
            fillOpacity: 0.8,
            fillColor: 'rgb(244, 132, 32)'
          }
        }
        else if (feature.properties.Kasus_Positif > 50) {
          return {
            opacity: 1,
            color: 'gray',
            weight: 1.0,
            fillOpacity: 0.8,
            fillColor: 'rgb(221, 77, 87)'
          }
        }
        else {
          return {
            opacity: 1,
            color: 'gray',
            weight: 1.0,
            fillOpacity: 0.8,
            fillColor: 'rgb(37, 150, 210)'
          }
        }
      },
      onEachFeature: function (feature, layer) {
        var content = "<div class='card'>" +
          "<div class='card-header alert-primary text-center p-1'><strong>Provinsi<br>" + feature.properties.PROV + "</strong></div>" +
          "<div class='card-body p-0'>" +
            "<table class='table table-responsive-sm m-0'>" +
              "<tr><th><i class='far fa-sad-tear'></i> Kasus Positif</th><th>" + feature.properties.Kasus_Positif + "</th></tr>" +
              "<tr class='text-success'><th><i class='far fa-smile'></i> Kasus Sembuh</th><th>" + feature.properties.Kasus_Sembuh + "</th></tr>" +
              "<tr class='text-danger'><th><i class='far fa-frown'></i> Kasus Meninggal</th><th>" + feature.properties.Kasus_Meninggal + "</th></tr>" +
            "</table>" +
          "</div>";          
        layer.on({
          mouseover: function (e) {
            var layer = e.target;
            layer.setStyle({
              weight: 1,
              color: "gray",
              opacity: 1,
              fillColor: "#00FFFF",
              fillOpacity: 0.8,
            });
            kasuscorona.bindTooltip("Prov. " + feature.properties.PROV + "<br>Jumlah kasus: " + feature.properties.Kasus_Positif, {sticky: true});
          },
          mouseout: function (e) {
            kasuscorona.resetStyle(e.target);
            map.closePopup();
          },
          click: function (e) {
            kasuscorona.bindPopup(content);
          }
        });
      }
    });
    $.getJSON("geojson_polygon.php", function (data) {
      kasuscorona.addData(data);
      map.addLayer(kasuscorona);
      map.fitBounds(kasuscorona.getBounds());
    });

    /* Legenda */
    var legend = new L.Control({position: 'bottomleft'});
    legend.onAdd = function (map) {
      this._div = L.DomUtil.create('div', 'info');
      this.update();
      return this._div;
    };
    legend.update = function () {
      this._div.innerHTML = '<h5>Legenda</h5><svg width="32" height="20"><rect width="32" height="17" style="fill:rgb(254, 242, 0, 0.9);stroke-width:0.1;stroke:rgb(0,0,0)" /></svg> Kasus 1 - 5<br><svg width="32" height="20"><rect width="32" height="17" style="fill:rgb(195, 187, 34, 0.9);stroke-width:0.1;stroke:rgb(0,0,0)" /></svg> Kasus 6 - 19<br><svg width="32" height="20"><rect width="32" height="17" style="fill:rgb(244, 132, 32, 0.9);stroke-width:0.1;stroke:rgb(0,0,0)" /></svg> Kasus 20 - 50<br><svg width="32" height="20"><rect width="32" height="17" style="fill:rgb(221, 77, 87, 0.9);stroke-width:0.1;stroke:rgb(0,0,0)" /></svg> Kasus >50<br><svg width="32" height="20"><rect width="32" height="17" style="fill:rgb(37, 150, 210, 0.9);stroke-width:0.1;stroke:rgb(0,0,0)" /></svg> Tidak ada kasus<hr><small>Sumber data:<br><a href="https://bnpb-inacovid19.hub.arcgis.com/datasets/covid19-indonesia-per-provinsi/" target="_blank">https://bnpb-inacovid19.hub.arcgis.com</a></small>'
    };
    legend.addTo(map);

    // Control Basemaps
    map.addControl(
      L.control.basemaps({
        basemaps: basemaps,
        tileX: 0,
        tileY: 0,
        tileZ: 1
      })
    );
  </script>
</body>
</html>