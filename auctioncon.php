<?php
$n=isset($_POST['n'])?$_POST['n']: 0;
$nxt=isset($_POST['nxt'])?$_POST : false;
$sv=isset($_POST['sv'])?$_POST : false;
$team=isset($_POST['team'])?$_POST : false;
$conn= new mysqli('localhost','root',"",'auctiontv');
if($nxt)
{
    $res1=$conn->query("select * from players where Status = 'Not_Sold' and Base =2 order by rand() limit 1;");
    if($res1->num_rows==0){
        $res1=$conn->query("select * from players where Status = 'Not_Sold' and Base =1 order by rand() limit 1;");
    }
    if($res1->num_rows==0){
        $res1=$conn->query("select * from players where Status ='Unsold' order by rand() limit 1");
    }
    $row = $res1->fetch_assoc();
    $id = $row['ID'];
    $name = $row['Name'];
    $dept = $row['Dept'];
    $pos = $row['Position'];
    $mlt = $row['Mini_Ligue'];
    $ph = $row['Phone'];
    $cteam = $row['C_Team'];
    $base = $row['Base'];
    $yr = $row['Year'];
    $status = $row['Status'];
    $conn->query("update player set ID =$id,Name='$name',Dept='$dept',Position='$pos',Mini_Ligue='$mlt',Phone='$ph',C_Prize=0,C_Team='None',Base=$base,Year='$yr',Status='$status' where 1;");
    $result=$conn->query("select * from player where 1");
        if($result->num_rows>0){
            $row=$result->fetch_assoc();
            echo json_encode(
                array(
                    'name' => $row['Name'],
                    'dept' => $row['Dept'],
                    'pos' => $row['Position'],
                    'mlt' => $row['Mini_Ligue'],
                    'ph' => $row['Phone'],
                    'cteam' => $row['C_Team'],
                    'cprice' => $row['C_Prize'],
                    'base' => $row['Base'],
                    'yr' => $row['Year'],
                    'status' => $row['Status']
                )
            );
        }
    }
if($team){
    $result=$conn->query("select * from player");
    $row=$result->fetch_assoc();
    if($row['C_Prize']==0){
        $cp=$row['Base'];
    }
    else{
        $cp=$row['C_Prize']+0.25;
    }
    if($n==1 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set C_Prize=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Dribbling_Demons';");
    }
    else if($n==2 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set C_Prize=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Soccor Hooligans';");
    }
    else if($n==3 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set C_Prize=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Juggling Giants';");
    }
    else if($n==4 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set C_Prize=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Faking Phantoms';");
    }
    else if($n==5 && ($row['Status']!=='Sold' || $row['Status']!=='Unsold')){
        $conn->query("update player set C_Prize=$cp;");
        $conn->query("update player set Status='Selling';");
        $conn->query("update player set C_Team='Net Busters';");
    }
    echo json_encode(
        array(
            'cp' => $cp
        )
    );
}
if($sv){
    $result=$conn->query("select * from player");
    $row=$result->fetch_assoc();
    $cp=$row['C_Prize'];
    $ct=$row['C_Team'];
    $id=$row['ID'];
    $conn->query("update players set C_Team = '$ct' where ID=$id;");
    $conn->query("update players set Sold_Price = $cp where ID=$id;");
    if($row['Status']==="Selling"){
        $conn->query("update players set Status = 'Sold' where ID=$id ;");
        $conn->query("update player set Status = 'Sold'");
    }    
    else{
        $conn->query("update players set Status='Unsold' where ID=$id;");
        $conn->query("update player set Status = 'Unsold';");
    }
    $result=$conn->query("select * from players where ID=$id;");
    $row=$result->fetch_assoc();
    echo json_encode(
        array(
            'ct' => $row['C_Team'],
            'pr' => $row['Sold_Price']
        )
        );
}
?>