<?php
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST');
  header("Access-Control-Allow-Headers: X-Requested-With");
  $api_key = "Your TMDB API Key";
  require "simple_html_dom.php";
  function check_404($url) {
   $headers=get_headers($url, 1);
   if ($headers[0]!='HTTP/1.1 200 OK') return true; else return false;
  }
  function contains($needle, $haystack) {
    return strpos($haystack, $needle) !== false;
  }
  if (check_404("https://api.themoviedb.org/3/tv/$_GET[id]/season/$_GET[s]?api_key=$api_key")) {
  $m = json_decode(file_get_contents("https://api.themoviedb.org/3/tv/$_GET[id]?api_key=$api_key"));
  $title = urlencode($m->name);
  $date = $m->first_air_date;
  $month = explode("-", $date)[1];
  $year = explode("-", $date)[0];
  $yearAndMonth = $year.'-'.$month;
  $y = file_get_contents("https://myanimelist.net/anime.php?cat=0&q=$title&type=0&score=0&status=0&p=0&r=0&sm=$month&sd=1&sy=$year&em=0&ed=0&ey=0&c[0]=d&o=2&w=1&o=2&w=2");
  $html = str_get_html($y);
  $malID = explode("/", $html->find(".di-ib a")[4]->href)[4];
  if (!$malID) {
    $malID = explode("/", $html->find(".hoverinfo_trigger.fw-b.fl-l")[0]->href)[4];
  }
    
  $z = str_get_html(file_get_contents("https://myanimelist.net/anime/$malID"));
  if (contains("Sequel", $z->find(".ar.fw-n.borderClass")[1])) {
    echo explode("/", $z->find("td.borderClass > a")[1]->href)[2];
  }
  else {
    echo $malID;
  }
  }
  else {
    $m = json_decode(file_get_contents("https://api.themoviedb.org/3/tv/$_GET[id]/season/$_GET[s]?api_key=$api_key"));
  $date = $m->air_date;
  $month = explode("-", $date)[1];
  $year = explode("-", $date)[0];
  $yearAndMonth = $year.'-'.$month;
  $y = json_decode(file_get_contents("https://api.themoviedb.org/3/tv/$_GET[id]?api_key=$api_key"));
  $title = urlencode($y->name);
  /*$x = json_decode(file_get_contents(str_replace(" ", "%20", "https://api.jikan.moe/v4/anime?q=$title&start_date=$yearAndMonth&order_by=start_date")));*/
  // $x = file_get_contents("https://myanimelist.net/anime.php?cat=anime&q=$title&type=1&score=0&status=0&p=0&r=0&sm=$month&sy=$year&em=0&ed=0&ey=0&c%5B%5D=a&c%5B%5D=b&c%5B%5D=c&c%5B%5D=f");
  $x = file_get_contents("https://myanimelist.net/anime.php?cat=0&q=$title&type=0&score=0&status=0&p=0&r=0&sm=$month&sd=1&sy=$year&em=0&ed=0&ey=0&c[0]=d&o=2&w=1&o=2&w=2");
      $html = str_get_html($x);
      if ($_GET['id'] == "37854") {
       echo "21";
      }
      else {
        // echo $x->data[0]->mal_id;
        $malID = explode("/", $html->find(".di-ib a")[4]->href)[4];
        if (!$malID) {
           echo explode("/", $html->find(".hoverinfo_trigger.fw-b.fl-l")[0]->href)[4];
        }
        else {
         echo $malID;
        }
      }
  }
?>
