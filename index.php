<?php
    
    require __DIR__.'/vendor/autoload.php';
    include(__DIR__."/vendor/grabzit/grabzit/lib/GrabzItClient.php");
    
    // GRABZIT ACCESS
    $client = "ZWFlZThkODUxNDJjNDIzZWEyYTY5ZTRhZTg4ZDRmMDI=";
    $secret = "bkM/Py0/Pz9lPz9NeD9AP0MrMT8/PzAZfk9jXz9uPxo";

    // RUN FOR FIRST TIME AND CRATE MISSED FILE
    $list = "sites-list";
    $l = file_get_contents($list);
    $l = explode("\n", $l);
    
    $fno = fopen("missed", "a+");
    foreach($l as $site){
        $s = @get_headers("http://".$site);
        if(preg_match('/.* (200|201|202|203|204|205|206|300|301|302|303|304|305|306|307) .*/', $s[0])){
            $grabzIt = new \GrabzIt\GrabzItClient($client, $secret);
            $grabzIt->URLToPDF($site);
            $grabzIt->SaveTo("output/".$site.".pdf");
        } else{
            fwrite($fno, $site."\n");
        }
    
    }
    fclose($fno);

    /*****************************************************************************************************/
    // RE-RUN FOR MISSED FILE
/*
    $list = "missed";
    $l = file_get_contents($list);
    $l = explode("\n", $l);
    foreach($l as $site){
        $grabzIt = new \GrabzIt\GrabzItClient("ZWY1ZWFmZjRjNzIxNGNhMDg2YTRjODc5ZmYyZmE5N2M=","LD8/Gz8/YR8/GjAuP2NPZQJtUT8/KxwkJD8/Pz8/Pz8=");
        $grabzIt->URLToPDF($site);
        $grabzIt->SaveTo("sites/".$site.".pdf");
    }
*/


    /*****************************************************************************************************/
    // RE-RUN FOR NO REACHED FILE
/*
    $list = "noreached";
    $l = file_get_contents($list);
    $l = explode("\n", $l);
    foreach($l as $site){
        $grabzIt = new \GrabzIt\GrabzItClient("ZWY1ZWFmZjRjNzIxNGNhMDg2YTRjODc5ZmYyZmE5N2M=","LD8/Gz8/YR8/GjAuP2NPZQJtUT8/KxwkJD8/Pz8/Pz8=");
        $grabzIt->URLToPDF($site);
        $grabzIt->SaveTo("sites/".$site.".pdf");
    }
*/


    $scandir = scandir("output");
    echo "<h2>FILES</h2><ul>";
    foreach($scandir as $file){
        if($file != '.' && $file != '..'){
            print_r("<li><a href='output/".$file."' target='_blank'>".$file."</a></li>");
        }
    }
    echo "</ul>";
?>
