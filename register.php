<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
       * {
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: #f5f7fa;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px 20px;
  margin: 0;
  min-height: 100vh;
}

form {
  background-color: #ffffff;
  padding: 40px 30px;
  border-radius: 12px;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 480px;
}

h2 {
  text-align: center;
  margin-bottom: 30px;
  font-size: 24px;
  color: #002d62;
  font-weight: 600;
}

.form-group {
  margin-bottom: 22px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-size: 15px;
  font-weight: 500;
  color: #333;
}

input {
  width: 100%;
  padding: 12px 14px;
  border: 1.5px solid #cbd5e0;
  border-radius: 8px;
  background-color: #f9f9f9;
  font-size: 15px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus {
  border-color: #0056b3;
  background-color: #fff;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.1);
}

#b1 {
  width: 100%;
  padding: 14px;
  background-color: #0056b3;
  color: #ffffff;
  font-size: 16px;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 15px;
  transition: background-color 0.3s ease, transform 0.2s;
}

#b1:hover {
  background-color: #004494;
  transform: translateY(-1px);
}

    </style>
</head>
<body>

<form method="POST">
    <h2>Registration Form</h2>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>
        </div>
        <div class="form-group">
            <label for="confirm">Confirm Password</label>
            <input type="password" id="confirm" name="confirm" placeholder="Repeat your password" required>
        </div>
    </div>

    <button type="submit" name="Register" id="b1">Register</button>
</form>
<?php
    include('db.php');
    if(isset($_POST['Register'])){
        $mail = $_POST['email'];
        $pass = $_POST['password'];
        $conf = $_POST['confirm'];
        if($pass==$conf){
            $check=$conn->prepare("SELECT * FROM users where email=?");
            $check->execute([$mail]);
            if($check->rowCount()>0){
                echo "<script>alert('Login credentials already exists');
                 window.location.href='index.php';</script>";    
            }else{
            $stmt = $conn->prepare("INSERT INTO users (email,password) VALUES (?,?)");
            $stmt->execute([$mail,$pass]);
            $_SESSION['EMAIL']=$email;
            echo "<script>
            alert('Registered Successfully');
            window.location.href='index.php';
            </script>";
            }
        }else{
            echo "<script>alert('both passwords not matched');</script>";
        }
    }
?>
</body>
</html>
