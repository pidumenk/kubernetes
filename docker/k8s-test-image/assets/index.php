<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <?php
        $ip_server = $_SERVER[ 'SERVER_ADDR' ];
        echo "<body style='background-color:white'>";
        echo "<h1><center>Hello from Kubernetes</h1></center><br>";
        echo "<center>Server IP address is: $ip_server", "<br></center><p>";
        echo "<center>Made by <font color=blue>Pavel Dumenko</center>";
        ?>
        <div>
           <p style="text-align:center;"> <img src="./k8s.png" alt="myPic" /></p>
        </div>
    </body>
</html>