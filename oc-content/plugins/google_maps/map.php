<div id="itemMap" style="width: 100%; height: 320px;"></div>
<?php if($item['d_coord_lat'] != '' && $item['d_coord_long'] != '') {?>
    <script type="text/javascript">
        var latlng = new google.maps.LatLng(<?php echo $item['d_coord_lat']; ?>, <?php echo $item['d_coord_long']; ?>);
        var myOptions = {
            zoom: 13,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            size: new google.maps.Size(480,320),
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false
        }

        map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
        var marker = new google.maps.Marker({
            map: map,
            position: latlng,
            icon: baseDir + 'oc-content/themes/zara/images/marker-blue.png'
        });
    </script>
<?php } else { ?>
    <script type="text/javascript"> 
        var map = null;
        var geocoder = null;
     
        var myOptions = {
            zoom: 13,
            center: new google.maps.LatLng(37.4419, -122.1419),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            size: new google.maps.Size(480,320),
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false
        }

        map = new google.maps.Map(document.getElementById("itemMap"), myOptions);
        geocoder = new google.maps.Geocoder();
     
        function showAddress(address) {
            if (geocoder) {
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: results[0].geometry.location,
                            icon: baseDir + 'oc-content/themes/zara/images/marker-blue.png'
                        });
                        marker.setMap(map);  
                    } else {
                        $("#itemMap").remove();
                    }
                });
            }
        }

        <?php
            $addr = array();
            if( ( $item['s_address'] != '' ) && ( $item['s_address'] != null ) ) { $addr[] = $item['s_address']; }
            if( ( $item['s_city'] != '' ) && ( $item['s_city'] != null ) ) { $addr[] = $item['s_city']; }
            if( ( $item['s_zip'] != '' ) && ( $item['s_zip'] != null ) ) { $addr[] = $item['s_zip']; }
            if( ( $item['s_region'] != '' ) && ( $item['s_region'] != null ) ) { $addr[] = $item['s_region']; }
            if( ( $item['s_country'] != '' ) && ( $item['s_country'] != null ) ) { $addr[] = $item['s_country']; }
            $address = implode(", ", $addr);
        ?>

        $(document).ready(function(){
            showAddress('<?php echo osc_esc_js($address); ?>');
        });

    </script>
<?php } ?>