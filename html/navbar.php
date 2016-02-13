 <header>
     <div id="logo"><a href="main.php">Climbing time</a></div>
     <!-- tulostaa otsikoksi tiedostonimi.php -> Tiedostonimi -->
     <div id="sivun_otsikko"><?php echo ucwords( str_ireplace(array('-', '.php'), array(' ', ''), basename($_SERVER['PHP_SELF']) ) )  ?></div>
     <nav>
         <img id="menu" src="images/ellipsis.png" alt="menu" />
     </nav>
</header>