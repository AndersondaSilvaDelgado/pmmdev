<?php

require('./control/AtualCheckListCTR.class.php');

$atualCheckListDAO = new AtualCheckListDAO();
$info = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (isset($info)):

    echo $retorno = $atualCheckListDAO->dados($info);

endif;

