import Swal from 'sweetalert2';


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
let dataMarkers = [];
let tomSelect;

async function initMap() {
    // Request needed libraries.
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");

    const latlang = document.getElementById('map');

    const position = {
        lat: Number(latlang.dataset.lat ?? 0),
        lng: Number(latlang.dataset.lng ?? 0)
    };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 11,
        center: position,
        mapId: "detail",
    });

    const infoWindow = new google.maps.InfoWindow({
        content: "",
        disableAutoPan: true,
    });
    const marker = new AdvancedMarkerElement({
        map,
        position: position,
    });
}

initMap();

document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('statusReject', async (data) => {
        const { value: text } = await Swal.fire({
            input: "textarea",
            inputLabel: "Pesan",
            inputPlaceholder: data[0].message,
            inputAttributes: {
                "aria-label": data[0].message
            },
            showCancelButton: true
        });
        if (text) {
            Livewire.dispatch('rejectData', {
                message: text
            });
        }
    });
});
