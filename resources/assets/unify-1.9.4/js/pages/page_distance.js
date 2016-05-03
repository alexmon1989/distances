var Distance = function () {

    return {

        initMap: function(origin, destination, waypoints){
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15
            });
            directionsDisplay.setMap(map);

            Distance.calculateAndDisplayRoute(directionsService, directionsDisplay, origin, destination, waypoints);
        },

        calculateAndDisplayRoute: function(directionsService, directionsDisplay, origin, destination, waypoints){
            directionsService.route({
                origin: origin,
                destination: destination,
                waypoints: waypoints,
                travelMode: google.maps.TravelMode.DRIVING
            }, function(response, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    // For each route, display summary information.
                    for (var i = 0; i < response.routes[0].legs.length; i++) {
                        $('.distance_' + i).text( response.routes[0].legs[i].distance.text );
                        $('.duration_' + i).text( response.routes[0].legs[i].duration.text );
                    }
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

    };
}();