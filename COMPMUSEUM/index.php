<?php 
  require_once("includes/database.inc.php");
  $sql = "SELECT * FROM tb_pages WHERE status = ? ORDER BY orderpage ASC";
  $data = array(1);
  $result = Database::getData($sql, $data);

  $mainmenu = "";
  foreach($result as $key => $value) {
    $page = $value['page'];
    //$trimmedPage = str_replace(' ', '', $page);
    $mainmenu .= "<a href='?page=" . strtolower($page) . "'>". UCFirst($page) . "</a>";
  }
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="computer museum">
  <meta name="keywords" content="computer, museum, antique, gpu, cpu">
  <title>Computer Museum</title>
  <link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</head>

<body>




<div class="background">
<h1 class="abdullah">Het computermuseum van Egbert Buchem</h1>
</div>

    <div class="navbar">
        <?php echo $mainmenu; ?>
</div>




<?php
if(!isset($_GET['page'])) {
    $page = "home";
    $_GET['page'] = "home";
}
    $currentPage = $_GET['page'];

    $sql = "SELECT * FROM tb_pages WHERE page = ?";
    $data = array($currentPage);
    $result = Database::getData($sql, $data);

    $content = "<h1>" . $result[0]['title'] . "</h1>";
    $content .= $result[0]['description'];

    if($currentPage == "museum") {
        header("Location: museum");
    }



/*
//print_r($result);
$content = "<h1>Welkom bij het Computermuseum van Egbert Buchem!</h1><p>Wat leuk dat je onze website bezoekt. Hier nemen we je mee op een reis door de geschiedenis van computers, met een unieke collectie van vintage apparatuur en technologie uit vervlogen tijden. Klik op de knop 'Museum' hierboven om ons uitgebreide aanbod te ontdekken en meer te leren over deze bijzondere historische stukken. Bedankt voor je interesse en veel plezier tijdens je virtuele bezoek!</p>";


if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'home':
            $content = 
            "<h1>Welkom bij het Computermuseum van Egbert Buchem!
              </h1><p>Wat leuk dat je onze website bezoekt. Hier nemen we je mee op een reis door de geschiedenis van computers, met een unieke collectie van vintage apparatuur en technologie uit vervlogen tijden. Klik op de knop 'Museum'hierboven om ons uitgebreide aanbod te ontdekken en meer te leren over deze bijzondere historische stukken. Bedankt voor je interesse en veel plezier tijdens je virtuele bezoek!</p>";
            break;
        case 'contact':
            $content = "<h1>Neem contact op met het Computermuseum</h1>
                        <p>Je kunt ons bereiken via:
                        📧 E-mail: info@computermuseum-buchem.nl
                        📞 Telefoon: 045-35309823
                        We kijken ernaar uit om je te helpen en hopen je binnenkort in ons museum te mogen verwelkomen!</p>";
            break;
        case 'over ons':
            $content = "<h1>Over Egbert Buchem</h1><p>Egbert Buchem is de oprichter van het Computermuseum en een gepassioneerd docent automatisering met jarenlange ervaring. Zijn liefde voor technologie en het delen van kennis heeft hem geïnspireerd om deze unieke collectie samen te stellen en toegankelijk te maken voor het publiek.

            Met meer dan 16 jaar ervaring als docent, weet Egbert complexe onderwerpen op een duidelijke en toegankelijke manier uit te leggen. Door zijn praktijkvoorbeelden en enthousiasme heeft hij talloze leerlingen en bezoekers geïnspireerd. Het Computermuseum is een verlengstuk van zijn missie om de geschiedenis van technologie levend te houden en te delen met jong en oud.</p>";
            break;
        case 'museum':
            // to another site
            header("Location: museum ");
            exit(); 
        default:
            $content = "<h1>Welkom bij het Computermuseum van Egbert Buchem!
                        </h1><p>Wat leuk dat je onze website bezoekt. Hier nemen we je mee op een reis door de geschiedenis van computers, met een unieke collectie van vintage apparatuur en technologie uit vervlogen tijden. Klik op de knop 'Museum' hierboven om ons uitgebreide aanbod te ontdekken en meer te leren over deze bijzondere historische stukken. Bedankt voor je interesse en veel plezier tijdens je virtuele bezoek!</p>";
            break;
    }
}
    */
?>

<div class="content">
        <?php
        // dynamic display
        echo $content;
        ?>
    </div>


<footer></footer>
<script src="script.js"></script>
</body>
</html>


