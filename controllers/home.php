<?php
  namespace ksu\controllers;

  require('../persistence/settings.php');
  require('../persistence/DbConnection.php');
  require('../services/HomeServiceImpl.php');

  use ksu\services\implement as HomeServiceImpl;

  function getPieData(){
    $homeService = new HomeServiceImpl\HomeServiceImpl();

    //return (json_encode($homeService->getCountRepo(), JSON_PRETTY_PRINT));
    return json_encode($homeService->getCountRepo());
  }

  function getAmountOfRepo($repo, $column, $query){
    $homeService = new HomeServiceImpl\HomeServiceImpl();

    return ($homeService->getAmountOfRepo($repo, $column, $query));
  }

  function getConcretePage($from, $amount, $repo, $column, $query){
    $homeService = new HomeServiceImpl\HomeServiceImpl();

    $concretePage = ($homeService->getConcretePage($from, $amount, $repo, $column, $query));
    if (empty($concretePage)){
      return "Нічого не знайдено.";
    }
    if (!is_array($concretePage)){
        return $concretePage;
    }
    foreach ($concretePage as $key => $value){
      $key = closetags($key);
      $value[0] = closetags($value[0]);
      $value[1] = closetags($value[1]);
      $value[2] = closetags($value[2]);
      $value[3] = closetags($value[3]);
      $value[4] = closetags($value[4]);
      $value[5] = closetags($value[5]);
      $value[6] = closetags($value[6]);
      $value[7] = closetags($value[7]);
      echo <<<TR
        <div class="list-group-item">
          <div class="media col-md-3">
                    <h6>$value[0]</h6>
                    <h6>$value[1]</h6>
          </div>
          <div class="col-md-6">
                   <h4 class="list-group-item-heading">Додаткова інформація</h4>
                   <p class="list-group-item-text">
                      $value[4]
                   </p>
                   <h4 class="list-group-item-heading">Тип дисертації</h4>
                   <p class="list-group-item-text">
                      $value[2]
                   </p>
          </div>
          <div class="col-md-3 text-center">
                  $value[5]
          </div>
        </div>
TR;
    }
  }

  function closetags ( $html )
        {
        #put all opened tags into an array
        preg_match_all ( "#<([a-z]+)( .*)?(?!/)>#iU", $html, $result );
        $openedtags = $result[1];
        #put all closed tags into an array
        preg_match_all ( "#</([a-z]+)>#iU", $html, $result );
        $closedtags = $result[1];
        $len_opened = count ( $openedtags );
        # all tags are closed
        if( count ( $closedtags ) == $len_opened )
        {
        return $html;
        }
        $openedtags = array_reverse ( $openedtags );
        # close tags
        for( $i = 0; $i < $len_opened; $i++ )
        {
            if ( !in_array ( $openedtags[$i], $closedtags ) )
            {
            $html .= "</" . $openedtags[$i] . ">";
            }
            else
            {
            unset ( $closedtags[array_search ( $openedtags[$i], $closedtags)] );
            }
        }
        return $html;
    }

  $type["getPieData"] = getPieData();
  if (isset($_REQUEST['repo']) && isset($_REQUEST['column']) && isset($_REQUEST['query'])){
    $type["getAmountOfRepo"] = getAmountOfRepo($_REQUEST['repo'], $_REQUEST['column'], $_REQUEST['query']);
  }
  if (isset($_REQUEST['repo']) && !isset($_REQUEST['column'])){
    $type["getAmountOfRepo"] = getAmountOfRepo($_REQUEST['repo'], '', '');
  }
  if (isset($_REQUEST['number']) && isset($_REQUEST['column'])){
     $type["getConcretePage"] = getConcretePage($_REQUEST['amountOnOnePage'] * $_REQUEST['number'] - $_REQUEST['amountOnOnePage'], $_REQUEST['amountOnOnePage'] + 0, $_REQUEST['repo'], $_REQUEST['column'], $_REQUEST['query']);
  }

  if (isset($_REQUEST['number']) && !isset($_REQUEST['column'])){
     $type["getConcretePage"] = getConcretePage($_REQUEST['amountOnOnePage'] * $_REQUEST['number'] - $_REQUEST['amountOnOnePage'], $_REQUEST['amountOnOnePage'], $_REQUEST['repo'], '', '');
  }


  //echo ($type[$_REQUEST['type']]);
  echo $type[$_REQUEST['type']];
