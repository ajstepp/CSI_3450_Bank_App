<?php


// Function createa DB connection
function connectToDB()
{   
    global $conn;
    
    $servername = "localhost";
    $username = "root";         // Local instance
    $password = "root";
    $dbname = "Bank";     // Local instance
    
    //echo "DEBUG: Connecting to DB <br>";
	$conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }  
}


// Function is main page view
function showMembers()
{
    global $conn;
    global $thisPHP;
    
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>Click to Insert New member to Database</legend>";
    echo "<input type='submit' name='showInsertForm' value='Add New customer'> <br><br>";
    echo "<input type='submit' name='showAccts' value='View Loans'> <br><br>";
    echo "<input type='text' name='search' value='' size='20'>";
    echo "<input type='submit' name='btnSearch' value='search'>";
    echo "<input type='submit' name='btnRestore' value='restore'>";
    echo "</form></fieldset>";
    
    $s=$_POST['search'];

    
    
    if(!empty($s)) {
        echo "<h4>Filtered Search</h4>";
    }
    
     $sql = "SELECT * FROM MEMBERS JOIN ADDRESSES ON ADDRESSES_ADDRESS_ID = ADDRESS_ID WHERE MEMBER_FNAME LIKE '%$s%' OR MEMBER_LNAME LIKE '%$s%' OR MEMBER_ID LIKE '%$s%' ORDER BY MEMBER_ID ASC";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><td>Last Name</td><td>First Name</td><td>Phone</td><td>Date of Birth</td><td>Zip code</td><td>View Accounts</td><td>View Address</td><td>Create Account</td><td>Update</td><td>Delete</td></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tbody>";
                echo "<tr><td>" . $row["MEMBER_LNAME"] . "</td><td> " . $row["MEMBER_FNAME"] . "</td><td>" . $row["MEMBER_PHONE"] . "</td><td>" .$row["MEMBER_DOB"] . "</td><td>" .$row["ZIP_CODE"] .  "<td>";
                
                echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
                echo "<input type='hidden' name='ACCOUNT_NUMBER' value='{$row[ACCOUNT_NUMBER]}'>";
                echo "<input type='hidden' name='CURRENT_BALANCE' value='{$row[CURRENT_BALANCE]}'>";
                echo "<input type='hidden' name='MEMBER_ID' value='{$row[MEMBER_ID]}'>";
                echo "<input type='hidden' name='MEMBER_FNAME' value='{$row[MEMBER_FNAME]}'>";
                echo "<input type='hidden' name='MEMBER_LNAME' value='{$row[MEMBER_LNAME]}'>";
                echo "<input type='hidden' name='ADDRESS_ID' value='{$row[ADDRESS_ID]}'>";
                echo "<input type='submit' name='showMemAccounts' value='View Member Accounts'></td><td>";
                echo "<input type='submit' name='showMemAddress' value='View Member Address'></td><td>";
                echo "<input type='submit' name='showAccountForm' value='Add New Account'></td><td>";
                echo "<input type='submit' name='showUpdateForm' value='update'></td><td>";
                echo "<input type='submit' name='btnDelete' value='Delete'></form>";
                echo "</td></tr></tbody>";
            }
            
            echo "</table>";
            
        } else {
            echo "No Journal Records Found <br>";
        }
    
}


