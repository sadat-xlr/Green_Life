<?php
  require_once '../models/db_config.php';
  $name="";
  $err_name="";
  $email="";
  $err_email="";
  $username="";
  $err_username="";
  $password="";
  $err_password="";
  $phoneno="";
  $err_phoneno="";
  $err_msg="";
  $regmsg="";
  $bday="";
  $bmonth="";
  $byear="";
  $err_dob="";
  
    

  

  //sign up
  if(isset($_POST['sign_up'])){
  	if(empty($_POST['name'])||empty($_POST['username']) ||empty($_POST['email']) ||empty($_POST['password'])||empty($_POST['phoneno'])){
  		
  		$err_name="field can not be empty ";
  		$err_username="field can not be empty";
  		
  		$err_password="field can not be empty";
      $err_phoneno="field can not be empty";
     
     
  	}
    if(is_numeric($_POST['name'])||is_numeric($_POST['username']) ||is_numeric($_POST['email']) ||!is_numeric($_POST['phoneno'])){
   
      $err_name="field can not be number ";
      $err_username="field can not be number ";
      $err_email="field can not be number ";
     
      $err_phoneno="ivalid phone";
     
     
    }
     if(($_POST["day"])=="Day"||($_POST["month"])=="Month"||($_POST["year"])=="Year"){
      
        $err_dob="*Please select date of birth";
      }
     
   
            




    else{
  		
  		$name=htmlspecialchars($_POST['name']) ;
  		$username=htmlspecialchars($_POST['username']) ;
  		
     

      $email=htmlspecialchars($_POST['email']) ;
      $phoneno=htmlspecialchars($_POST['phoneno']);
    
      $password=htmlspecialchars($_POST['password']) ;
      $bday=$_POST["day"];
      $bmonth=$_POST["month"];
       $byear=$_POST["year"];
       insertUser($name,$username,$password,$email,$phoneno);
     
  	}



           

    }
   
  

//sign in
  if(isset($_POST['btn_login'])){
     if(empty($_POST['username'])||empty($_POST['password'])){
        $err_username="please insert username ";
        $err_password="please insert password";
     }
     if (authenticateUser($_POST['username'],$_POST['password'])) {
       header("Location:dashboard.php");
     }else{
      if(!empty($_POST['username'])&&!empty($_POST['password']))
       $err_msg ="ivalid username or password";
     }
     
  }

//update user info
if(isset($_POST['update_user'])){
  
  $name=$_POST['name'];
  $username=$_POST['username'];
  $password=$_POST['password'];
  $email=$_POST['email'];
  $phoneno=$_POST['phoneno'];
  editUser($_POST['id'],$name,$username,$password,$email,$phoneno);
  header("location:allusers.php");
}

if(isset($_POST['btn_deleteCustomer'])){
  deleteCustomer($_POST['id']);
  header("location:allusers.php");
}


//delete user info   
function deleteCustomer($id){
    $query = "DELETE FROM users WHERE id=$id";
    execute($query);
    
  }



   function insertUser($name,$username,$password,$email,$phoneno){
      $query="INSERT INTO users VALUES(NULL,'$name','$username','$password','$email','$phoneno')";
      execute($query);
      return true;
     

    }
     function authenticateUser($username,$password){
      $query="SELECT * FROM users where username='$username' and password='$password'";
      $result=get_data($query);
      if(count($result)>0)
      { 
         /*session_start();
         $_SESSION["success"]*/
         
        return$result[0];;
      }else{
        return false;
      }
     }

     function editUser($id,$name,$username,$password,$email,$phoneno){
    $query = "update users set name='$name',username='$username',password='$password',email='$email',phoneno=$phoneno where id=$id";
    execute($query);
    
  }

    function getAllusers(){
      $query="SELECT * FROM users";
      $result=get_data($query);
      return $result;
    }
    function getCustomer($id){
  $query="SELECT * FROM users where id=$id";
  $result=get_data($query);
  if(count($result)>0){
    return $result[0];
  }
  return false;

 }


?>