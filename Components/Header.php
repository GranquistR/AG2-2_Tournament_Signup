<?php function GetCurrentUser()
{
  //read enteredUsername from localStorage
  $storedUsername = "<script>document.write(localStorage.getItem('enteredUsername'));</script>";
  return $storedUsername;
}
?>


<script>
  //Runs on page load
  $(window).on('pageshow', function() {

    //handles setting the username in the header or redirects to the login page
    if (localStorage.getItem('enteredUsername') == null) {
      window.location.href = "/";
    } else {
      $(".username").append(localStorage.getItem('enteredUsername'));
    }

    //Handles swapping between the user icon and the logout icon
    $(".header .logout").hide();
    $(".userinfo").hover(function() {
      $(".header .user").hide();
      $(".header .logout").show();
    }, function() {
      $(".header .user").show();
      $(".header .logout").hide();
    });

    //Handles logging out
    $(".header .userinfo").click(function() {
      localStorage.removeItem("enteredUsername");
      window.location.href = "/";
    });
  });
</script>
<div class="header">
  <div class="logo">AG2-2 Tournament Signup</div>
  <div class="userinfo">
    <div class="username"></div>
    <div class="icon user">
      <img src="Images\UserIcon.png" alt="User Icon" height="30px" />
    </div>
    <div class="icon logout">
      <img src="Images\LogoutIcon.png" alt="logout Icon" height="30px" />
    </div>
  </div>

</div>

<style>
  /* All style must start with .header to be scoped to the header only */

  .header .icon {
    margin-left: 10px;
    margin-right: 10px;
  }

  .header .username {
    margin-left: 10px;
    margin-right: 10px;
    font-size: 1.5em;
  }

  .header .userinfo {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    margin-right: 10px;
    border-radius: 30px;
    margin-top: 10px;
    margin-bottom: 10px;
    padding-left: 10px;
    padding-right: 10px;
  }

  .header .userinfo:hover {
    background-color: #222931;
    cursor: pointer;
  }

  .header .logo {
    font-size: 2.5em;
    font-weight: bold;
    padding: 10px;
    margin-left: 10px;
    margin-right: 10px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
  }

  .header {
    width: 100vw;
    height: 70px;
    background-color: #161b22;
    margin: 0;
    color: white;
    display: flex;
    flex-direction: row;
  }
</style>