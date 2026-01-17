<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/nav1.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../js/components/nav.js"></script>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <!--Navigation Bar left side-->
        <div class="left-side">
            <div class="NavLogo"><img src="../assets/images/Academy.png" alt="Logo" height="150px" width="150px" onclick="redirectToHome()" style="cursor: pointer;"></div>
            
        </div>
        <!--Navigation Bar middle part-->
        <div class="middle-part">
            <a href="../components/about-us.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
            <a href="../index.php " class="Navbtn" id="courses-btn">دوراتنا</a>
            <a href="../components/Montada.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
        </div>
        <!--Navigation Bar right side-->
        <div class="right-side">
            <div class="LOG">
                <a href="../components/SignIn.php" class="Navbtn" id="LogInNavbtn"> <i class="fa-solid fa-arrow-right-to-bracket"></i>تسجيل الدخول</a>
                <a href="../components/SignUP.php"  class="Navbtn" id="SignInNavbtn"><i class="fa-solid fa-user-plus"></i> انشئ حسابك الآن </a>
            </div>
        <!-- On media right side-->
            <div class="drop-down">
                <input type="checkbox" id="drop-down-menu">
                <label for="drop-down-menu" id="DDM-label"></label>
            </div>
        </div>

        
    </div>
    <br>
    <!--On media drop-menu-->
    <div class="media-drop-down-btns">
        <a href="../components/SignIn.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;تسجيل الدخول<i class="fas fa-sign-in-alt"></i></a>
        <a href="../components/SignUP.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp; انشئ حسابك الآن <i class="fa-solid fa-user"></i></a>
        <a href="../index.php" class="on-media-btns">دوراتنا</a>
        <a href="../components/about-us.php" class="on-media-btns">من نحن ؟</a>
        <a href="../components/Montada.php" class="on-media-btns">المنتدى</a>
    </div>
    </div>
    
    
</body>

<script>
function redirectToHome() {
    window.location.href = "../index.php";
}
</script>
</html>