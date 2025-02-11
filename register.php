<?php
require_once ('vendor/autoload.php');
require_once ('Models/Database.php');


$dbContext = new DbContext();

$message = "";
$username = "";
$registeredOk = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "Registrering misslyckades";


    $username = $_POST['username'];
    $password = $_POST['password']; // Hejsan123#
    try {
        $userId = $dbContext->getUsersDatabase()->getAuth()->register($username, $password, $username, function ($selector, $token) {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.ethereal.email';
            $mail->SMTPAuth = true;
            $mail->Username = 'raheem2@ethereal.email';
            $mail->Password = 'PdZkY2RvfRyZGrgNAT';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->From = "stefans@superdupershop.com";
            $mail->FromName = "Hello"; //To address and name 
            $mail->addAddress($_POST['username']); //Address to which recipient will reply 
            $mail->addReplyTo("noreply@ysuperdupershop.com", "No-Reply"); //CC and BCC 
            $mail->isHTML(true);
            $mail->Subject = "Registrering";
            $url = 'http://localhost:8000/verify_email?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);
            $mail->Body = "<i>Hej, klicka på <a href='$url'>$url</a></i> för att verifiera ditt konto";
            $mail->send();
        });
        $registeredOk = true;
    } catch (\Delight\Auth\InvalidEmailException $e) {
        $message = "Ej korrekt email";
    } catch (\Delight\Auth\InvalidPasswordException $e) {
        $message = "Invalid password";
    } catch (\Delight\Auth\UserAlreadyExistsException $e) {
        $message = "Finns redan";
    } catch (\Exception $e) {
        $message = "Ngt gick fel";
    }

}


?>

<body>
    <main>
        <div class="top-header">
            <div class="logo">
                <a href="index.html"> <img src="/images/rocket.png"></a>
            </div>
            <div>
                <label for="active" class="menu-btn">
                    <i class="fas fa-bars" id="menu"></i>
                </label>
            </div>
        </div>

        <div class="content">
            <?php if ($registeredOk) {

                ?>
                <div>Tack för din registering, kolla mailet och klicka </div>

                <?php
            } else {
                echo "<h1>$message</h1>";
                ?>

                <div class="row-box">
                    <div class="col-boxes-1">
                        <div class="col-table">
                            <div class="table-section">
                                <div class="header-table">
                                    <h2>Ny kund - <?php echo $message; ?></h2>
                                </div>
                                <form method="post" class="form">
                                    <table width="100%">
                                        <thead>
                                            <tr>
                                                <th><span class="las la-sort"></span> </th>
                                                <th width="90%"><span class="las la-sort"></span> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th><label for="name">Username</label></th>
                                                <td>
                                                    <input class="form-control" type="text" name="username"
                                                        value="<?php echo $username ?>">

                                                </td>
                                            </tr>

                                            <tr>
                                                <th><label for="name">Password</label></th>
                                                <td>
                                                    <input class="form-control" type="text" name="password" </td>
                                            </tr>






                                            <tr>
                                                <td></td>
                                                <td>
                                                    <button type="submit" class="btn">Registrera</button>


                                                </td>
                                            </tr>
                                        </tbody>


                                    </table>
                                </form>



                            </div>

                        </div>

                    </div>
                </div>
                <?php
            }
            ?>

        </div>


    </main>



    <?php

    ?>

</body>

</html>