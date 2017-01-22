<?php

require("functions.php");

//kui kasutaja on juba sisse logitud siis
//suunan data lehele

if (isset($_SESSION["userId"])) {

    //suunan sisselogimise lehele
    header("Location: data.php");
    exit();
}

echo "<body style='background-color:lightpink'>";

//MUUTUJAD
$loginUsername = "";
$loginPassword = "";
$signupPassword = "";
$signupUsername = "";
$signupEmail = "";
$signupGender = "";
$signupAge = "";

//ERROR MUUTUJAD
$loginUsernameError = "";
$loginPasswordError = "";
$signupUsernameError = "";
$signupEmailError = "";
$signupPasswordError = "";
$signupAgeError = "";
$signupGenderError = "";


if(isset($_POST["loginUsername"])){
    if(empty($_POST["loginUsername"])){
        $loginUsernameError = "Username is required!";
    } else {
        $loginUsername = $_POST["loginUsername"];
    }
}

if(isset($_POST["loginPassword"])){
    if(empty($_POST["loginPassword"])){
        $loginPasswordError = "Password is required!!";
    } 
}

if(isset($_POST["signupUsername"])){

    if(empty($_POST["signupUsername"])){

        $signupUsernameError = "This field is required!";
    } else {
        $signupUsername = $_POST["signupUsername"];
    }
}

// kas e-post oli olemas
if ( isset ( $_POST["signupEmail"] ) ) {

    if ( empty ( $_POST["signupEmail"] ) ) {

        // oli email, kuid see oli tühi
        $signupEmailError = "This field is required!";

    } else {

        //email olemas
        $signupEmail = $_POST["signupEmail"];

    }

}


if ( isset ( $_POST["signupPassword"] ) ) {

    if ( empty ( $_POST["signupPassword"] ) ) {

        // oli password, kuid see oli tühi
        $signupPasswordError = "This field is required!";

    } else {

        // tean et parool on ja see ei olnud tühi
        // VÄHEMALT 8

        if ( strlen($_POST["signupPassword"]) < 8 ) {

            $signupPasswordError = "Password must be at least 8 characters";

        }

    }


}

if(isset($_POST["signupAge"])){
    if(empty($_POST["signupAge"])){
        $signupAgeError = "This field is required!";
    } else {
        $signupAge = $_POST["signupAge"];
    }
}



if ( isset ( $_POST["signupGender"] ) ) {
    if (empty ( $_POST["signupGender"] ) ) {
        $signupGenderError = "This field is required!";
    } else {
        $signupGender = $_POST["signupGender"];
    }
}

if ( isset($_POST["signupEmail"]) &&
    isset($_POST["signupPassword"]) &&
    isset($_POST["signupAge"]) &&
    $signupEmailError == "" &&
    empty ($signupPasswordError)) {

    $password = hash("sha512", $_POST["signupPassword"]);

    //KASUTAN FUNKTSIOONI
    $signupEmail = cleanInput($signupEmail);
    $signupWebsite = cleanInput($signupWebsite);
    $signupUsername = cleanInput($_POST["signupUsername"]);
    signUp($signupUsername, $signupEmail, cleanInput($password), $signupAge);



}

$error ="";
if (isset($_POST["loginUsername"]) &&
    isset($_POST["loginPassword"]) &&
    !empty($_POST["loginUsername"]) &&
    !empty($_POST["loginPassword"])) {

    $error = login(cleanInput($_POST["loginUsername"]), cleanInput($_POST["loginPassword"]));

}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Log in or sign up</title>
</head>
<body>

<h1>Log in</h1>

<form method="POST">

    <p style="color:red;"><?=$error;?></p>

    <input name="loginUsername" type="text" placeholder="Username">
    <?php echo $loginUsernameError; ?>
    <br><br>
    <input name="loginPassword" type="password" placeholder="Password">
    <?php echo $loginPasswordError; ?>
    <br><br>
    <input type="submit" value="Log in">

</form>

<h1>Sign up</h1>

<form method="POST">

    <label>Username:</label><br>
    <input name="signupUsername" type="text" value="<?=$signupUsername;?>">
    <?php echo $signupUsernameError; ?>

    <br><br>

    <label>Email:</label><br>
    <input name="signupEmail" type="text" value="<?=$signupEmail;?>">
    <?php echo $signupEmailError; ?>

    <br><br>

    <label>Password:</label><br>
    <input name="signupPassword" type="password">
    <?php echo $signupPasswordError; ?>

    <br><br>

    <label>Age:</label><br>
    <input name="signupAge" type="age" value="<?=$signupAge;?>">
    <?php echo $signupAgeError; ?>

    <br><br>
    <label>Gender:</label><br>
    <?php echo $signupGenderError; ?>
    <?php if($signupGender == "male") { ?>
        <input type="radio" name="signupGender" value="male" checked> Male<br>
    <?php }else { ?>

        <input type="radio" name="signupGender" value="male"> Male<br>
    <?php } ?>

    <?php if($signupGender == "female") { ?>
        <input type="radio" name="signupGender" value="female" checked> Female<br>
    <?php }else { ?>
        <input type="radio" name="signupGender" value="female"> Female<br>
    <?php } ?>
    <br>

    <input type="submit" value="Create account">

</form>


</body>
</html>