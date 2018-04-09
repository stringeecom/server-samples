<!DOCTYPE html>
<html>
    <head>
        <title>AZGram Web Chat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="<?= STATIC_URL ?>libs/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?= STATIC_URL ?>libs/bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?= STATIC_URL ?>plugins/nanoscroller/css/nanoscroller.css" rel="stylesheet" type="text/css">

        <!-- my style -->
        <link href="<?= STATIC_URL ?>css/login.css" rel="stylesheet" type="text/css">
        <!-- END my style -->

        <!--JS-->
        <script src="<?= STATIC_URL ?>libs/jquery/1.11.2/jquery-1.11.2.min.js" type="text/javascript"></script>
        <script src="<?= STATIC_URL ?>libs/bootstrap-3.3.6-dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?= STATIC_URL ?>libs/angular-1.5.0-rc.0/angular.min.js" type="text/javascript"></script>
        <script src="<?= STATIC_URL ?>libs/angular-1.5.0-rc.0/angular-route.min.js" type="text/javascript"></script>
        <script src="<?= STATIC_URL ?>plugins/nanoscroller/js/jquery.nanoscroller.js" type="text/javascript"></script>
        <!-- END js -->
        <link rel="shortcut icon" href="<?= STATIC_URL ?>favicon.ico" />
    </head>
    <body>
        <section>
            <div class="bg_head_log"></div>
            <div class="login_page">
                <!-- Login header -->
                <div class="login_head">
                    <a href="<?= BASE_URL ?>"><img src="<?= STATIC_URL ?>images/my_img/logo-az.png"></a>
                    <div class="login_head_submit"></div>
                </div>
                <!-- END login header -->
                
                <!-- Login form -->
                <?= $this->layout->content ?>
                
                <div style="clear: both"></div>
                <!-- END Login form -->
                
                <!-- Login footer -->
                <div class="login_footer">
                    <p>
                        <a href="http://emma.azstack.com/chat/">AZGram</a>
                    </p>
                    <p>Copyright (C) 2016 - 2020. Powered by AZStack Pte. Ltd</p>
                    <p><a href="https://www.azstack.co/">Learn more</a></p>
                </div>
                <!-- END login footer -->
            </div>

        </section>
        <script>
            function getAvatarByName(fullname) {
                if (fullname != null) {
                    fullname = fullname.trim().toUpperCase();
                    if (fullname != "") {
                        var split = fullname.split(" ");
                        if (split.length < 2) {
                            return split[0][0];
                        }
                        return split[0][0] + split[split.length - 1][0];
                    }
                }
                return "";
            }
        </script>
    </body>
</html>
