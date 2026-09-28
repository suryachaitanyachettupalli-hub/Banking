<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Fund Transfer</title>
  <style>
    body {
      background: linear-gradient(to right, #e0eafc, #cfdef3);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #fff;
      padding: 30px 40px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      width: 400px;
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

    input, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 15px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #27ae60;
      border: none;
      color: white;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #1e8449;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Transfer Money</h2>
    <form method="POST" action="">
      <label for="fromAccount">From Account Number</label>
      <input type="text" id="fromAccount" name="fromAccount" required placeholder="Sender's account number">

      <label for="toAccount">To Account Number</label>
      <input type="text" id="toAccount" name="toAccount" required placeholder="Recipient's account number">

      <label for="amount">Amount (₹)</label>
      <input type="number" id="amount" name="amount" required min="1" placeholder="Enter amount to transfer">

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter password">

      <input type="hidden" name="mode" value="Online_transfer">

      <button type="submit" name="transfer">Transfer</button>
    </form>
  </div>

<?php
include('db.php');
session_start();

if (!isset($_SESSION['EMAIL'])) {
    echo "<script>alert('Please Login First..'); window.location.href='index.php';</script>";
    exit;
}

if (isset($_POST['transfer'])) {
    $facno = $_POST['fromAccount'];
    $acno = $_POST['toAccount'];
    $amount = $_POST['amount'];
    $pass = $_POST['password'];
    $mode = $_POST['mode'];

    // Get sender info
    $stm = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stm->execute([$_SESSION['EMAIL']]);
    $user = $stm->fetch();

    if (!$user || $user['password'] !== $pass) {
        echo "<script>alert('Incorrect password');</script>";
        exit;
    }

    // Validate sender's account
    $stmt = $conn->prepare("SELECT * FROM open_accounts WHERE account_no = ?");
    $stmt->execute([$facno]);
    $sender = $stmt->fetch();

    if (!$sender) {
        echo "<script>alert('Sender account not found');</script>";
        exit;
    }

    // Check if sender has enough balance
    if ($sender['initial_deposit'] < $amount) {
        echo "<script>alert('Insufficient balance');</script>";
        exit;
    }

    // Validate recipient's account
    $stmt = $conn->prepare("SELECT * FROM open_accounts WHERE account_no = ?");
    $stmt->execute([$acno]);
    $recipient = $stmt->fetch();

    if (!$recipient) {
        echo "<script>alert('Recipient account not found');</script>";
        exit;
    }

    // Perform transfer inside a transaction
    try {
        $conn->beginTransaction();

        // Update sender balance
        $newSenderBalance = $sender['initial_deposit'] - $amount;
        $stmt = $conn->prepare("UPDATE open_accounts SET initial_deposit = ? WHERE account_no = ?");
        $stmt->execute([$newSenderBalance, $facno]);

        // Record withdrawal
        $stmt = $conn->prepare("INSERT INTO withdrawals (accountNo, amount) VALUES (?, ?)");
        $stmt->execute([$facno, $amount]);

        // Update recipient balance
        $newRecipientBalance = $recipient['initial_deposit'] + $amount;
        $stmt = $conn->prepare("UPDATE open_accounts SET initial_deposit = ? WHERE account_no = ?");
        $stmt->execute([$newRecipientBalance, $acno]);

        // Record deposit
        $stmt = $conn->prepare("INSERT INTO deposits (accountNo, amount, depositMode) VALUES (?, ?, ?)");
        $stmt->execute([$acno, $amount, $mode]);

        $conn->commit();

        echo "<script>alert('Transfer completed successfully'); window.location.href='dashboard.php';</script>";
    } catch (Exception $e) {
        $conn->rollBack();
        echo "<script>alert('Transaction failed. Please try again.');</script>";
    }
}
?>
</body>
</html>
