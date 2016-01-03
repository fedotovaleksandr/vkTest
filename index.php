<?php

require_once "src/Router/router.php";
require_once __DIR__ . "/src/Common/sessionInit.php";
sessionInit();
router();