<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia</title>
    <link rel="stylesheet" href="styles.css">
    <script src="kolorujtlo.js" defer></script>
    <script src="timedate.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    <div id="zegarek"></div>
    <div id="data"></div>
    <header>
        <h1>Historia Komputerow</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="html/about.html">Historia</a></li>
            <li><a href="html/gallery.html">Galeria Komputerow</a></li>
            <li><a href="html/services.html">Programy Komputerowe</a></li>
            <li><a href="html/future.html">Przyszłość</a></li>
            <li><a href="html/contact.html">Kontakt</a></li>
        </ul>
    </nav>

    <main>
        <h2>Początki Komputerow</h2>
        <div class="text-with-image">
            <img src="img/1.png" alt="ENIAC" style="float:left; margin-right: 15px;">
            <p><b>ENIAC
                Nazwa tego komputera pochodzi od skrótu Electronic Numerical Integrator And Copmuter.
                Został stworzony w 1945 roku przez naukowców
                Uniwersytetu w Pensylwanii w USA. ENIAC był
                bardzo dużym urządzeniem, gdyż zajmował 167 m2
                powierzchni, składał się z 42 szaf, miał prawie 2,5
                metra wysokości i 24 metry długości, a do jego obsługi
                potrzeba było wielu pracowników. Ważył 27 ton! Jego
                produkcja kosztowała ponad 6 milionów dolarów i był
                zaprojektowany głównie do produkcji tablic
                balistycznych. Komputer ten pracował z rekordową
                szybkością jak na tamte czasy 0,1 Mhz. Dzisiejsze
                smartfony są około 50 tysięcy razy szybsze od
                ENIAC-a</p>
        </div>

        <h2>Era Komputer desktop</h2>
        <div class="text-with-image" style="overflow: hidden;">
            <img src="img/2.png" alt="cdc6600" style="float:right; margin-left: 15px;">
            <p>W latach 60-tych XX wieku pojawił się komputer CDC 6600, który był
                najpotężniejszym komputerem dosktopowym na świecie. Zajmował on całe
                biurko i nie był dostępny dla zwykłego użytkownika.
                Pierwsze komputery stacjonarne, które były dostępne dla zwykłych użytkowników pojawiły się na
                rynku dopiero w latach 80-tych XX wieku, czyli prawie 40 lat po ENIAC-u. 
                </p>
        </div>

        <h2>Laptopy</h2>
        <div class="text-with-image">
            <img src="img/3.png" alt="Grid Compass Computer 1109" style="float:left; margin-right: 15px;">
            <p>rzez wiele lat komputery stacjonarne były powszechnym urządzeniem domowym. Miały
                jednak jedną wadę – nie były łatwo przenośne i nie można było z nimi podróżować. Sytuację zmieniło
                pojawienie się komputerów przenośnych – laptopów, z których można było korzystać nie tylko w
                jednym określonym miejscu.
                Pomimo, iż prawdziwa kariera laptopów rozpoczęła się w latach 90-tych XX wieku, to
                pierwszy taki komputer przenośny pojawił się 20 lat wcześniej. Pomysłodawcą takiej koncepcji był
                Alan Key, pracownik firmy Xerox PARC, jednak jego pomysły nie został przyjęty i nie wszedł do
                masowej produkcji.</p>
        </div>

        
        <form method="POST" name="background">
            <input type="button" value="żółty" onclick="changeBackground('#FFF000')"> 
            <input type="button" value="czarny" onclick="changeBackground('#000000')">
            <input type="button" value="biały" onclick="changeBackground('#FFFFFF')"> 
            <input type="button" value="niebieski" onclick="changeBackground('#0000FF')"> 
            <input type="button" value="pomarańczowy" onclick="changeBackground('#FF8000')">
            <input type="button" value="szary" onclick="changeBackground('#C0C0C0')"> 
            <input type="button" value="czerwony" onclick="changeBackground('#FF0000')"> 
        </form>

        <div id="animacjal" class="test-block">Kliknij, a się powiększę</div>
        <div id="animacja2" class="test-block">Najedz, a sie powieksze</div>
        <div id="animacja3" class="test-block">
            Kliknij, a bede sie powiekszac
        </div>

    </main>

    <footer>
        <p>&copy; Bartosz Koperski</p>
    </footer>
    <script>
        
        $("#animacjal").on("click", function() {
            $(this).animate({
                width: "500px",
                opacity: 0.4,
                fontSize: "3em",
                borderWidth: "10px"
            }, 1500);
        });

        
        $("#animacja2").on({
            "mouseover": function() {
                $(this).animate({
                    width: "300px"
                }, 800);
            },
            "mouseout": function() {
                $(this).animate({
                    width: "200px"
                }, 800);
            }
        });
        $("#animacja3").on("click", function() {
            if (!$(this).is(":animated")) {
                $(this).animate({
                    width: "+=50",
                    height: "+=50", 
                    opacity: 0.1
                }, 3000); 
            }
        });
    </script>

</body>
</html>