//function shows loans linked to membes
function showAccts()
{
    global $conn;
    global $thisPHP;
    
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>Click to Insert New member to Database</legend>";
    echo "<input type='submit' name='showInsertForm' value='Add New customer'> <br><br>";
    echo "<input type='submit' name='btnRestore' value='restore'>";
    echo "</form></fieldset>";
    
     $sql = "SELECT * FROM LOANS INNER JOIN TRANSACTIONS ON LOANS.TRANSACTIONS_TRANSACTION_ID=TRANSACTION_ID INNER JOIN ACCOUNTS ON TRANSACTIONS.ACCOUNTS_ACCOUNT_NUMBER = ACCOUNTS.ACCOUNT_NUMBER INNER JOIN MEMBERS ON ACCOUNTS.MEMBERS_MEMBER_ID = MEMBERS.MEMBER_ID ORDER BY ACCOUNT_NUMBER ASC";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><td>Last Name</td><td>First Name</td><td>Loan Amount</td><td>Interest Rate</td></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tbody>";
                echo "<tr><td>"  . $row["MEMBER_LNAME"] . " <td> " . $row["MEMBER_FNAME"] . "</td><td>$" . $row["TRANSACTION_AMOUNT"] .  "</td> <td>" . $row["INTEREST_RATE"];
                
                echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
                echo "<input type='hidden' name='ACCOUNT_NUMBER' value='{$row["ACCOUNT_NUMBER"]}'>";
                echo "<input type='hidden' name='CURRENT_BALANCE' value='{$row["CURRENT_BALANCE"]}'>";
                echo "<input type='hidden' name='MEMBER_ID' value='{$row["MEMBER_ID"]}'></form>";
                echo "%</td></tr></tbody>";
            }
            
            echo "</table>";
            
        } else {
            echo "No Journal Records Found <br>";
        }
    
}


// function shows accounts linked to members
function showMemAccts()
{
    
    global $conn;
    global $thisPHP;
    
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>$_POST[MEMBER_FNAME] $_POST[MEMBER_LNAME]</legend>";
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<input type='submit' name='btnRestore' value='restore'>";
    echo "</form></fieldset>";
    
     $sql = "SELECT * FROM ACCOUNTS WHERE MEMBERS_MEMBER_ID = $_POST[MEMBER_ID]";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><td>Account No.</td><td>Balance</td><td>See Transactions</td><td>Loan</td><td>Update</td><td>Delete</td></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tbody>";
                echo "<tr><td>" . $row["ACCOUNT_NUMBER"] . "</td> <td>$" . $row["CURRENT_BALANCE"] .  "</td> <td>";
                
                echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
                echo "<input type='hidden' name='ACCOUNT_NUMBER' value='{$row[ACCOUNT_NUMBER]}'>";
                echo "<input type='hidden' name='CURRENT_BALANCE' value='{$row[CURRENT_BALANCE]}'>";
                echo "<input type='hidden' name='MEMBER_ID' value='{$row[MEMBER_ID]}'>";
                echo "<input type='submit' name='showTransForm' value='Transactions'></td><td>";
                echo "<input type='submit' name='showLoanForm' value='Get A Loan'></td><td>";
                echo "<input type='submit' name='showAcctUpdateForm' value='update'></td><td>";
                echo "<input type='submit' name='btnDeleteAcct' value='Delete'></form>";
                echo "</td></tr></tbody>";
            }
            echo "</table>";
            
        } else {
            echo "No Journal Records Found <br>";
        }
    echo "<input type='hidden' name='MEMBER_ID' value='{$MEMBER_ID}'>";
    
}


//function shows address linked to members
function showMemAddress()
{
    
    global $conn;
    global $thisPHP;
    
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>$_POST[MEMBER_FNAME] $_POST[MEMBER_LNAME]</legend>";
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<input type='submit' name='btnRestore' value='restore'>";
    echo "</form></fieldset>";
    
     $sql = "SELECT * FROM ADDRESSES WHERE ADDRESS_ID = $_POST[ADDRESS_ID]";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><td>Street Name</td><td>House Number</td><td>Zip Code</td><td>State</td><td>Update</td></tr></thead>";
            while($row = $result->fetch_assoc()) {
                echo "<tbody>";
                echo "<tr><td>" . $row["STREET_NAME"] . "</td> <td>" . $row["HOUSE_NUM"] . "</td><td>" . $row["ZIP_CODE"] . "</td><td>" . $row["STATE"] . "</td><td>";
                
                echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
                echo "<input type='hidden' name='ADDRESS_ID' value='{$_POST[ADDRESS_ID]}'>";
                echo "<input type='submit' name='showAddrUpdateForm' value='update'></form>";
                echo "</td></tr></tbody>";
            }
            echo "</table>";
            
        } else {
            echo "No Journal Records Found <br>";
        }
    echo "<input type='hidden' name='ADDRESS_ID' value='{$MEMBER_ID}'>";
}


