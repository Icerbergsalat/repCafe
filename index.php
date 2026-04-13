<?php
$page = $_GET['page'] ?? 'forside';

include 'includes/header.php';

switch($page) {
    case 'events':
        include 'events/events.php';
        break;
    case 'faq':
        include 'faq/faq.php';
        break;
    case 'om_os':
        include 'om_os/om_os.php';
        break;
    case 'generelt':
        include 'generelt/generelt.php';
        break;
    default:
        include 'forside/forside.php';
        break;
}

include 'includes/footer.php';


?>