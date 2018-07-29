<?php
$con=mysqlI_connect("localhost","root","","wf");
mysqli_query($con,"SET NAMES utf8");
$result=mysqli_query($con,"SELECT * FROM `wfa");
$num = mysqli_num_rows($result);
$demo = array();
$k=0;
while($data = mysqli_fetch_array($result)){
    $demo[$k] = $data;
    $k++;
}
mysqli_free_result($result);
mysqli_close($con);

$output=exec('python WFapi.py');

?>
<title>
    wf alert
</title>  
<head>
    <meta charset="UTF-8">
</head>     
<body bgcolor = "#99FFFF">
    <style>
        table, th, td {
            border: 1px solid #888888;
            border-collapse: collapse;
            }
        th, td {
            padding: 15px;
            }
        th, td {
            text-align: center;
            }
    </style>
    <table style="width:100%">
        <tr>
            <th>任務類型</th>
            <th>剩餘時間</th>
            <th>獎勵</th>
        </tr>
        <?php
            for($n=0;$n<$num;$n++){
                echo "<tr>";
                for($i=0; $i<3; $i++){
                    echo "<td>{$demo[$n][$i]}</td>";
                }
                echo "<tr>";
            }
        ?>
    </table> 
</body>
