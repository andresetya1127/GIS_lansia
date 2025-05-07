import $ from 'jquery';
import Swal from 'sweetalert2';


const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

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
let infoWindow
let marker;

async function initMap() {
    // The location of Uluru
    const position = {
        lat: -8.691471883208557,
        lng: 116.27994443483483
    };
    // Request needed libraries.
    //@ts-ignore
    const { Map } = await google.maps.importLibrary("maps");
    const { Places } = await google.maps.importLibrary("places");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

    // The map, centered at Uluru
    map = new Map(document.getElementById("map"), {
        zoom: 15,
        center: position,
        mapId: "DEMO_MAP_ID",
        mapTypeId: "satellite",
    });

    map.setTilt(45);

    infoWindow = new google.maps.InfoWindow();

    marker = new google.maps.marker.AdvancedMarkerElement({
        map: map,
        position: null,
        content: null,
    });

    marker.addListener("click", () => {
        infoWindow.open(map, marker);
    });

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



document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('markerUpdate', async (data) => {
        if (data) {
            const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

            const position = {
                lat: Number(data[0].lat),
                lng: Number(data[0].lng)
            };
            const content = `
                    <h5>${data[0].nama}</h5>
                    <p>${data[0].alamat}</p>
            `;
            const status = data[0].status;

            const pin = new PinElement({
                scale: 1,
                background: status == 'success' ? '#0cf747' : (status == 'pending' ? '#289de0' : '#ff0000'),
                borderColor: status == 'success' ? '#0cf747' : (status == 'pending' ? '#289de0' : '#ff0000'),
            });

            marker.position = position;
            marker.content = pin.element;
            infoWindow.setPosition(position);
            infoWindow.setContent(content);
            infoWindow.open(map);

            map.setZoom(19);
            map.setCenter(position);
        }
    });
});
