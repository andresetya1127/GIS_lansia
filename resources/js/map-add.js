
// Maps

(g => {
    var h, a, k, p = "The Google Maps JavaScript API",
        c = "google",
        l = "importLibrary",
        q = "__ib__",
        m = document,
        b = window;
    b = b[c] || (b[c] = {});
    var d = b.maps || (b.maps = {}),
        r = new Set,
        e = new URLSearchParams,
        u = () => h || (h = new Promise(async (f, n) => {
            await (a = m.createElement("script"));
            e.set("libraries", [...r] + "");
            for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
            e.set("callback", c + ".maps." + q);
            a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
            d[q] = f;
            a.onerror = () => h = n(Error(p + " could not load."));
            a.nonce = m.querySelector("script[nonce]")?.nonce || "";
            m.head.append(a)
        }));
    d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
        d[l](f, ...n))
})({
    key: "AIzaSyCEGSwPYdIC3jOd-TJP5fXk-VPY9YuXGT4",
    v: "weekly",
    // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
    // Add other bootstrap parameters as needed, using camel case.
});
// Initialize and add the map
let map;

async function initMap() {
    // The location of Uluru
    const position = {
        lat: -8.691471883208557,
        lng: 116.27994443483483
    };
    // Request needed libraries.
    //@ts-ignore
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");


    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 15,
        center: position,
        mapId: "DEMO_MAP_ID",
        mapTypeId: "satellite",
    });

    map.setTilt(45);

    const infoWindow = new google.maps.InfoWindow();

    let latInput = document.getElementById('lat');
    let lngInput = document.getElementById('lng');

    // Tombol lokasi saya
    const locationButton = document.createElement("button");
    locationButton.innerHTML = "<i class='fas fa-location-arrow'></i> Lokasi saya";
    locationButton.classList.add("btn", "btn-light", "m-3");

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(locationButton);


    // Membuat marker draggable
    const draggableMarker = new AdvancedMarkerElement({
        map,
        position: position,
        gmpDraggable: true,
        title: "This marker is draggable.",
    });

    draggableMarker.addListener("dragend", (event) => {
        const position = draggableMarker.position;
        latInput.value = position.lat.toFixed(7);
        lngInput.value = position.lng.toFixed(7);
        infoWindow.close();
        infoWindow.setContent(`Pin dropped at: ${position.lat.toFixed(7)}, ${position.lng.toFixed(7)}`);
        infoWindow.open(draggableMarker.map, draggableMarker);
    });


    // Tombol Loakasi Saya
    locationButton.addEventListener("click", (e) => {
        // Try HTML5 geolocation.
        e.preventDefault();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    latInput.value = pos.lat;
                    lngInput.value = pos.lng;

                    draggableMarker.position = pos;
                    draggableMarker.setMap(map);

                    // infoWindow.setPosition(pos);
                    // infoWindow.open(map);
                    // infoWindow.close();
                    // infoWindow.setContent("Lokasi Anda saat ini.");
                    // infoWindow.open(draggableMarker.map, draggableMarker);
                    map.setCenter(pos);
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                },
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
    });


    // // Autocomplete setup
    // const input = document.getElementById("location-search");
    // autocomplete = new google.maps.places.Autocomplete(input);
    // autocomplete.bindTo("bounds", map);

    // autocomplete.addListener("place_changed", () => {
    //     const place = autocomplete.getPlace();
    //     if (!place.geometry) {
    //         alert("Lokasi tidak ditemukan");
    //         return;
    //     }

    //     // Pindahkan peta dan marker ke lokasi baru
    //     const newPos = place.geometry.location;
    //     marker.setPosition(newPos);
    //     map.setCenter(newPos);
    //     map.setZoom(15);
    // });
}


function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation
            ? "Gagal mendapatkan lokasi."
            : "Browser Anda tidak mendukung geolocation."
    );
    infoWindow.open(map);
}

initMap();


