<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">Menu</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item nav_to_home">
                <a class="nav-link" href="index.php">Home<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item nav_to_search">
                <a class="nav-link" href="search.php">Search<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item nav_to_new_webpage">
                <a class="nav-link" href="new_website.php">Add a Website</a>
            </li>
            <li class="nav-item nav_to_logout logout">
                <a class="nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<input type="hidden" name="active_page" value="<?php echo $page ?>">
<script type="text/javascript" src="/js/scripts_for_head.js">

</script>
<script>
    $(".logout").on("click", function() {
        window.location = "api/logout.php";
    })
</script>
