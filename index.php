<!DOCTYPE html>

<?php

session_start();

$con = mysqli_connect("localhost","root","","zdania");

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

//unset($_POST['voteUp']);
//unset($_POST['voteDown']);

mysqli_select_db($con,"zdania");
$min=1;
$resultMax = mysqli_query($con,"SELECT MAX(ID) FROM input");
$max = mysqli_fetch_array($resultMax);
$max = intval($max[0]);
//srand(time());
if(!isset($_SESSION["random"])) {
    $_SESSION["random"] = rand($min,$max);
}
$randomId = $_SESSION["random"];
//echo $randomId;

$command = "SELECT Zdanie, Nick, Up, Down FROM input WHERE id = $randomId LIMIT 1";
$result = $con->query($command);
$row = $result->fetch_assoc();

$commandTop = "SELECT Zdanie, Nick, Up, Down FROM input ORDER BY Up - Down DESC LIMIT 1";
$resultTop = $con->query($commandTop);
$rowTop = $resultTop->fetch_assoc();

$resultNewest = $con->query("SELECT Zdanie, Nick, Up, Down FROM input ORDER BY id DESC LIMIT 1");
$rowNewest = $resultNewest->fetch_assoc();

$resultMostVoted = $con->query("SELECT Zdanie, Nick, Up, Down FROM input ORDER BY Up + Down DESC LIMIT 1");
$rowMostVoted = $resultMostVoted->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['phrase']) && !empty($_POST['user'])  && !empty($_POST['btn'])) {
    $usernameVal = $_POST['user'];
    $phraseVal = $_POST['phrase'];
    $index = $max + 1;
    //$sql = "INSERT INTO input (Nick, Zdanie, id) VALUES ('$usernameVal', '$phraseVal', '$index')";
    $stmt = $con->prepare("INSERT INTO input (Nick, Zdanie, id) VALUES (?, ?, ?)");
    $stmt->bind_param("sss",$usernameVal, $phraseVal, $index);
    $stmt->execute();
    //mysqli_query($con, $sql);
    session_destroy();
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit();
    //$con -> close();
}

if (!empty($_POST['voteUp'])) {
    $com = "UPDATE input SET Up = Up + 1 WHERE Zdanie = '".$row['Zdanie']."' AND Nick = '".$row['Nick']."' AND id = $randomId";
    $con->query($com);
    session_destroy();
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit();
    $con -> close();
}

if (!empty($_POST['voteDown'])) {
    $com = "UPDATE input SET Down = Down + 1 WHERE Zdanie = '".$row['Zdanie']."' AND Nick = '".$row['Nick']."' AND id = $randomId";
    $con->query($com);
    session_destroy();
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit();
    $con -> close();
}

if (!empty($_POST['reloadButton'])) {
    session_destroy();
    header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    exit();
    $con -> close();
}

//session_destroy();
?>

<html>
<head>
    <title> Księga Internetu </title>
    <link rel="stylesheet" href="style.css">
    <!-- <script src="ksiega.js"> </script> -->
</head>

<body>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript">
       $("voting").submit(function(){
       $.post($(this).attr("action"), $(this).serialize());
          return false;
       });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
           $("#userData").click(function () {
                console.log(1);
                $(this).addClass("animated1");
                //    setInterval(function () {
               // $("#userData").removeClass("animated1");
                //}, 2000);
        });
    });
    </script>

    <p id="mainText"> KSIĘGA INTERNETU MÓWI JASNO: </p>
    <div id="userData" class="animated">
        <?php echo "<p style= 'text-align: center; font-family:sans-serif; letter-spacing: -1px; line-height: 1; font-size: 60px; color: red; word-wrap: break-word; white-space: normal;'>" . $row["Zdanie"] . "</p>" ?>
        <?php echo "<p style= 'text-align: center; font-family:sans-serif; letter-spacing: -1px; line-height: 1; font-size: 30px; color: black; word-wrap: break-word; white-space: normal'>" . "- " . $row["Nick"] . "</p>" ?>
        <?php echo "<p style= 'text-align: center; font-family:sans-serif; letter-spacing: -1px; line-height: 1; font-size: 35px; color: dark_gray; word-wrap: break-word; white-space: normal'>" . "Głosy w górę: " . $row["Up"] . " Głosy w dół: " . $row["Down"] . "</p>" ?>
    </div>
    <?php //echo $row["Zdanie"]; ?> <br>
    <?php //echo "Podesłał: " . $row["Nick"]; ?> <br>

    <form action="index.php" method="POST" id="mainForm">
        
        <input size="10" type="text" maxlength="20" name="user" required id="userInput" autocomplete="off"></input>
        <label for="userInput" id="userInputLabel"> Nick: </label>
        <input size="30" type="text" maxlength="80" name="phrase" required id="phraseInput" autocomplete="off"></input>
        <label for="phraseInput" id="phraseInputLabel"> Zdanie: </label>
        <p></p>
        <input type="submit" name="btn" value="Wyślij" id="submitButton"/>
    </form>

    <form action="index.php" method="POST" role="voting" id="votingForm">
        <input type="submit" name="voteUp" value="+1" id="voteUpButton"/>
        <input type="submit" name="voteDown" value="-1" id="voteDownButton"/>
    </form>

    <form action="index.php" method="POST">
        <input type="submit" name="reloadButton" id="reloadButton" value="Następny cytat"/>
    </form>
    
    <br>
    <hr></hr>
    <br>

    <div id="top">
        <?php echo "Najlepszy cytat: " .$rowTop['Zdanie']." "; ?><br>
        <?php echo "- ".$rowTop['Nick']." "; ?><br>
        <?php echo "Głosy w górę: " . $rowTop["Up"] . " Głosy w dół: " . $rowTop["Down"] . " "; ?>
    </div>

    <br>
    <hr></hr>
    <br>

    <div id="mostVoted">
        <?php echo "Najczęściej głosowany cytat: " .$rowMostVoted['Zdanie']." "; ?><br>
        <?php echo "- ".$rowMostVoted['Nick']." "; ?><br>
        <?php echo "Głosy w górę: " . $rowMostVoted["Up"] . " Głosy w dół: " . $rowMostVoted["Down"] . " "; ?>
    </div>

    <br>
    <hr></hr>
    <br>
    

    <div id="newest">
        <?php echo "Najnowszy cytat: " .$rowNewest['Zdanie']." "; ?><br>
        <?php echo "- ".$rowNewest['Nick']." "; ?><br>
        <?php echo "Głosy w górę: " . $rowNewest["Up"] . " Głosy w dół: " . $rowNewest["Down"] . " "; ?>
    </div>

    <br>
    <hr></hr>
    <br>

</body>
</html> 