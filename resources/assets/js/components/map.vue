<template>
    <div id="map"></div>
</template>

<script>
    export default {
        props: [
            'casinos',
            'center'
        ],
        data: function() {
            return {
                input: null,
                map: null,
                autocomplete: null,
                geolocation: null,
                circle: null,
                place: null,
                place_latlng: {
                    lat: null,
                    lng: null,
                },
                markers: [],
                infowindow: new google.maps.InfoWindow(),
            }
        },
        ready: function() {
            this.generateMap();

            if (null !== document.getElementById('address')) {
                this.generateAutocomplete();
                this.setupAutocompleteBindings();
            }

            if (null == this.center) {
                this.geolocate();
            } else {
                this.map.panTo(this.center);
            }
        },
        watch: {
            casinos: {
                handler: function(casinos) {
                    this.placeMarkers();
                },
                deep: true,
            },
            center: {
                handler: function() {
                    this.map.panTo(this.center);
                },
                deep: true,
            },
        },
        methods: {
            generateMap: function() {
                var center = this.center || {
                    lat: 54.9736486,
                    lng: -1.6226131
                };

                var map = new google.maps.Map(document.getElementById('map'), {
                    center: center,
                    zoom: 13
                });

                this.$set('map', map);
            },
            generateAutocomplete: function() {
                var input = document.getElementById('address');
                var autocomplete = new google.maps.places.Autocomplete(input);

                this.$set('input', input);
                this.$set('autocomplete', autocomplete);
            },
            setupAutocompleteBindings: function() {
                var autocomplete = this.autocomplete,
                    map = this.map,
                    self = this;

                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                autocomplete.addListener('place_changed', () => {
                    infowindow.close();
                    marker.setVisible(false);

                    var place = autocomplete.getPlace();
                    self.$set('place', place);

                    self.$set('place_latlng', {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng(),
                    });

                    document.querySelector('[name="position_lat"]').value = JSON.stringify(self.place_latlng.lat);
                    document.querySelector('[name="position_lng"]').value = JSON.stringify(self.place_latlng.lng);

                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);  // Why 17? Because it looks good.
                    }

                    marker.setIcon({
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(35, 35)
                    });

                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    var address = '';

                    if (place.address_components) {
                        address = [
                            (place.address_components[0] && place.address_components[0].short_name || ''),
                            (place.address_components[1] && place.address_components[1].short_name || ''),
                            (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }

                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address + '</div>');
                    infowindow.open(map, marker);
                });
            },
            placeMarkers: function() {
                var self = this,
                    markers = [],
                    i = 0;

                for (var casino of this.casinos) {
                    markers[0] = new google.maps.Marker({
                        position: {
                            lat: Number.parseFloat(casino.position.lat),
                            lng: Number.parseFloat(casino.position.lng),
                        },
                        map: this.map,
                        title: casino.name,
                        content: casino.content,
                    });

                    google.maps.event.addListener(markers[0], 'click', function() {
                        self.infowindow.setContent(this.content);
                        self.infowindow.open(self.map, this);
                    });

                    i++;
                }
            },
            geolocate: function() {
                var autocomplete = this.autocomplete,
                    map = this.map,
                    self = this;

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(position => {
                        var geolocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        self.$set("geolocation", geolocation);

                        if (null == this.center) {
                            map.panTo(geolocation);
                        }

                        var circle = new google.maps.Circle({
                            center: geolocation,
                            radius: position.coords.accuracy
                        });
                        self.$set("circle", circle);

                        if (null !== autocomplete) {
                            autocomplete.setBounds(circle.getBounds());
                        }
                    });
                }
            },
        }
    }
</script>
