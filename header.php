<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory</title>
</head>

<body>
    <header>
        <div>
        <nav>
                <ul class="menu">
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="connexion.php">Connexion</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                    <li> Articles
                        <ul class="sub-menu">
                            <li><a href="article.php">Créer un nouvel article</a></li>
                            <li><a href="articles.php">Voir tout les articles</a></li>
                        </ul>
                    </li>
                    <li><a href="memory.php">Memory</a></li>
                </ul>
            </nav>
        </div>
    </header>
</body>
</html>
<style>
    * {
  margin: 0;
  padding: 0;
  list-style-type: none;
  box-sizing: border-box;
}

nav {
  text-align: center;
  margin-bottom: 5%;
}

nav a {
  color: #ffffff;
  text-decoration: none;
}

/* code menu */

.menu {
  margin-top: 0;
  display: inline-block;
  color: #ffffff;
}

.menu>li {
  float: left;
  color: #ffffff;
  width: 140px;
  height: 40px;
  line-height: 40px;
  background: rgba(1, 4, 26, 0.7);
  cursor: pointer;
  font-size: 17px;
}

.sub-menu {
  transform: scale(0);
  transform-origin: top center;
  transition: all 300ms ease-in-out;
  color: #ffffff;
}

.sub-menu li {
  font-size: 14px;
  background: rgba(0, 0, 0, 0.8);
  padding: 8px 0;
  color: white;
  border-bottom: 1px solid rgba(0, 0, 0, 0.489);
  transform: scale(0);
  transform-origin: top center;
  transition: all 300ms ease-in-out;
}

.sub-menu li:last-child {
  border-bottom: 0;
}

.sub-menu li:hover {
  background: rgb(0, 0, 0);
}

.menu>li:hover .sub-menu li {
  transform: scale(1);
}

.menu>li:hover .sub-menu {
  transform: scale(1);
}

/* fin code menu */
</style>