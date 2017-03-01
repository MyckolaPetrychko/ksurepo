<?php
  namespace ksu\services;

  interface HomeService{
    function getCountRepo();

    function getAmountOfRepo($repo, $column, $query);

    function getConcretePage($from, $amount, $repo, $column, $query);
  }
