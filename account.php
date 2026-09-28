<?php 
session_start();
   include('db.php');
    if($_SESSION['EMAIL']){
      if(isset($_POST['Submit'])) {
        $S_name = strtoupper($_POST['surname']);
        $F_name = strtoupper($_POST['firstname']);
        $SE_name = strtoupper($_POST['secondname']);
        $dob = $_POST['dob'];
        $age = $_POST['age'];
        $mobile = $_POST['mobile'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $aadhar = $_POST['aadhar'];
        $account_type = $_POST['accountType'];
        $initial_deposit = $_POST['initialDeposit'];
        $u_id=$_SESSION['ID'];
        $a=220300580000;
        $res = $a+$u_id;
        $stmt= $conn->prepare("SELECT * FROM open_accounts where aadhar =?");
        $stmt->execute([$aadhar]);
        $result = $stmt->fetch();
        $mail=$_SESSION['EMAIL'];
        $Full_name=$S_name." ".$F_name." ".$SE_name;
        if (trim(strtolower($mail)) == trim(strtolower($email))) {
          if($result){
           echo "<script>alert('Account already exists');
           window.location.href='dashboard.php';
           </script>";
          } else{
            $stmt = $conn->prepare("INSERT INTO open_accounts (surname,firstname,secondname,dob,age,mobile,gender,email,aadhar,account_no,account_type,initial_deposit,fullname) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute([$S_name,$F_name,$SE_name,$dob,$age,$mobile,$gender,$email,$aadhar,$res,$account_type,$initial_deposit,$Full_name]);
            echo "<script>alert('Account Created Successfully');
            window.location.href='dashboard.php';
            </script>";
          }
        }else{
        echo "<script>alert('Please check whether the email given and email you logged in are same');</script>";
        }
      }else{
        echo "";
      }
    }else{
      echo "<script>alert('Please Login First...');</script>";
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>CREATE NEW ACCOUNT</title>
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
}

form {
  background-color: #ffffff;
  padding: 40px 30px;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
  width: 100%;
  max-width: 960px;
}

h2 {
  text-align: center;
  margin-bottom: 35px;
  color: #002d62;
  font-weight: 600;
  font-size: 26px;
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 24px;
  margin-bottom: 22px;
}

.form-group {
  flex: 1;
  min-width: 260px;
}

label {
  display: block;
  margin-bottom: 8px;
  font-size: 15px;
  font-weight: 500;
  color: #333;
}

input,
select {
  width: 100%;
  padding: 12px 14px;
  border: 1.5px solid #cbd5e0;
  border-radius: 8px;
  background-color: #f9f9f9;
  font-size: 15px;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

input:focus,
select:focus {
  border-color: #0056b3;
  background-color: #fff;
  outline: none;
  box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.1);
}

input[readonly] {
  background-color: #f1f5f9;
  cursor: not-allowed;
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

@media (max-width: 768px) {
  .form-row {
    flex-direction: column;
  }
}
button[type="submit"] {
  background-color: #0077cc;
  color: #fff;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  font-weight: 600;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s;
  width: 100%;
  max-width: 100%;
  margin:2% 0 0 0;
}

button[type="submit"]:hover {
  background-color: #005fa3;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 119, 204, 0.2);
}

button[type="submit"]:active {
  transform: translateY(0);
  box-shadow: none;
}


  </style>
</head>
<body>

 <div class="form-container">
  <h2>Open New Account</h2>
  <form method="POST">
     <div class="form-row">
        <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" id="surname" name="surname" placeholder="Enter your surname" required>
        </div>
        <div class="form-group">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="Enter your first name" required>
        </div>
        <div class="form-group">
            <label for="secondname">Second Name</label>
            <input type="text" id="secondname" name="secondname" placeholder="Enter your second name">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required onchange="calculateAge()">
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" id="age" name="age" placeholder="Calculated automatically" readonly required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="tel" id="mobile" name="mobile" placeholder="10-digit number" pattern="[0-9]{10}" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>
         <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
        </div>
    </div>
     <div class="form-row">
     <div class="form-group">
    <label for="aadhar">Aadhaar Number</label>
    <input type="text" id="aadhar" name="aadhar" maxlength="12" pattern="\d{12}" required placeholder="Enter 12-digit Aadhaar">
</div>

 <div class="form-group">
    <label for="accountType">Account Type</label>
    <select id="accountType" name="accountType" required onchange="toggleExtraInput()">
      <option value="">-- Select Account Type --</option>
      <option value="zero_balance">Zero Balance Account</option>
      <option value="savings">Savings Account</option>
      <option value="current">Current</option>
    </select>
</div>
</div>
    <div id="extraField" style="display: none;">
      <label for="initialDeposit">Initial Deposit Amount</label>
      <input type="number" id="initialDeposit" name="initialDeposit" placeholder="Enter initial deposit">
    </div>

    <button type="submit" name="Submit">Submit</button>
  </form>
</div>
<script>
  function toggleExtraInput() {
    const accountType = document.getElementById("accountType").value;
    const extraField = document.getElementById("extraField");

    if (accountType === "savings"||accountType==="current") {
      extraField.style.display = "block";
    } else {
      extraField.style.display = "none";
    }
  }
</script>
</body>
</html>
