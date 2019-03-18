<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Activation de compte</h1>
    Pour activer votre compte, veuillez cliquez sur le lien;
    <a href="<?='localhost/TransfertMoney/confirm.php?id='. $_SESSION['user']['id'].'&token='. $token?>">Lien d'activation</a>
</body>
</html>