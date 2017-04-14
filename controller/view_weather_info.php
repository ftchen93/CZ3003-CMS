<?php

$controller_ok = true;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["region"])) {
        $region = $_GET["region"];
        $name = array();
        switch($region){
            case "wxnorth":
                array_push($name,
                    "Ang Mo Kio",
                    "Central Water Catchment",
                    "Lim Chu Kang",
                    "Mandai",
                    "North-Eastern Islands",
                    "Punggol",
                    "Seletar",
                    "Sembawang",
                    "Sengkang",
                    "Serangoon",
                    "Simpang",
                    "Sungei Kadut",
                    "Woodlands",
                    "Yishun"
                );
                break;
            case "wxwest":
                array_push($name,
                    "Boon Lay",
                    "Bukit Batok",
                    "Bukit Panjang",
                    "Clementi",
                    "Jurong East",
                    "Jurong West",
                    "Pioneer",
                    "Tengah",
                    "Tuas",
                    "Western Water Catchment"
                );
                break;
            case "wxeast":
                array_push($name,
                    "Bedok",
                    "Changi",
                    "Changi Bay",
                    "Hougang",
                    "Pasir Ris",
                    "Paya Lebar",
                    "Punggol",
                    "Seletar",
                    "Sengkang",
                    "Tampines");
                break;
            case "wxsouth":
            case "wxcentral":
                array_push($name,
                    "Bishan",
                    "Bukit Merah",
                    "Bukit Timah",
                    "Downtown Core",
                    "Geylang",
                    "Marina East",
                    "Marina South",
                    "Marine Parade",
                    "Museum",
                    "Novena",
                    "Orchard",
                    "Outram",
                    "Queenstown",
                    "River Valley",
                    "Rochor",
                    "Singapore River",
                    "Southern Islands",
                    "Straits View",
                    "Tanglin",
                    "Toa Payoh"
                );
                break;
        }
    }
    else {
        error_404();
    }
}
else {
    error_404();
}

?>