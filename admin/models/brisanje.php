<?php

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $noviNiz=[];
    $pokazivac = fopen("../../data/korisnici.txt","r");
    $vrednosti = fread($pokazivac, filesize("../../data/korisnici.txt"));
   
    $niz = explode("\n",$vrednosti);
    fclose($pokazivac);
    for($i = 0; $i<count($niz); $i++){
        if($i != $id){

            $noviNiz[] = $niz[$i];

        }
    }

    $podaci = implode("\n", $noviNiz);
    
    $file = fopen("../../data/korisnici.txt","w");
    fwrite($file,$podaci);
    if(fclose($file)){
        header("Location:../dashboard.php?page=textFile");
        exit(0);
    }

}

?>