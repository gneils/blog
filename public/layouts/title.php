<body>
    <div class="container">
        <div id="header" class="row">
             <div class="col-xs-8 col-md-8">
                 <h1><a href="<?php echo WEB_ROOT?>">Our Blog</a></h1>
             </div>
             <div id="logout" class="col-xs-4 col-md-4">
                <?php 
                    if ($session->is_logged_in()) {
                        $output = '<a href="'.WEB_ROOT.'/admin/logout.php"';
                        $output .= ' title="'.h($_SESSION["username"]).'">Log Out</a>';
                        echo $output;
                    } else {
                        echo "<a href=\"".WEB_ROOT."/admin/login.php\">Log In</a>";
                    }
                ?>
            </div>
        </div>