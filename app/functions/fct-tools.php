<?php 

function getMessage($message, $type = 'success')
{
    $html = '<div class="msg-'.$type.'">'.$message.'</div>';
    return $html;
}

function filterInputs($datas) {

    // Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
    $datas = trim($datas);
    // Supprime les antislashs d'une chaîne
    $datas = stripslashes($datas);
    // Convertit les caractères spéciaux en entités HTML
    $datas = htmlentities($datas);  
    // Supprime les balises HTML et PHP d'une chaîne
    $datas = strip_tags($datas);

    return $datas;
}