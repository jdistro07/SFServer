<html>
    <header>
        <title>Account Registration</title>
    </header>

    <body>
        <form action="mod_register.php">
            <input name="fname" type="text" placeholder="First Name"/>
            <input name="mname" type="text" placeholder="Middle Name"/>
            <input name="lname" type="text" placeholder="Last Name"/><br>
            <input name="birthdate" type="date"/><br>
            <input name="address" type="text" placeholder="Address"/><br>
            <input name="organization" type="text" placeholder="Organization"/><br>
            <input name="position" type="text" placeholder="Position"/><br>
            <input name="username" type="text" placeholder="Username" value="">
            <br>
            <input name="password" type="password" placeholder="Password"/><br>
            
            <select>
                <option value="1">Administrator</option>
                <option value="2">Teacher</option>
                <option value="3">Student</option>
            </select><br>
            <input name="register" type="submit" value="Register">
            <br>
        </form>
        <a href="dashboard.html"><button>Cancel</button></a>
    </body>
</html>

<?php



?>