<style>
        #map {
            height: 200px; /* Set the height as needed */
        }
    </style>


<div id="map"></div>




<script>
        function initMap() {
            // Initialize the map with center in Jamaica
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 18.1096,
                    lng: -77.2975
                },
                zoom: 8
            });

            // Create a marker variable outside the click event listener
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            // Initialize the autocomplete for the address input
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('addressInput'));

            // Set the bounds of the map for autocomplete predictions
            autocomplete.bindTo('bounds', map);

            // Listen for the event when a place is selected
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();

                // If the place has a geometry, set the map's center to that location
                if (place.geometry) {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15); // You can adjust the zoom level as needed

                    // Set the marker position to the selected place
                    marker.setPosition(place.geometry.location);
                }
            });

            // Listen for the click event on the map
            map.addListener('click', function (event) {
                // Clear the previous marker
                marker.setMap(null);

                // Create a new marker at the clicked location
                marker = new google.maps.Marker({
                    position: event.latLng,
                    map: map
                });

                // Reverse geocode the clicked location to get the address
                var geocoder = new google.maps.Geocoder;
                geocoder.geocode({
                    'location': event.latLng
                }, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            // Set the address input value
                            document.getElementById('addressInput').value = results[0].formatted_address;
                        } else {
                            window.alert('No results found');
                        }
                    } else {
                        window.alert('Geocoder failed due to: ' + status);
                    }
                });
            });
        }
    </script>

    <!-- Include the Google Maps API script with your API key -->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHYsfQDOv2XtJLK9riols1AZOfmtGUykM&libraries=places&callback=initMap" async defer></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC46_PI75dS4Jv3rIEIeblb3S13bZUFqM0&libraries=places&callback=initMap" async defer></script>