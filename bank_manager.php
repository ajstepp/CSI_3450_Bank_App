<!DOCTYPE html>
<html>
<head>
    <title> Bank DB </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>    
    <?php
    session_start(); // start session
    include "utils.php"; //include utils files
        
    if (!isset($_SESSION['login']) || $_SESSION['login'] == '') //confirm login
        {
        header("Location: index.html"); //redirect if session not active
        }
    
        
    connectToDB();
    $thisPHP = $_SERVER['PHP_SELF'];
    $databaseAction = '';            
    $displayAction = 'showMembers';      // Default display 
    
    if (isset($_POST['btnInsert']))
        $databaseAction = 'doInsert';
    
    if (isset($_POST["btnDelete"]))
        $databaseAction = 'doDelete';
    
    if (isset($_POST["btnUpdate"]))
        $databaseAction = 'doUpdate';
    
    if (isset($_POST["btnLoan"]))
        $databaseAction= 'doLoan';
    
    if (isset($_POST['btnAccount']))
        $databaseAction = 'doAccount';
    
     if (isset($_POST["btnAcctUpdate"]))
        $databaseAction = 'doAcctUpdate';
    
     if (isset($_POST["btnDeleteAcct"]))
        $databaseAction = 'doDeleteAcct';
    
    if (isset($_POST['showInsertForm']))
        $displayAction = 'showInsertForm';
    
    else if (isset($_POST['btnAcct']))
        $displayAction = 'showAccts';
    
    else if (isset($_POST['showAccountForm']))
        $displayAction = 'showAccountForm';
    
    else if (isset($_POST['showUpdateForm']))
        $displayAction = 'showUpdateForm';
    
    else if (isset($_POST['showAccts']))
        $displayAction = 'showAccts';
    
    else if (isset($_POST['showLoanForm']))
        $displayAction = 'showLoanForm';
    
    
    else if (isset($_POST['showMemAccounts']))
        $displayAction = 'showMemAccounts';
    
    else if (isset($_POST['showMemAddress']))
        $displayAction = 'showMemAddress';
    
    else if (isset($_POST['showAddrUpdateForm']))
        $displayAction = 'showAddrUpdateForm';
    
    else if (isset($_POST['showTransForm']))
        $displayAction = 'showTransForm';
    
    else if (isset($_POST['showAcctUpdateForm']))
    {
        $displayAction = 'showAcctUpdateForm';    
    }
    else
        $displayAction ='showMembers';
    
    if($databaseAction == 'doDelete') 
    {
        deleteMember();
    }
    
    if ($databaseAction == 'doInsert')
    {
        insertMember();
    }
    
    if ($databaseAction == 'doLoan')
    {
        loan();
    }
    
    if ($databaseAction == 'doUpdate')
    {
        updateMember();
    }
    
    if ($databaseAction == 'doAccount')
    {
        createAccount();
    }
    
    if ($databaseAction == 'doAcctUpdate')
    {
        updateAccount();
    }
    
    if ($databaseAction == 'doDeleteAcct')
    {
        deleteAccount();
    }
        
        
    if ($displayAction == 'showInsertForm')
    {
        //include "frmInsStudent.php";
        displayInsertForm();
    }
    
    else if ($displayAction == 'showUpdateForm')
    {
        displayUpdateForm();
    }

    else if ($displayAction == 'showAccts')
    {
        showAccts();
    }
    
    else if ($displayAction == 'showAccountForm')
    {
        displayAccountForm();
    }
    
    else if ($displayAction == "showMemAccounts")
    {
        showMemAccts();
    }
    
    else if ($displayAction == 'showMemAddress')
    {
        showMemAddress();
    }
    
    else if ($displayAction == 'showAddrUpdateForm')
    {
        displayAddrUpdateForm();
    }

    else if ($displayAction == "showTransForm")
    {
        showTransForm();
    }
    
    else if ($displayAction == "showLoanForm")
    {
        displaLoanForm();
    }
    
    else if ($displayAction == "showAcctUpdateForm")
    {
        displayAcctUpdateForm();
    }
   
    //default display
    else if ($displayAction == 'showMembers')
    {
        showMembers();
    }
        
    $conn->close();
    ?>
</body>
</html>
