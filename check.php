<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Form Input</title>
    <script>
        function checkOption(value) {
            const otherInput = document.getElementById("otherInput");
            if (value === "Other") {
                otherInput.style.display = "block";
                otherInput.disabled = false;
            } else {
                otherInput.style.display = "none";
                otherInput.disabled = true;
            }
        }
    </script>
</head>
<body>

<h2>Choose an option:</h2>
<form>
    <label for="options">Select category:</label>
    <select id="options" onchange="checkOption(this.value)">
        <option value="">--Select--</option>
        <option value="Student">Student</option>
        <option value="Teacher">Teacher</option>
        <option value="Other">Other</option>
    </select>

    <br><br>

    <label for="otherInput" style="display:none;" id="otherLabel">Please specify:</label>
    <input type="text" id="otherInput" name="other" placeholder="Enter your role" disabled style="display:none;">
</form>

</body>
</html>
