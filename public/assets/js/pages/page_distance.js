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
                    var totalDistance = 0;
                    var totalDuration = 0;
                    for (var i = 0; i < response.routes[0].legs.length; i++) {
                        $('.distance_' + i).text( response.routes[0].legs[i].distance.text );
                        $('.duration_' + i).text( response.routes[0].legs[i].duration.text );
                        totalDistance += response.routes[0].legs[i].distance.value;
                        totalDuration += response.routes[0].legs[i].duration.value;
                    }
                    $.getJSON(locale + '/distances/calculate-travel-cost', {
                        distance: totalDistance,
                        duration: totalDuration
                    }, function(data) {
                        $("#total-distance").text(data.total_distance);
                        $("#total-fuel-count").text(data.fuel_count);
                        $("#total-price").text(data.total_price);
                        $("#total-price-message").text(data.message);

                        var textBlockText = $("#text-block").html();
                        textBlockText = textBlockText.replace(':km', data.total_distance)
                            .replace(':duration', data.total_duration)
                            .replace(':fuel_count', data.fuel_count)
                            .replace(':fuel_cost', data.total_price);
                        $("#text-block").html(textBlockText);
                    });
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        },

        getTypeaheadOpts: function(locale) {
            return {
                //source: cities,
                source: function(query, process) {
                    if (query.length >= 3) {
                        $.getJSON(locale + '/cities.json', {
                            q: query
                        }, function (data) {
                            return process(data);
                        });
                    }
                    return false;
                },
                displayText: function(item) {
                    return item.name + ' (' + item.country + ')';
                },
                matcher: function (item) {
                    var it = item.name;
                    return ~it.toLowerCase().indexOf(this.query.toLowerCase());
                },
                highlighter: function (item) {
                    var it = item.split('(');
                    var html = $('<div></div>');
                    var query = this.query;
                    var i = it[0].toLowerCase().indexOf(query.toLowerCase());
                    var len, leftPart, middlePart, rightPart, strong;
                    len = query.length;
                    if(len === 0){
                        return html.text(item).html();
                    }
                    while (i > -1) {
                        leftPart = it[0].substr(0, i);
                        middlePart = it[0].substr(i, len);
                        rightPart = it[0].substr(i + len);
                        strong = $('<strong></strong>').text(middlePart);
                        html
                            .append(document.createTextNode(leftPart))
                            .append(strong);
                        it[0] = rightPart;
                        i = it[0].toLowerCase().indexOf(query.toLowerCase());
                    }
                    return html.append(document.createTextNode(it[0] + ' (' + it[1])).html();
                }
            };
        },

        initForm: function (i, locale, itemTitle) {
            // Автодополнение полей
            $( ".target-typeahead" ).typeahead(Distance.getTypeaheadOpts(locale));

            // Обработчик нажатия ссылки "добавить пункт"
            $( "#add-target" ).click(function(e) {
                e.preventDefault();

                var sectionHTML =
                    '<section>' +
                    '<label class="input">' +
                    '<div class="input-group">' +
                    '<input type="text" name="targets[' + (i - 1) + ']" id="target_' + i + '" class="form-control target-typeahead" placeholder="' + itemTitle + ' ' + i + '">' +
                    '<span class="input-group-btn">' +
                    '<button type="button" class="btn btn-danger remove-target"><i class="fa fa-times" aria-hidden="true"></i></button>' +
                    '</span>' +
                    '</div>' +
                    '</label>' +
                    '</section>';

                $( '.added-targets' ).append(sectionHTML);

                $( ".target-typeahead" ).typeahead(Distance.getTypeaheadOpts(locale));

                i++;
            });

            // Обработчик нажатия кнопки удаления поля "Пункт n"
            $('body').on('click', 'button.remove-target', function() {
                $section = $(this).parents('section');
                $section.hide('slow', function() {
                    $section.remove();
                });
            });
        }

    };
}();