<?php
//ladataan tarvittavat luokat automaattisesti niitä kutsuessa
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.class.php';
});
//luodaan uusi auth luokan ilmentymä
$auth = new Auth();
// jos ei sisäänkirjautunut, siirretään kirjautumis sivulle
if (!$auth->requireAuth()) {
    $auth = NULL;
    header ('Location: index.php');
}
?>