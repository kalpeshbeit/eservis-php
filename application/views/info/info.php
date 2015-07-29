
 <!--Start Breadcrumb-->
 <div class="row">
    <div id="breadcrumb" class="col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url();?>">Po&#269;etna</a></li>  
            <li><a href="#">Korisni&#269;ka podr&#353;ka</a></li>
        </ol>
    </div>
 </div>
 <!--End Breadcrumb-->

  <div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <div class="box-name">
                    <i class="fa fa-home"></i>
                    <span>Kontakt</span>
                </div>
                <div class="box-icons">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="no-move"></div>
            </div>
            <div class="box-content">
                <div class="card">
                    <h4 class="page-header">INFORMATIKA Fortuno d.o.o.</h4>
                    <p>
                        <span>Tel: 032 / 341 - 223</span> <br>
                        <a href="mailto:info@mobilniured.com">info@mobilniured.com</a>
                    </p>
                </div>
                <div class="card address">
                   
                    <h4 class="page-header">Adresa:</h4>
                    <p>
                        <span>H.D.Genschera 22 b</span> <br>
                        <span>32100 Vinkovci</span>
                    </p>
                    <h4 class="page-header">Nalazimo se ovdje <i class="fa fa-arrow-down"/></h4>
                    <div class="map" id="map-1" style="height: 400px;"></div>
                </div>
            </div>
        </div>    
    </div>
    
    
  </div>

<script type="text/javascript">
// Load OpenLayers library and create test map
function OpenLayersMap() {
    $.getScript('http://www.openlayers.org/api/OpenLayers.js', LoadTestMap);
}
$(document).ready(function () {
    // Load Google Map API and callback to OpenLayers
    $.getScript('http://maps.google.com/maps/api/js?sensor=false&callback=OpenLayersMap');

});
</script>             
             
