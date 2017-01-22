<?php

require("functions.php");
echo "<body style='background-color:lightpink'>";

//MUUTUJAD
$Username = "";
$bookAuthor = "";
$bookName = "";
$bookGenre = "";

//kui ei ole kasutaja id'd
if (!isset($_SESSION["userId"])){

    //suunan sisselogimise lehele
    header("Location: login.php");
    exit();
}


//kui on ?logout aadressireal siis log out
if (isset($_GET["logout"])) {

    session_destroy();
    header("Location: login.php");
    exit();
}

$msg = "";
    if(isset($_SESSION["message"])){
        $msg = $_SESSION["message"];
        unset($_SESSION["message"]);
    }

    if (isset($_POST["bookAuthor"]) &&
        !empty ($_POST["bookAuthor"])) {
            $bookAuthor = cleanInput($_POST["bookAuthor"]);
        }

    if (isset($_POST["bookName"]) &&
        !empty ($_POST["bookName"])) {
            $bookName = cleanInput($_POST["bookName"]);
            }

    if (isset($_POST["bookGenre"]) &&
        !empty ($_POST["bookGenre"])) {
            $bookGenre = cleanInput($_POST["bookGenre"]);
        }

$error= "";

    if(isset($_POST["bookAuthor"]) &&
        isset($_POST["bookName"]) &&
        isset($_POST["bookGenre"]) &&
        !empty($_POST["bookAuthor"]) &&
        !empty($_POST["bookName"]) &&
        !empty($_POST["bookGenre"])) {

        saveData($_SESSION["userName"], $_POST["bookAuthor"], $_POST["bookName"], $_POST["bookGenre"]);

    }
    elseif(isset($_POST["bookAuthor"]) &&
            isset($_POST["bookName"]) &&
            isset($_POST["bookGenre"]) &&
            empty($_POST["bookAuthor"]) &&
            empty($_POST["bookName"]) &&
            empty($_POST["bookGenre"])) {

        $error = "Täida kõik väljad";
    }

    echo $error;

//saan filmi andmed
$saveData = getBookData();
?>



    <!DOCTYPE html>
    <html>
    <body>
    <p><a href="data.php"> <button onclick="goBack()">Go Back</button></a></p>
    <h1>Books</h1>
    <?=$msg;?>
    <p>
        Welcome <?=$_SESSION["userName"];?>!
        <a href="?logout=1">Log out</a>
    </p>

    <h2> Add data </h2>

    <form method="POST">

        <label>Book author:</label><br>
        <input name="bookAuthor" type="text" value="<?=$bookAuthor;?>">

        <br><br>

        <label>Book name:</label><br>
        <input name="bookName" type="text" value="<?=$bookName;?>">

        <br><br>


        <label>Book genre:</label><br>
        <select name="bookGenre">
            <option value="" <?php echo $result['genre'] == 'Action' ? 'selected' : ''?> > </option>
            <option value="Action" <?php echo $result['genre'] == 'Action' ? 'selected' : ''?> >Action</option>
            <option value="Crime" <?php echo $result['genre'] == 'Crime' ? 'selected' : ''?>>Crime</option>
            <option value="Adventure" <?php echo $result['genre'] == 'Adventure' ? 'selected' : ''?> >Adventure</option>
            <option value="Sci-Fi" <?php echo $result['genre'] == 'Sci-Fi' ? 'selected' : ''?>>Sci-Fi</option>
            <option value="Romance" <?php echo $result['genre'] == 'Romance' ? 'selected' : ''?>>Romance</option>
            <option value="Horror" <?php echo $result['genre'] == 'Horror' ? 'selected' : ''?> >Horror</option>
            <option value="Fantasy" <?php echo $result['genre'] == 'Fantasy' ? 'selected' : ''?>>Fantasy</option>
        </select>

        <input type="submit" value="Submit">


    </form>
    </body>
    </html>

    <br><br>

    <head>
        <style>
            table, th, td {
                border: 0px solid black;
            }
        </style>
    </head>

<?php

$html = "<table>";

$html .= "<tr>";
$html .="<th>id</th>";
$html .="<th>username</th>";
$html .="<th>author</th>";
$html .="<th>book</th>";
$html .="<th>genre</th>";
$html .= "</tr>";

foreach($saveData as $i){

    $html .= "<tr>";
    $html .= "<td>".$i->id."</td>";
    $html .= "<td>".$i->Username."</td>";
    $html .= "<td>".$i->bookAuthor."</td>";
    $html .= "<td>".$i->bookName."</td>";
    $html .= "<td>".$i->bookGenre."</td>";
    $html .= "</tr>";
}

$html .= "</table>";

echo $html;



?>