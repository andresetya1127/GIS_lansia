import { MarkerClusterer } from "@googlemaps/markerclusterer";
import TomSelect from 'tom-select';



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

const intersectionObserver = new IntersectionObserver((entries) => {
    for (const entry of entries) {
        if (entry.isIntersecting) {
            entry.target.classList.add('drop');
            intersectionObserver.unobserve(entry.target);
        }
    }
});
async function initMap() {
    // Request needed libraries.
    const { Map, InfoWindow } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement, PinElement } = await google.maps.importLibrary("marker");
    const position = {
        lat: -8.691471883208557,
        lng: 116.27994443483483
    };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 11,
        center: position,
        mapId: "dashboard",
    });
    const infoWindow = new google.maps.InfoWindow({
        content: "",
        disableAutoPan: true,
    });
    // Create an array of alphabetical characters used to label the markers.

    const response = await fetch('/admin/dashboard/locations');
    const locations = await response.json();
    console.log(locations);

    // Add some markers to the map.
    const markers = locations.map((position, i) => {


        // const marker = new google.maps.Marker({
        //     map,
        //     draggable: false,
        //     position: {
        //         lat: Number(position.lat),
        //         lng: Number(position.lng)
        //     },
        //     title: position.nama,
        //     label: String(i + 1),
        // });

        // const pinGlyph = new google.maps.marker.PinElement({
        //     glyph: String(i + 1),
        //     glyphColor: "white",
        //     background: position.status == 'disetujui' ? '#0d00ff' : '#0d00ff',
        //     borderColor: '#f5f0f0',
        // });
        const pinElement = new PinElement({
            glyph: String(i + 1),
            glyphColor: "white",
            background: position.status == 'success' ? '#0cf747' : (position.status == 'pending' ? '#289de0' : '#ff0000'),
            borderColor: '#f5f0f0',
        });
        const content = pinElement.element;

        const marker = new google.maps.marker.AdvancedMarkerElement({
            position: {
                lat: Number(position.lat),
                lng: Number(position.lng)
            },
            // content: pinGlyph.element,
            content: content,
            title: position.nama,
        });
        content.style.opacity = '0';
        content.addEventListener('animationend', (event) => {
            content.classList.remove('drop');
            content.style.opacity = '1';
        });

        const time = 1 + Math.random(); // 2s delay for easy to see the animation
        content.style.setProperty('--delay-time', time + 's');
        intersectionObserver.observe(content);

        // markers can only be keyboard focusable when they have click listeners
        // open info window when marker is clicked
        marker.addListener("click", () => {
            infoWindow.setContent(`
                <span class="badge ${position.status == 'success' ? 'bg-success' : (position.status == 'pending' ? 'bg-info' : 'bg-danger')} mb-3">${position.status}</span>
                <h5><i class="text-primary fas fa-user me-2"></i> ${position.nama}</h5>
                <p><i class="text-primary fas fa-map-marker-alt me-2"></i> ${position.alamat}</p>
                <p><i class="text-primary fas fa-calendar me-2"></i> ${new Date(position.created_at).toDateString()}</p>
                <a href="#" class="btn btn-sm btn-secondary"><i class="fas fa-info-circle me-2"></i>Detail</a>
                `);
            infoWindow.open(map, marker);
        });

        dataMarkers.push({
            name: position.nama.toLowerCase(),
            marker: marker
        });

        return marker;
    });

    // Add a marker clusterer to manage the markers.
    new MarkerClusterer({ markers, map });


    // Pencarian marker
    const markerSearch = document.createElement("select");
    markerSearch.id = "markerSearch";
    markerSearch.classList.add("form-control");
    markerSearch.autocomplete = "off";

    const containerSearch = document.createElement("div");
    containerSearch.classList.add("input-group", "m-3");
    containerSearch.style.width = "300px";
    containerSearch.appendChild(markerSearch);


    map.controls[google.maps.ControlPosition.TOP_LEFT].push(containerSearch);

    // Inisialisasi Tom Select
    tomSelect = new TomSelect("#markerSearch", {
        maxItems: 1,
        create: false,
        allowEmptyOption: true,
        placeholder: 'Cari marker...',
        onChange: (value) => {
            const result = dataMarkers.find(m => m.name === value.toLowerCase());

            if (result) {
                map.setCenter(result.marker.position);
                map.setZoom(19);

                result.content.classList.add("bounce");
                setTimeout(() => result.content.classList.remove("bounce"), 1000);
            }
        },
    });
    dataMarkers.forEach(m => {
        tomSelect.addOption({ value: m.name, text: m.name });
    });
}

initMap();

