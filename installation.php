<?php 
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $path = 'icoapp/.env.example';
        $envPath = 'icoapp/.env';
        
        $data = $_POST;
        $app_url = $_POST['app_url'];

        $env = file_get_contents($envPath);
        $configs = explode("\n", $env);

        foreach($configs as $config){
            if($config != ""){
                $config = explode("=", $config);
                $configKey = strtolower($config[0]);
                $configVal = $config[1];//echo $configKey.'--'.$configVal.'---'.$data[$configKey].'<br>';

    
                if(isset($data[$configKey])){

                    $prevText = $config[0].'='.$configVal;
                    $newText = $config[0].'='.$data[$configKey];

                    file_put_contents($envPath, str_replace($prevText ,$newText , file_get_contents($envPath)));
                }
            }
        }


        $servername = ($_POST["db_host"])?$_POST["db_host"]:"127.0.0.1";
        $port = ($_POST["db_port"])?$_POST["db_port"]:"3306";
        $username = $_POST["db_username"];
        $password = $_POST["db_password"];
        $database = $_POST["db_database"];

        // Create connection
        $conn = new mysqli($servername, $username, $password);
        // Check connection
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        // Create database
        $sql = "CREATE DATABASE IF NOT EXISTS ".$database;
        if ($conn->query($sql) === TRUE) {
            echo "Database created successfully";
            $connDb = new mysqli($servername, $username, $password, $database);

            if ($connDb->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }else{

                // $full_sql = file_get_contents('db/cryptrum_icoapp.sql');
                // if($connDb->multi_query($full_sql) === TRUE){
                //     echo "Db processed successfully";
                // }else {
                //     echo "Error1 : " . $sql . "<br>" . $connDb->error;
                // }

                $lines = file('db/cryptrum_icoapp.sql');

                if ($lines) {
                    $sql = '';

                    foreach ($lines as $line) {
                        if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
                            $sql .= $line;
                            $status = '';

                            if (preg_match('/;\s*$/', $line)) {                                
                                if($connDb->query($sql) === TRUE){
                                    $status = true;
                                }else{
                                    echo $conn->error.'<br>';
                                }
                                $sql = '';
                            }
                        }
                    }
                }
            }
        } else {
            echo "Error creating database: " . $conn->error;
        }
        header('Location: '.$app_url);
        //print_r(file_get_contents($path));die;
    }
?>

<!DOCTYPE HTML>  
<html>
    <head>
        <style>
        .error {color: #FF0000;}
        </style>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body> 
        <div class="container" >
            <h2 class="text-center">Installation</h2>
            <form method="POST" action="" class="form-horizontal">
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>App Name</label>
                        <input type="text" name="app_name" class="form-control" required>
                    </div>
                    <div class="col-md-6" >
                        <label>App Url</label>
                        <input type="text" name="app_url" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>DB Host</label>
                        <input type="text" name="db_host" class="form-control" value="127.0.0.1" required>
                    </div>
                    <div class="col-md-6">
                        <label>DB Port</label>
                        <input type="text" name="db_port" class="form-control" value="3306" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>DB Name</label>
                        <input type="text" name="db_database" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>DB User Name</label>
                        <input type="text" name="db_username" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>DB Password</label>
                        <input type="password" name="db_password" class="form-control" >
                    </div>
                
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>SMTP Host</label>
                        <input type="text" name="smtp_host" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>SMTP Port</label>
                        <input type="text" name="smtp_port" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>SMTP Username</label>
                        <input type="text" name="mail_username" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>SMTP Password</label>
                        <input type="text" name="mail_password" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>SMTP Encryption</label>
                        <input type="text" name="mail_encryption" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>SMTP From Address</label>
                        <input type="text" name="mail_from_address" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-6">
                        <label>SMTP From Name</label>
                        <input type="text" name="mail_from_name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="col-md-12">
                        <input type="submit" name="submit" value="Submit" class="btn btn-info">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>