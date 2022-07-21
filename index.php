<!DOCTYPE html>

<html>
<head>
    <title> Księga Internetu </title>
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
