<?php

function CreateRoot ($myPDO){
    $create_root = $myPDO->prepare('INSERT branch(name, parent_id) VALUES ("root", 0)');
    $create_root->execute();
}
?>
