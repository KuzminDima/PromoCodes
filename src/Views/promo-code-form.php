<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Promo Codes</title>
</head>
<body>
     <?php
         foreach ($session->getFlashBag()->get('warning', []) as $message) {
             echo '<div style="color: red">' . $message . '</div>';
         }
     ?>

    <form method="post" action="/retrieve-promo-code">
        <input type="submit" value="Retrieve Promo Code">
    </form>
</body>
</html>