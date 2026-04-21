<?php
require __DIR__ . '/../db/config.php';

$events = getAllEventsWithVolunteers($pdo);
?>

<main>

    <section class="page-header" aria-labelledby="events-page-title">
        <header class="page-header-content">
            <h1 id="events-page-title">Events</h1>
            <p>Se vores kommende Repair Café arrangementer og hvilke frivillige der deltager</p>
        </header>
    </section>

    <section class="info-section" aria-labelledby="events-intro-heading">
        <article class="info-block">
            <h2 id="events-intro-heading">Kommende arrangementer</h2>
            <p>
                Her finder du vores planlagte events. Du kan se dato, lokation og hvilke frivillige
                der er tilknyttet de enkelte arrangementer.
            </p>
        </article>
    </section>

    <section class="info-section alt" aria-labelledby="events-list-heading">
        <article class="info-block">
            <h2 id="events-list-heading">Eventoversigt</h2>
        </article>

        <section class="info-grid" aria-label="Liste over events">

            <?php if (empty($events)): ?>
                <article class="info-card">
                    <h3>Ingen events endnu</h3>
                    <p>Der er endnu ikke oprettet nogen events i databasen.</p>
                </article>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <article class="info-card">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>

                        <ul class="detail-list">
                            <li>
                                <span class="detail-label">Dato</span>
                                <span class="detail-value">
                                    <?= date('d-m-Y H:i', strtotime($event['date'])) ?>
                                </span>
                            </li>
                            <li>
                                <span class="detail-label">Lokation</span>
                                <span class="detail-value">
                                    <?= htmlspecialchars($event['location']) ?>
                                </span>
                            </li>
                            <li>
                                <span class="detail-label">Frivillige</span>
                                <span class="detail-value">
                                    <?php if (!empty($event['volunteers'])): ?>
                                        <?= htmlspecialchars(implode(', ', $event['volunteers'])) ?>
                                    <?php else: ?>
                                        Ingen tilknyttet endnu
                                    <?php endif; ?>
                                </span>
                            </li>
                        </ul>

                        <p>
                            Kom forbi og vær med i fællesskabet, få hjælp til reparation eller mød vores frivillige.
                        </p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>

        </section>
    </section>

    <section class="cta" aria-labelledby="events-cta-heading">
        <h2 id="events-cta-heading">Har du lyst til at hjælpe til?</h2>
        <a href="index.php?page=frivillig" class="btn">Bliv frivillig</a>
    </section>

</main>