//function shows and adds transactions to an account
function showTransForm()
{
    
    global $conn;
    global $thisPHP;
    $MEMBER_ID = $_POST['MEMBER_ID'];
    $ACCOUNT_NUMBER = $_POST['ACCOUNT_NUMBER'];
    
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<fieldset><legend>Click to go to member Database</legend>";
    echo "<form id='insertForm' action='{$thisPHP}' method='post'>";
    echo "<input type='submit' name='btnRestore' value='restore'>";
    echo "</form></fieldset>";
    
     $sql = "SELECT * FROM TRANSACTIONS WHERE ACCOUNTS_ACCOUNT_NUMBER = $ACCOUNT_NUMBER ORDER BY TRANSACTION_ID DESC";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<thead><tr><td>Transaction #</td><td>Amount</td><td>Transaction Time</td>";
            while($row = $result->fetch_assoc()) {
                echo "<tbody>";
                $ACCOUNT_NUMBER = $row[TRANSACTION_ID];
                echo "<tr><td>" . $row["TRANSACTION_ID"] . "</td> <td>$" . $row["TRANSACTION_AMOUNT"] . "</td><td>" . $row["TRANSACTION_TIME"];
                
                echo "<form action='{$thisPHP}' method='post' style='display:inline' >";
                echo "<input type='hidden' name='ACCOUNT_NUMBER' value='{$ACCOUNT_NUMBER}'>";
                echo "<input type='hidden' name='CURRENT_BALANCE' value='{$CURRENT_BALANCE}'>";
                echo "<input type='hidden' name='MEMBER_ID' value='{$MEMBER_ID}'>";
                echo "</td></tr></tbody>";
            }
            echo "</table>";
            
        } else {
            echo "No Journal Records Found <br>";
        }
    
}


//function adds member to bank
function insertMember()
{
    global $conn;
     
        $sql0 = "insert into ADDRESSES (STREET_NAME, HOUSE_NUM, ZIP_CODE, STATE)" . "values ('$_POST[STREET_NAME]', '$_POST[HOUSE_NUM]', '$_POST[ZIP_CODE]', '$_POST[STATE]')";
        $conn->query ($sql0);
         
        $adr = "select ADDRESS_ID from ADDRESSES where STREET_NAME = '$_POST[STREET_NAME]'";
        $res = $conn->query($adr);
    
        if ($res ->num_rows > 0) {
            $row = $res->fetch_assoc();
            $ADDRESS_ID = $row[ADDRESS_ID];
        }
        $sql = "insert into MEMBERS (MEMBER_FNAME, MEMBER_LNAME, MEMBER_PHONE, MEMBER_DOB, ADDRESSES_ADDRESS_ID, BANKS_BANK_ID)" .
                    " values ('$_POST[MEMBER_FNAME]', '$_POST[MEMBER_LNAME]', '$_POST[MEMBER_PHONE]', '$_POST[MEMBER_DOB]', $ADDRESS_ID, '1')";
        if ($conn->query ($sql) == TRUE) {
            echo "<script> window.alert('Record added successfully'); </script>;";
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        } 

}


//function removes member from bank
function deleteMember() 
{
    global $conn;
        $sql = "delete from MEMBERS where MEMBER_ID = '$_POST[MEMBER_ID]';";
        if ($conn->query ($sql) == TRUE) {
            echo "<script> window.alert('Member deleted successfully'); </script>;";
        }
        else
        {
             echo "<script> window.alert('Cannot delete member, accounts are still linked to them'); </script>;";
        } 
}


//function deletes account specific to member
function deleteAccount() 
{
    global $conn;
            
        $sql = "delete from TRANSACTIONS where ACCOUNTS_ACCOUNT_NUMBER = '$_POST[ACCOUNT_NUMBER]';";
        $conn->query ($sql);
        $sql1 = "delete from ACCOUNTS where ACCOUNT_NUMBER = '$_POST[ACCOUNT_NUMBER]';";
        $conn->query ($sql1);
}


