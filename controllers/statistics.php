<?php
  namespace ksu\controllers;

  require('../persistence/settings.php');
  require('../persistence/DbConnection.php');
  require('../services/StatService.php');

  use ksu\controllers as Service;

  $service = new Service\StatService();
  return json_encode($service->getYearDistribution());
