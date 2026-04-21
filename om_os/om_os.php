<?php
// om.php – Generel information om Repair Café
?>

<main>

    <header class="page-header" aria-labelledby="page-title">

    <section>
        <h1 id="page-title">Om Repair Café</h1>
        <p>Alt du skal vide om os, hvor vi holder til, og hvordan du deltager</p>
    </section>

</header>

    <section class="info-section" aria-labelledby="om-heading">
        <article class="info-block">
            <h2 id="om-heading">Hvad er Repair Café?</h2>
            <p>
                Repair Café er et frivilligt fællesskab, hvor mennesker mødes for at reparere ødelagte ting sammen.
                Vores café er særligt rettet mod RC-entusiaster - men alle er velkomne, uanset hvad de har med.
            </p>
            <p>
                Formålet er at forlænge levetiden på vores ejendele og samtidig dele viden og erfaringer på tværs
                af alder og erfaring. Du behøver ikke være ekspert - alle kan være med og lære noget nyt.
            </p>
        </article>
    </section>

    <section class="info-section alt" aria-labelledby="praktisk-heading">

        <header class="info-block">
            <h2 id="praktisk-heading">Praktisk information</h2>
            <p>Her finder du alt det praktiske om vores åbningstider, adresse og kontaktoplysninger.</p>
        </header>

        <section class="info-grid">

            <article class="info-card">
                <h3>Åbningstider</h3>
                <ul class="detail-list">
                    <li><span class="detail-label">Hver anden lørdag</span><span class="detail-value">Kl. 10:00-15:00</span></li>
                    <li><span class="detail-label">Særlige events</span><span class="detail-value">Se kalender</span></li>
                    <li><span class="detail-label">Entré</span><span class="detail-value">Gratis</span></li>
                </ul>
            </article>

            <article class="info-card">
                <h3>Adresse</h3>
                <ul class="detail-list">
                    <li><span class="detail-label">Lokation</span><span class="detail-value">Femøvej 3</span></li>
                    <li><span class="detail-label">By</span><span class="detail-value">4700 Næstved</span></li>
                    <li><span class="detail-label">Indgang</span><span class="detail-value">Bagindgangen</span></li>
                </ul>
            </article>

            <article class="info-card">
                <h3>Kontakt</h3>
                <ul class="detail-list">
                    <li>
                        <span class="detail-label">E-mail</span>
                        <span class="detail-value"><a href="mailto:info@repaircafe.dk">info@repaircafe.dk</a></span>
                    </li>
                    <li>
                        <span class="detail-label">Telefon</span>
                        <span class="detail-value"><a href="tel:+4512345678">+45 12 34 56 78</a></span>
                    </li>
                    <li><span class="detail-label">Svar inden</span><span class="detail-value">2 hverdage</span></li>
                </ul>
            </article>

        </section>
    </section>

    <section class="info-section" aria-labelledby="deltag-heading">
        <article class="info-block">
            <h2 id="deltag-heading">Sådan deltager du</h2>
            <p>
                Du er altid velkommen til bare at møde op i vores åbningstid - ingen tilmelding nødvendig.
                Tag det du gerne vil have repareret med, og en af vores frivillige hjælpere tager imod dig.
            </p>
            <p>
                Har du selv lyst til at bidrage som frivillig hjælper, er du meget velkommen til at kontakte os.
                Vi er altid glade for folk med viden om elektronik, mekanik, RC-udstyr eller bare et godt humør.
            </p>
            <a href="mailto:info@repaircafe.dk" class="btn">Bliv frivillig</a>
        </article>
    </section>

    <section class="info-section alt" aria-labelledby="hvem-heading">
        <article class="info-block">
            <h2 id="hvem-heading">Hvem står bag?</h2>
            <p>
                Repair Café drives udelukkende af frivillige med passion for håndværk, bæredygtighed og fællesskab.
                Vi er ikke tilknyttet nogen kommerciel organisation og modtager ingen betaling for vores hjælp.
            </p>
            <p>
                Vi er en del af det internationale Repair Café-netværk, som tæller tusindvis af lokale caféer
                verden over - alle med det samme mål: at reparere frem for at smide ud.
            </p>
        </article>
    </section>

    <section class="cta" aria-labelledby="cta-heading">
        <h2 id="cta-heading">Klar til at komme forbi?</h2>
        <a href="index.php?page=events" class="btn">Se kommende events</a>
    </section>

    <section class="info-section alt" aria-labelledby="map-heading">

        <header class="info-block">
            <h2 id="map-heading">Find os</h2>
            <p>Her kan du se vores placering på kortet og få rutevejledning.</p>
        </header>

        <article class="info-card">

            <figure>
                <figcaption class="sr-only">
                    Kort over Repair Café lokation
                </figcaption>

                <div id="map" style="height: 350px; width: 100%; border-radius: 12px;"></div>
            </figure>

            <footer style="margin-top: 1rem;">
                <a id="routeBtn" class="btn" target="_blank" rel="noopener">
                    Få rutevejledning
                </a>
            </footer>

        </article>

    </section>


<script>

    // Initialize map when page is loaded
async function initMap() {

    /*
    *1. Gets address + google maps link from PHP api
    */ 
    const res = await fetch('api/location.php');
    const data = await res.json();

    const address = data.address;

    /*
    * 2. Puts google maps route link on the button
    */

    const routeBtn = document.getElementById("routeBtn");
    routeBtn.href = data.google_maps_url;

    /*
    * 3. geocoding, converts address to actual coordinates through OpenStreetMap nominatim API
    */

    const geoRes = await fetch(
        `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`
    );

    const geoData = await geoRes.json();
    // If no results, stop function
    if (!geoData.length) return;


    // Gets latitude and longitude
    const lat = geoData[0].lat;
    const lon = geoData[0].lon;

    // Creates Leaflet map og centers it on coordinates
    const map = L.map('map').setView([lat, lon], 15);

    // Adds OpenStreetMap tile layer

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);


    // Adds marker on address and popup with the address

    L.marker([lat, lon])
        .addTo(map)
        .bindPopup(address)
        .openPopup();
}

    //Runs initMap when all DOM is loadet
    document.addEventListener("DOMContentLoaded", initMap);
</script>
</main>
