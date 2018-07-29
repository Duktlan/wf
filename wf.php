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
    <form method="POST">
        <input type ="text" name="type" style=width:80px value="">
        <input type ="text" name="time" style=width:80px value="">
        <input type ="text" name="reward" style=width:80px value="">
        <input type ="submit" name="send" style=width:80px value="新增">
        <input type ="submit" name="delete" style=width:80px value="清除資料庫">
    </form>

    <?php    
        if(array_key_exists('send',$_POST)){
            insert();
            header('location: http://localhost/wf/wf.php');
        }
        function insert(){
            $type = $_POST['type'];
            //echo "任務類型 $type";
            $time = $_POST['time'];
            //echo "時間 $time";
            $reward = $_POST['reward'];
            //echo "獎勵 $reward";
            $sql = "INSERT INTO wfa (type,TIME,REWARD) VALUES ('$type', '$time', '$reward')";
            $con=mysqlI_connect("localhost","root","","wf");
            $con->query($sql);
            $con->close();   
        }

        if(array_key_exists('delete',$_POST)){
            delete();
            header('location: http://localhost/wf/wf.php');
        }
        function delete(){
            $sql = "DELETE FROM `wfa`";
            $con=mysqlI_connect("localhost","root","","wf");
            $con->query($sql);
            $con->close();   
        }
    ?>

</body>