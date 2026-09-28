<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank</title>
    <style>
         html{
            margin:0;   
            top:0;
        }
        body {
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
        }
        #form1{
            color:white;
            border:1px white solid;
            border-radius:12px;
            margin:10% 27% 0 27%;
            backdrop-filter:blur(2px);
            padding:0 6% 0  6%;

        }
        #div1{
            text-align:left;
            font-size:100%;
            margin:5%;
        } 
        input[type="email"],
        input[type="password"] {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #ccc;
        border-radius: 10px;
        margin-top: 6px;
        font-size: 15px;
        transition: 0.3s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
        border-color: #4facfe;
        box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
        outline: none;
        }

        #button1 {
        width: 50%;
        padding: 2%;
        margin-top: 8%;
        border: none;
        background-color: #4facfe;
        color: white;
        font-size: 100%;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
        }

        #button1:hover {
        background-color: #00c6ff;
        }

        form h2:last-child {    
        text-align: center;
        font-size: 14px;
        margin-top: 20px;
        }

        form a {
        color: #4facfe;
        text-decoration: none;
        font-weight: bold;
        }

        form a:hover {
        text-decoration: underline;
        }


    </style>
</head>
<body background="img\login.jpg">
    <form method="POST" action="index.php" id="form1">
            <div id="div1">
                <h1 style="text-align:center;";>LOGIN</h1><br>
                <h2><label>Email : </label><input type="email" name="email" placeholder="enter your email id...." required></h2><br>
                <h2><label>Password : </label><input type="password" name="pass" placeholder="enter password...." required></h2>
                <button type="submit" id="button1" name="login">Submit</button>
            </div>  
        <h2 style="text-align:center;margin:11% 0 4% 0;font-size:150%;">If haven't already register? please register now  <a href="register.php">Register</a></h2>
    </form>
    <?php
        include('db.php');
        if(isset($_POST['login'])){
            $email = $_POST['email'];
            $pass = $_POST['pass'];
            $stmt = $conn->prepare("SELECT * FROM users where email=?");
            $stmt->execute([$email]);
            $user=$stmt->fetch();
            if($stmt->rowCount()>0){
                if($pass==$user['password']){
                    $_SESSION['EMAIL']=$email;
                   $_SESSION['ID']=$user['id'];
                    echo "<script>alert('Your Authentication is completed Successfully');
                window.location.href='dashboard.php';</script>";
                }
                else{
                    echo "<script>alert('Incorrect password');
                window.location.href='index.php';</script>";
                }
            }else{
                echo "<script>alert('Not Registered Yet');
                window.location.href='register.php';</script>";
            }
        }
    ?>
</body>
</html>