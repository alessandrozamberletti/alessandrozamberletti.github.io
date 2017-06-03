<?php
require "PublicationList.php";
require "GalloFilter.php";

$xmlRepository = "http://artelab.dista.uninsubria.it/wp-content/plugins/artelab-papers/";
$authorsFile = new AuthorsFile($xmlRepository . "authors.xml");
$publicationsFile = new PublicationsFile($xmlRepository . "publications.xml", $authorsFile);
$publicationList = new PublicationList($publicationsFile, new GalloFilter());

print ($publicationList->GetPublicationsHtml());
?>