//function updates specific member information
function updateMember() 
{
    global $conn;
    if (!empty($_POST[MEMBER_PHONE])) {
        $sql = "UPDATE MEMBERS SET MEMBER_PHONE = '$_POST[MEMBER_PHONE]' WHERE MEMBER_ID = '$_POST[MEMBER_ID]'";
        $conn->query ($sql);
    }

        
    if (!empty($_POST[MEMBER_FNAME])) {
        $sql = "UPDATE MEMBERS SET MEMBER_FNAME = '$_POST[MEMBER_FNAME]' WHERE MEMBER_ID = '$_POST[MEMBER_ID]'";
        $conn->query ($sql);
    }
  
    if (!empty($_POST['MEMBER_LNAME'])) {
        $sql = "UPDATE MEMBERS SET MEMBER_LNAME = '$_POST[MEMBER_LNAME]' WHERE MEMBER_ID = '$_POST[MEMBER_ID]'";
        $conn->query ($sql);
    }  
    
    if (!empty($_POST['MEMBER_LNAME'])) {
        $sql = "UPDATE MEMBERS SET MEMBER_LNAME = '$_POST[MEMBER_LNAME]' WHERE MEMBER_ID = '$_POST[MEMBER_ID]'";
        $conn->query ($sql);
    }   
    
    if (!empty($_POST['STREET_NAME'])) {
        $sql = "UPDATE ADDRESSES SET STREET_NAME = '$_POST[STREET_NAME]' WHERE ADDRESS_ID = '$_POST[ADDRESS_ID]'";
        $conn->query ($sql);
    }   
    
    if (!empty($_POST['HOUSE_NUM'])) {
        $sql = "UPDATE ADDRESSES SET HOUSE_NUM = '$_POST[HOUSE_NUM]' WHERE ADDRESS_ID = '$_POST[ADDRESS_ID]'";
        $conn->query ($sql);
    }
    
    if (!empty($_POST['ZIP_CODE'])) {
        $sql = "UPDATE ADDRESSES SET ZIP_CODE = '$_POST[ZIP_CODE]' WHERE ADDRESS_ID = '$_POST[ADDRESS_ID]'";
        $conn->query ($sql);
    } 
    
    if (!empty($_POST['STATE'])) {
        $sql = "UPDATE ADDRESSES SET STATE = '$_POST[STATE]' WHERE ADDRESS_ID = '$_POST[ADDRESS_ID]'";
        $conn->query ($sql);
    } 
}


//function updates an account balance
function updateAccount() 
{
    global $conn;
    $ACCOUNT_NUMBER = $_POST['ACCOUNT_NUMBER'];
    $CURRENT_BALANCE = $_POST['CURRENT_BALANCE'];
    $AMNT = $_POST['TRANSACTION'];
    $TRANSACTION = $CURRENT_BALANCE + $AMNT;
    
        if (!empty($TRANSACTION)) {
        $sql = "UPDATE ACCOUNTS SET CURRENT_BALANCE = '$TRANSACTION' WHERE ACCOUNT_NUMBER = '$_POST[ACCOUNT_NUMBER]'";
        if ($conn->query ($sql) == TRUE) {
            echo "<script> window.alert('Record updated successfully') </script>";
        }
            
            $sql2 = "insert into TRANSACTIONS (TRANSACTION_AMOUNT, TRANSACTION_TIME, ACCOUNTS_ACCOUNT_NUMBER)" .
                    " values ('$_POST[TRANSACTION]', NOW(), '$_POST[ACCOUNT_NUMBER]')";
        $conn->query($sql2);
            

        }
}


