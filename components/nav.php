<span class="logo"><a href="/sinterklaas/">SINTERKLAAS/</a></span>
<ul id="menu">
    <?php 
        if (isset($_SESSION['username'])) {
    ?>
            <li class="item"><a href="mijn_lijstje/"><i class="fas fa-list-ul"></i> Mijn lijstje</a></li>
            <li class="item button"><a href="logout/">Logout <i class="fas fa-sign-out-alt"></i></a></li>
    <?php
        } else {
    ?>
            <li class="item button"><a href="/users/?redirectedFrom=sinterklaas/"><i class="fas fa-sign-in-alt"></i> Login</a></li>
    <?php
        }
    ?>
</ul>