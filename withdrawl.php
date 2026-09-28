<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
    <style>
        form {
  max-width: 500px;
  margin: 40px auto;
  padding: 30px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  margin-bottom: 25px;
  color: #0056b3;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-weight: 500;
  color: #333;
}

input, select, textarea {
  width: 100%;
  padding: 12px;
  border: 1.5px solid #ccc;
  border-radius: 8px;
  font-size: 15px;
  background-color: #f9f9f9;
}

button[type="submit"] {
  width: 100%;
  padding: 14px;
  background-color: #0056b3;
  color: white;
  font-size: 16px;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #004494;
}

    </style>
</head>
<body>
    <form method="POST">
  <h2>Withdrawl Money</h2>
  
  <div class="form-group">
    <label for="accountNo">Account Number</label>
    <input type="text" id="accountNo" name="accountNo" placeholder="Enter account number" required>
  </div>
  <div class="form-group">
    <label for="amount">Withdrawl Amount (₹)</label>
    <input type="number" id="amount" name="amount" placeholder="Enter amount" required min="1">
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Enter password" required>
  </div>
  <button type="submit" name="submit">Withdrawl</button>
</form>
<?php
include('db.php');
session_start();
if(isset($_SESSION['EMAIL'])){
    if(isset($_POST['submit'])){
        $acno = $_POST['accountNo'];
        $amount = $_POST['amount'];
        $pass = $_POST['password'];
        $stmt=$conn->prepare("SELECT * FROM open_accounts where account_no = ?");
        $stmt->execute([$acno]);
        $result=$stmt->fetch();
        $amo = $result['initial_deposit'];
        $stm = $conn->prepare("SELECT * FROM users where email=?");
        $stm->execute([$_SESSION['EMAIL']]);
        $res = $stm->fetch();
        $p=$res['password'];
        if($stmt->rowCount()>0){
          if($p==$pass){
            $amo=$amo-$amount;
            $stmt=$conn->prepare("UPDATE open_accounts SET initial_deposit = ? where account_no = ?");
            $stmt->execute([$amo,$acno]);
            $stmt=$conn->prepare("INSERT INTO withdrawals (accountNo,amount) VALUES (?,?)");
            $stmt->execute([$acno,$amount]);
            echo "<script>alert('Withdrawl Successfully completed');
            window.location.href='dashboard.php'</script>";
          }else{
             echo "<script>alert('Incorrect password');</script>";
          }
        }else{
            echo "<script>alert('Account not found');</script>";
        }
    }
  }else{
    echo "<script>alert('Please Login First..');
    window.location.href='index.php';</script>";
  }
?>
</body>
</html>