//function processes a loan
function loan() 
{
    global $conn;
    $ACCOUNT_NUMBER = $_POST['ACCOUNT_NUMBER'];
    $CURRENT_BALANCE = $_POST['CURRENT_BALANCE'];
    $LOAN_TYPE = $_POST['LOAN_TYPE'];
    $AMNT = $_POST['TRANSACTION'];
    $TRANSACTION = $CURRENT_BALANCE + $AMNT;
    
        if (!empty($TRANSACTION)) {
        $sql = "UPDATE ACCOUNTS SET CURRENT_BALANCE = '$TRANSACTION' WHERE ACCOUNT_NUMBER = '$_POST[ACCOUNT_NUMBER]'";
        $conn->query ($sql);
        
            
            $sql2 = "insert into TRANSACTIONS (TRANSACTION_AMOUNT, TRANSACTION_TIME, ACCOUNTS_ACCOUNT_NUMBER)" .
                    " values ('$_POST[TRANSACTION]', NOW(), '$_POST[ACCOUNT_NUMBER]')";
        $conn->query($sql2);
            
        $L = "select TRANSACTION_ID from TRANSACTIONS where TRANSACTION_AMOUNT = '$AMNT'";
            
        $res = $conn->query($L);
    
        if ($res ->num_rows > 0) {
            $row = $res->fetch_assoc();
            $TRANSACTION_ID = $row[TRANSACTION_ID];
        }
        echo "<script> window.alert('Are you sure you want this loan?'); </script>;";   
            
        echo "<script> window.alert('Like REALLY want it?'); </script>;";
            
        echo "<script> window.alert('Is this to pay for retaking Databases...?'); </script>;";
            
        $sql4 = "insert into LOANS (TRANSACTIONS_TRANSACTION_ID, INTEREST_RATE, START_DATE, TERM, LOAN_TYPE_LOAN_TYPE_ID)" .
                    " values ('$TRANSACTION_ID', '$_POST[INTEREST_RATE]', '$_POST[DATE]', '12' , '$LOAN_TYPE')";
        if ($conn->query ($sql4) == TRUE) {
            echo "<script> window.alert('loan added successfully'); </script>;";
        }
        else
        {
           echo "<script> window.alert('Failed'); </script>;";
        } 
        }
}


//function creates a new account
function createAccount()
{
      global $conn;
    if (!empty($_POST[MEMBER_ID]) && !empty($_POST[ACCOUNT_START_DATE]) && !empty($_POST[CURRENT_BALANCE])){
        $sql = "insert into ACCOUNTS (ACCOUNT_START_DATE, CURRENT_BALANCE, MEMBERS_MEMBER_ID)" .
                    " values ('$_POST[ACCOUNT_START_DATE]', '$_POST[CURRENT_BALANCE]', '$_POST[MEMBER_ID]')";
        if ($conn->query ($sql) == TRUE) {
            echo "<script> window.alert('Record added successfully'); </script>;";
        }
        else
        {
            echo "Could not add record: " . $conn->connect_error . "<br>";
        }
    } 
    else
    {
        echo "<script> window.alert('You failed to fill out both fields, both are required to create an entry'); </script>;";
        echo "Must provide a title and entry to enter a record <br>";
        $action = 'showInsertForm';
    }
}


//function displays the update form for a member's information
function displayUpdateForm()
{
     global $thisPHP;
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Member Data Entry</legend>
        <br><br> New First Name:
        <input type="text" name="MEMBER_FNAME" size="40">
        <br><br> New Last Name:
        <input type="text" name="MEMBER_LNAME" size="40">
        <br><br> New Phone Number:
        <input type="text" name="MEMBER_PHONE" size="20">
        
        <br><br>
        
        <input type='hidden' name='CURRENT_BALANCE' value='{$_POST[CURRENT_BALANCE]}'>
        <input type='hidden' name='MEMBER_ID' value='{$_POST[MEMBER_ID]}'>
        <input type='hidden' name='ADDRESS_ID' value='{$_POST[ADDRESS_ID]}'>
        <input type="submit" name="btnUpdate" value="Update"><br><br>
    </fieldset>
    </form>
EOD;
    
    echo $str;
}


