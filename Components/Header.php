<!-- This is a component that is intended to be insert into the body of a other html or php files -->
<!-- It does not need it's own html,head,body tag as everything is inserted as is -->
<!-- Super easy to insert at the top of your page with php (See tournaments.php for examples) -->
<!-- that way no need to duplicate header code for each page :) -->

<link rel="stylesheet" href="Stylesheet/header.css">
<script>
  //Runs on page load
  $(window).on('pageshow', function() {

    //handles setting the username in the header or redirects to the login page
    if (localStorage.getItem('enteredUsername') == null) {
      alert("You must login to view this page");
      window.location.href = "/";
    } else {
      $(".username").html(localStorage.getItem('enteredUsername'));
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
      localStorage.clear();
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

<div class="rectangle-below"></div>