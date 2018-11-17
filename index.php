<html>

<head>

    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="./css/pokedex.css">

    <script>
        function showMyAccount(navName) {
            var div = document.getElementsByClassName(navName)[0];
            if (div.style.display == "inherit") {
                return;
            } else {
                let navNames = [
                    "welcome",
                    "myaccount",
                    "mypokemon",
                    "storage",
                    "pokedex"
                ];
                for (let i = 0, n = navNames.length; i < n; i++) {
                    let div = document.getElementsByClassName(navNames[i])[0];
                    if (navNames[i] == navName) {
                        div.style.display = "inherit";
                    } else {
                        div.style.display = "none";
                    }
                }
            }
        }
    </script>

</head>

<body>

    <div id="container">

        <!-- HEADER -->
        <div onclick="location.href='./index.php'" id="header">
            <p>CPSC304-G13's PC</p>
        </div>

        <!-- NAVIGATION -->
        <div id="nav">
            <div class="user_container">
            </div>
            <div onclick="location.href='./php/myaccount.php'" class="nav-item">
                <p>MY ACCOUNT</p>
            </div>
            <div onclick="location.href='./php/mypokemon.php'" class="nav-item">
                <p>MY POKEMON</p>
            </div>
            <div onclick="location.href='./php/storage.php'" class="nav-item">
                <p>STORAGE</p>
            </div>
            <div onclick="location.href='./php/pokedex.php'" class="nav-item">
                <p>POKEDEX</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div id="content">
            <div class="welcome">
                <p>Welcome trainer.</p>
            </div>
        </div> 
    </div>



</body>

</html>