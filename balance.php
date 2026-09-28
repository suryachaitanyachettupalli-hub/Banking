<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Balance Enquiry</title>
  <style>
    body {
      background: linear-gradient(to right, #74ebd5, #9face6);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 35px 40px;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
      width: 400px;
      animation: fadeIn 0.6s ease-in-out;
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
      color: #34495e;
    }

    input {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 15px;
      transition: border 0.3s ease;
    }

    input:focus {
      border-color: #2980b9;
      outline: none;
      box-shadow: 0 0 6px rgba(41, 128, 185, 0.2);
    }

    button {
      width: 100%;
      padding: 12px;
      border: none;
      background-color: #2980b9;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #1f5f8b;
    }

    .balance-card {
      display:;
      margin-top: 20px;
      text-align: center;
    }

    .balance-amount {
      font-size: 32px;
      color: #27ae60;
      font-weight: bold;
      margin: 15px 0;
    }

    .details {
      background-color: #f3f4f7;
      padding: 12px;
      border-radius: 10px;
      margin-top: 10px;
      text-align: left;
    }

    .details span {
      display: block;
      color: #34495e;
      font-size: 15px;
      margin: 6px 0;
    }

    @keyframes fadeIn {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }
  </style>
</head>
<body>  

  <div class="container" id="container">
    <h2>Balance Enquiry</h2>

    <form method="POST" id="form1">
      <label for="accountNo">Account Number</label>
      <input type="text" id="accountNo" name="accountNo" required />

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required />

      <button type="submit" name="submit">Check Balance</button>
    </form>
<?php
include('db.php');
session_start();
if(isset($_SESSION['EMAIL'])){
    if(isset($_POST['submit'])){
        $acno=$_POST['accountNo'];
        $password=$_POST['password'];
        $stmt=$conn->prepare("SELECT * FROM open_accounts where account_no = ?");
        $stmt->execute([$acno]);
        $result=$stmt->fetch();
        //$ac_no=$result['account_no'];
        if($stmt->rowCount()>0){
          $u_name=$result['fullname'];
          $type=$result['account_type'];
       // $updated_at=$result['created_at'];
          $amount=$result['initial_deposit'];
            if($result['email']==$_SESSION['EMAIL']){
                $stm = $conn->prepare("SELECT * FROM users where email=?");
                $stm->execute([$_SESSION['EMAIL']]);
                $res = $stm->fetch();
                $p=$res['password'];
                if($p==$password){
                    echo "<div class='balance-card' id='balanceCard'>
                    <div class='balance-amount'>{$amount}</div>
                    <div class='details'>
                    <span><strong>Account Number:</strong> {$acno}</span>
                    <span><strong>Account Holder:</strong> {$u_name}</span>
                    <span><strong>Account Type:</strong> {$type}</span>
                    </div>
                    </div>";
                }else{
                echo "<script>alert('Incorrect password');</script>";
                }
            }else{
            echo "<script>alert('YOUR ACCOUNT NOT FOUND IN THE CURRENT LOGIN');
            </script>";
            }
        }else{
          echo "<script>alert('Account not found');</script>";
        }
    }else{
        //echo "<script>alert('not submitted yet');</script>";
    }
}else{
    echo "<script>alert('Please Login First..');
    window.location.href='index.php';</script>";
}
?>


</body>
</html>
