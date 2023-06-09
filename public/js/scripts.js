function loadMap() {
    let latitud= document.getElementById("latitud");
    let longitud= document.getElementById("longitud");
    var mapOptions = {
        center:new google.maps.LatLng(-34.6686986,-58.5614947),
        zoom:12,
        panControl: false,
        zoomControl: false,
        scaleControl: false,
        mapTypeControl:false,
        streetViewControl:true,
        overviewMapControl:true,
        rotateControl:true,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(-34.6686986,-58.5614947),
        map: map,
        draggable:true,
        icon:'/imagenes/logo_unlam.png'
    });

    google.maps.event.addListener(map, "rightclick", function(event) {
        var lat = event.latLng.lat();
        var lng = event.latLng.lng();
        latitud.value= lat;
        longitud.value= lng;
        marker.position=  new google.maps.LatLng(lat,lng);
    });

}