//function displays the update form for a member's address
function displayAddrUpdateForm()
{
     global $thisPHP;
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Member Data Entry</legend>
        <br> New Street Name:
        <input type="text" name="STREET_NAME" size="60">
         <br><br> New House Number:
        <input type="number" name="HOUSE_NUM" size="20">
         <br><br> New Zip Code:
        <input type="number" name="ZIP_CODE" size="20">
         <br><br> New State (abbreviation only):
        <input type="text" name="STATE" size="20">
        
        <br><br>
        
        <input type='hidden' name='CURRENT_BALANCE' value='{$_POST[CURRENT_BALANCE]}'>
        <input type='hidden' name='MEMBER_ID' value='{$_POST[MEMBER_ID]}'>
        <input type='hidden' name='ADDRESS_ID' value='{$_POST[ADDRESS_ID]}'>
        <input type="submit" name="btnUpdate" value="Update"><br><br>
    </fieldset>
    </form>
EOD;
    
    echo $str;
}


//function displays the form to process a loan
function displaLoanForm()
{
     global $thisPHP;
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Account Data Entry</legend>
        <br>Loan Type:
        <input type="number" name='LOAN_TYPE' size="20">
        <br><br>Loan interest rate:
        <input type="number" name='INTEREST_RATE' size="20">
        <br><br>Loan Amount:
        <input type="number" name='TRANSACTION' size="20">
        <br><br>Date sent:
         <input type="text" name='DATE' size="20">
        <input type='hidden' name='CURRENT_BALANCE' value='{$_POST[CURRENT_BALANCE]}'>
        <input type='hidden' name='ACCOUNT_NUMBER' value='{$_POST[ACCOUNT_NUMBER]}'>
        <input type="submit" name="btnLoan" value="Update"><br><br>
    </fieldset>
    </form>
EOD;
    
    echo $str;
}


//function displays the form to add a transaction to an account
function displayAcctUpdateForm()
{
     global $thisPHP;
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Account Data Entry</legend>
        Transaction Amount:
        <input type="number" name='TRANSACTION' size="20">
        <input type='hidden' name='CURRENT_BALANCE' value='{$_POST[CURRENT_BALANCE]}'>
        <input type='hidden' name='ACCOUNT_NUMBER' value='{$_POST[ACCOUNT_NUMBER]}'>
        <input type="submit" name="btnAcctUpdate" value="Update"><br><br>
    </fieldset>
    </form>
EOD;
    
    echo $str;
}


//fucntion displays a form to create a new account
function displayAccountForm()
{
    global $thisPHP;
    
    // A heredoc for specifying really long strings
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Account Data Entry</legend>
        <br> Date of Creation:
        <input type="date" name="ACCOUNT_START_DATE">
        <br><br> Starting Balance:
        <input type="text" name="CURRENT_BALANCE" size="30"><br><br>
        <input type='hidden' name='MEMBER_ID' value='{$_POST[MEMBER_ID]}'>
        <input type="submit" name="btnAccount" value="Create Account"><br><br>
    </fieldset>
    </form>
EOD;

    echo $str;
}


//function displays a form for inserting a new member into the bank
function displayInsertForm() 
{
    global $thisPHP;
    
    // A heredoc for specifying really long strings
    $str = <<<EOD
    <form action='{$thisPHP}' method='post'>
    <fieldset>
        <legend>Member Data Entry</legend>
        <br> First Name:
        <input type="text" name="MEMBER_FNAME" size="60">
        <br><br> Last Name:
        <input type="text" name="MEMBER_LNAME" size="30">
        <br><br> Phone Number:
        <input type="text" name="MEMBER_PHONE" size="20"><br>
        <br> Date of Birth:
        <input type="date" name="MEMBER_DOB"> <br><br>
        <br><br> ADDRESS INFO 
        <br>Street Name: 
        <input type="text" name="STREET_NAME" size="45"><br>
        <br> House Number:
        <input type="number" name="HOUSE_NUM" size="11"><br>
        <br> Zip code:
        <input type="number" name="ZIP_CODE" size="11"><br>
        <br> State (2 letter abbreviation):
        <input type="text" name="STATE" size="10"><br><br>
        <input type="submit" name="btnInsert" value="Insert"><br><br>
    </fieldset>
    </form>
EOD;

    echo $str;
}


?>
