<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/SignUP.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../js/components/SignUP.js"></script>
    <link rel="stylesheet" href="../css/nav1.css">
    <script defer src="../js/components/nav.js"></script>
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script>
        function redirectToHome() {
            window.location.href = "../guest.php";
        }
    </script>
    <script defer src="../js/components/nav.js"></script>

</head>

<body>
    <nav>
        <div class="container">
            <!--Navigation Bar left side-->
            <div class="left-side">
                <div class="NavLogo"><img src="../assets/images/Academy.png" alt="Logo" height="150px" width="150px"
                        onclick="redirectToHome()" style="cursor: pointer;"></div>

            </div>
            <!--Navigation Bar middle part-->
            <div class="middle-part">
                <a href="../components/about-us.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="../guest.php #courses " class="Navbtn" id="courses-btn">دوراتنا</a>
                <a href="../components/Montada.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="../components/SignIn.php" class="Navbtn" id="LogInNavbtn"> <i
                            class="fa-solid fa-arrow-right-to-bracket"></i>تسجيل الدخول</a>
                    <a href="../components/SignUP.php" class="Navbtn" id="SignInNavbtn"><i
                            class="fa-solid fa-user-plus"></i> انشئ حسابك الآن </a>
                </div>
                <!-- On media right side-->
                <div class="drop-down">
                    <input type="checkbox" id="drop-down-menu">
                    <label for="drop-down-menu" id="DDM-label"><img src="../assets/images/DDM.png" alt=""></label>
                </div>
            </div>


        </div>
        <br>
        <!--On media drop-menu-->
        <div class="media-drop-down-btns">
            <a href="../components/SignIn.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;تسجيل الدخول<i
                    class="fas fa-sign-in-alt"></i></a>
            <a href="../components/SignUP.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp; انشئ حسابك الآن <i
                    class="fa-solid fa-user"></i></a>
            <a href="../guest.php" class="on-media-btns">دوراتنا</a>
            <a href="../components/about-us.php" class="on-media-btns">من نحن ؟</a>
            <a href="../components/Montada.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="SU-container">
        <!--Sign Up Form-->
        <div class="SU-left-side">
            <?php session_start(); ?>
            <form action="actionSignUp.php" method="post" id="SU-form">
                <div class="SU-FormText">
                    <span id="SU-HeaderFormText">! أنشئ <span style="color: orange;">حسابك</span> الأَن</span>
                </div>
                <div class="SU-Inputs">

                    <!-- Last Name -->
                    <div class="lastname-input">
                        <input class="SU-input-field" type="text" id="SU-LastName" placeholder="اسم العائلة"
                            name="lastName"
                            value="<?= isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
                        <p class="Su-error SU-LastName-error">
                            <?= $_SESSION["signup_errors"]['lastName'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- First Name -->
                    <div class="firstname-input">
                        <input class="SU-input-field" type="text" id="SU-FirstName" placeholder="الاسم الأول"
                            name="firstName"
                            value="<?= isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>">
                        <p class="Su-error SU-Firstname-error">
                            <?= $_SESSION["signup_errors"]['firstName'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="email-input">
                        <input class="SU-input-field" type="text" id="SU-Email" placeholder="البريد الإلكتروني"
                            name="email"
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <p class="Su-error SU-email-error">
                            <?= $_SESSION["signup_errors"]['email'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Phone Number -->
                    <div class="phone-input">
                        <input class="SU-input-field" type="text" id="SU-PhoneNumber" placeholder="رقم الهاتف"
                            name="phoneNum"
                            value="<?= isset($_POST['phoneNum']) ? htmlspecialchars($_POST['phoneNum']) : ''; ?>">
                        <p class="Su-error SU-phone-error">
                            <?= $_SESSION["signup_errors"]['phoneNum'] ?? ''; ?>
                        </p>
                    </div>


                    <!-- Study Level -->
                    <div class="SU-SL">
                        <label for="StudyLevel" id="SU-SLT">المستوى الدراسي</label>
                        <br>
                        <select id="SU-StudyLevel" name="level">
                            <option value="1AS" <?=(isset($_POST['level']) && $_POST['level']==='1AS' ) ? 'selected'
                                : '' ; ?>>1AS</option>
                            <option value="2AS" <?=(isset($_POST['level']) && $_POST['level']==='2AS' ) ? 'selected'
                                : '' ; ?>>2AS</option>
                            <option value="3AS" <?=(isset($_POST['level']) && $_POST['level']==='3AS' ) ? 'selected'
                                : '' ; ?>>3AS</option>
                        </select>
                    </div>

                    <!-- Branch -->
                    <div class="SU-BR">
                        <label for="Branch" id="SU-BRT">الشعبة</label>
                        <br>
                        <select id="SU-Branch" name="branch">
                            <option value="ST" <?=(isset($_POST['branch']) && $_POST['branch']==='ST' ) ? 'selected'
                                : '' ; ?>>علوم تجريبية</option>
                            <option value="MT" <?=(isset($_POST['branch']) && $_POST['branch']==='MT' ) ? 'selected'
                                : '' ; ?>>رياضيات</option>
                            <option value="ML" <?=(isset($_POST['branch']) && $_POST['branch']==='ML' ) ? 'selected'
                                : '' ; ?>>تقني رياضي</option>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="password-input">
                        <input class="SU-input-field" type="password" id="SU-Password" placeholder="كلمة المرور"
                            name="password">
                        <p class="Su-error SU-pass-error">
                            <?= $_SESSION["signup_errors"]['password'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="confirm-password-input">
                        <input class="SU-input-field" type="password" id="SU-ConfirmPassword"
                            placeholder="تأكيد كلمة المرور" name="confirmPassword">
                        <p class="Su-error SU-confirmPass-error">
                            <?= $_SESSION["signup_errors"]['confirmPassword'] ?? ''; ?>
                        </p>
                    </div>

                    <!-- Submit and Reset -->
                    <div class="submit-reset-input">
                        <input type="reset" id="SU-ResetForm" value="الإعادة من جديد">
                        <input type="submit" id="SU-SubmitForm" value="تسجيل الحساب">
                    </div>
                </div>
            </form>
            <?php unset($_SESSION["signup_errors"]); ?>
        </div>

        <!--Sign Up right side Image-->
        <div class="SU-right-side"></div>
    </div>

    <footer>
        <div>
            <div class="footer">
                <div class="footer-left-side">
                    <div class="motivation-text">
                        <h3> ! مفتاح المستقبل &lrm;</h3>
                        <p> العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة
                            تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك
                            بالمعرفة دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك &lrm;</p>
                    </div>
                    <br>
                    <div class="footer-contacts">
                        <div class="phone"><i class="fa-brands fa-whatsapp"></i>
                            <p>Phone Number : 0712345678</p>
                        </div>
                        <div class="mail"><i class="fa-regular fa-envelope"></i>
                            <p>Gmail : adeladel@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="footer-right-side">
                    <div class="footer-logo"><img src="assets/images/Math.png" alt=""></div>
                    <p id=""> ★ منصة الاستاذ عبد الباسط للرياضيات </p>
                    <div class="footer-socials">
                        <a href="https://web.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://www.instagram.com/abdelbassetprof/"><i class="fa-brands fa-instagram"></i></a>
                        <a
                            href="https://www.youtube.com/@%D8%A7%D9%84%D8%A3%D8%B3%D8%AA%D8%A7%D8%B0%D8%B9%D8%A8%D8%AF%D8%A7%D9%84%D8%A8%D8%A7%D8%B3%D8%B7-%D8%B31%D9%88"><i
                                class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>

                <div class="footer-lower-part">
                    <p>
                        © 2024 جميع الحقوق محفوظة. Developed by - Adel Hassen Mahdi -
                    </p>
                </div>

            </div>
        </div>
    </footer>
</body>

</html>