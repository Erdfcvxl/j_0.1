<?php

$psl = (isset($_GET['psl']))? $_GET['psl'] : "";

if($psl == "index"){
    echo $this->render('search/index.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
}elseif($psl == "detail"){
    echo $this->render('search/detail.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); 
}elseif($psl == "new"){
    echo $this->render('search/new.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); 
}elseif($psl == "top"){
    echo $this->render('search/top.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); 
}elseif($psl == "topF"){
    echo $this->render('search/topF.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); 
}elseif($psl == "recommended"){
    echo $this->render('search/recommended.php', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]); 
}
?>

<div style="height: 40px;"></div>

<?php
//$command = $dataProvider->createCommand();

//var_dump($command);

?>