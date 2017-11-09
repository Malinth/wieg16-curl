<?php

// Uppgift 1

/*
    1. Ta bort alla html taggar (finns inbyggd funktion för det )

    $content = strip_tags("$content");
    echo $content;

    2. Dela upp textsträngen (finns inbyggd funktion för det me)

    3. Räkna orden - en loop?
    4. Skriv ut resultatet på skärmen
*/


$fileName = "webbutvecklare.html";
$ch = curl_init("http://medieinstitutet.se/webbutvecklare-ehandel/");
$fp = fopen($fileName, "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);


$words = [
    'utbildning' => 0,
    'webbutveckling' => 0,
    'yrke' => 0,
      ];

      $content = file_get_contents ($fileName);
      
      $content = strip_tags($content);
      
      explode(",", $content);

      foreach ($words as $word => $count) {
          $words[$word] = substr_count($content, $word);
      }
      
      
      var_dump($words);
