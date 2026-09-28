<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body{
            background-repeat:no-repeat;
            background-size:cover;
            background-position:center;
            background-attachment:fixed;
        }
        #div1{
            margin:5% 0 0 50%;
            color:white;
            padding:5%;
            
        }
        #div1 a{
            color:white;
            padding:3%;
            text-decoration:none;
            font-size:120%;
        }
        .div2{
            border:1px white solid;
            padding:3%;
            border-radius:10px; 
            text-align:center;
        }
        .div2:hover{
            color:cyan;
            font-weight:500%;
            border:2px cyan solid;
        }
        #a1 {
  display: inline-block;
  float:right;
  margin-right:7%;
  padding: 12px 24px;
  color: #ffffff;
  text-decoration: none;
  font-size: 130%;
  font-weight: 600;
  border-radius: 8px;
  transition: background-color 0.3s ease, transform 0.2s;
}

#a1:hover {
  color:cyan;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 86, 179, 0.2);
}

#a1:active {
  transform: translateY(0);
  box-shadow: none;
}

    </style>
</head>
<body background="img/dashboard.jpg">
    <header>
        <a id='a1' href="index.php">LOGIN</a>
    </header>
    <div id="div1">
        <a href="account.php"><div class="div2">CREATE NEW ACCOUNT</div></a>
        <a href="deposit.php"><div class="div2">DEPOSIT</div></a>
        <a href="withdrawl.php"><div class="div2">WITHDRAWL</div></a>
        <a href="balance.php"><div class="div2">BALANCE ENQUIRY</div></a>
        <a href="transfer.php"><div class="div2">TRANSFER MONEY</div></a>
        <a href="logout.php"><div class="div2">LOGOUT</div></a>
    </div>
</body>
</html>