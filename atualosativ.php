<?php

require_once('./control/OSCTR.class.php');

$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

   $osCTR = new OSCTR();
   echo $osCTR->dadosVersao1($info);

endif;