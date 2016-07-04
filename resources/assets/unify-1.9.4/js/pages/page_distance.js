var Distance = function () {

    return {

        initMap: function(origin, destination, waypoints, locale, fullScreenTranslate, fullScreenTranslateExit){
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15
            });
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(FullScreenControl(map, fullScreenTranslate, fullScreenTranslateExit));
            directionsDisplay.setMap(map);
            directionsDisplay.setPanel(document.getElementById('right-panel'));

            Distance.calculateAndDisplayRoute(directionsService, directionsDisplay, origin, destination, waypoints, locale);
        },

        calculateAndDisplayRoute: function(directionsService, directionsDisplay, origin, destination, waypoints, locale){
            directionsService.route({
                origin: origin,
                destination: destination,
                waypoints: waypoints,
                travelMode: google.maps.TravelMode.DRIVING //,
                //unitSystem: google.maps.UnitSystem.IMPERIAL
            }, function(response, status) {
                if (status === google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                    // For each route, display summary information.
                    totalDistance = 0;
                    for (var i = 0; i < response.routes[0].legs.length; i++) {
                        $('.distance_' + i).text( response.routes[0].legs[i].distance.text );
                        $('.duration_' + i).text( response.routes[0].legs[i].duration.text );
                        totalDistance += response.routes[0].legs[i].distance.value;
                    }
                    $.getJSON(locale + '/distances/calculate-travel-cost', {
                        distance: totalDistance
                    }, function(data) {
                        $("#total-distance").text(data.total_distance);
                        $("#total-fuel-count").text(data.fuel_count);
                        $("#total-price").text(data.total_price);
                        $("#total-price-message").text(data.message);
                    });
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }

    };
}();