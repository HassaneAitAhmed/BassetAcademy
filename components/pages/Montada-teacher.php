<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/Montada.css">
    <script defer src="../../js/components/Montada-temp.js"></script>
    <link rel="stylesheet" href="../../css/nav-teacher.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="../../js/components/nav.js"></script>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <title>Document</title>
    <script>

        function redirectToHome() {
            window.location.href = "../../admin.php";
        }
    </script>
    
</head>

<body>
    
<nav>
        <div class="container">
            <!--Navigation Bar left side-->
            <div class="left-side">
                <div class="NavLogo"><img src="../../assets/images/Academy.png" alt="Logo" height="150px" width="150px"
                        onclick="redirectToHome()" style="cursor: pointer;"></div>

            </div>
            <!--Navigation Bar middle part-->
            <div class="middle-part">
                <a href="about-us-teacher.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="Montada-teacher.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="../Admin-Dashboard.php" class="Navbtn" id="Acc"></i>ادارة الموقع </a>
                </div>
                <!-- On media right side-->
                <div class="drop-down">
                    <input type="checkbox" id="drop-down-menu">
                    <label for="drop-down-menu" id="DDM-label"><img src="../../assets/images/DDM.png" alt=""></label>
                    </div>
            </div>


        </div>
        <br>
        <!--On media drop-menu-->
        <div class="media-drop-down-btns">
            <a href="../Teacher-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;ادارة الموقع
                <i class="fas fa-sign-in-alt"></i></a>
            <a href="about-us-teacher.php" class="on-media-btns">من نحن ؟</a>
            <a href="Montada-teacher.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="ss">

        <!--Post Creation Form-->
        <div class="popUpPostForm">
            <div class="post-Form" dir="rtl">
                <div class="Post-form-cancel">
                    <p id="cancel-post">X</p>
                </div>
                <form action="../actionMontadaAdmin.php"  method="POST" enctype="multipart/form-data">
                    <label for="post-form-text" dir="rtl" id="post-form-text-label"> نص الاعلان :</label>
                    <br>
                    <textarea id="post-form-text" dir="rtl" name="postText"></textarea>
                    <br>
                    <p class="error text-error"></p>

                    <div class="post-img-bg">
                        <label for="post-img">حمل صورة الإعلان</label>
                        <input type="file" id="post-img" name="postImage">
                    </div>
                    <div class="image-added"></div>
                    <p class="error image-error"></p>

                    <input type="submit" id="post-submit">
                </form>
            </div>
        </div>

        <!--Post deletion prompt-->
        <form class="popUpDeleteForm" method="POST" action="../actionMontadaAdmin.php">
            <div class="delete-confirmation">
                <h4>هل أنت متأكد من حذفك للإعلان ؟</h4>
                <div class="delete-yes-no">
                    <button type="submit" name="confirm" value="yes" class="confirm-delete">نعم</button>
                    <button type="button" class="cancel-delete" onclick="cancelDelete()">لا</button>
                </div>
            </div>
        </form>



        <div class="hub-header">
            <h2>مرحبا بك في منتدى الطلبة</h2>
        </div>

        <!--Main frame-->
        <div class="post-frame">
            <!--Hub-page left side-->
            <div class="hub-left-side">
                <div class="ul-hub-container">
                    <ul class="hub-student-left-side">
                    <li id="arrange-most-recent-btn">المنشورات الجديدة</li>
                    <li id="arrange-most-liked-btn">أكثر المنشورات إعجاباً</li>
                    <li id="create-post-btn">إنشاء منشور</li>
                    </ul>
                </div>
            </div>
            <!-- Hub-PAGE right side (posts) -->
            <div class="hub-right-side">
                <div class="posts">

                </div>
            </div>

        </div>

    </div>


    <div class="post postClone" style="display:none;">
        <div class="post-left-side">
            <div class="post-image">
                <img src="" alt="">
            </div>
        </div>
        <div class="post-right-side">
            <div class="post-text" dir="rtl">
                <p></p>
            </div>
        </div>
        <div class="post-footer">
            <div class="likes">
                <input type="checkbox" id="post-likes1">
                <label for="post-likes1">
                    <i class="fa-solid fa-heart" id="post-likes-label"><span style="margin-left: 20px;"></span></i>
                </label>
            </div>

            <div class="post-buttons">
                <button class="post-delete">Delete</button>
            </div>

        </div>
    </div>

    <div>
    <div class="footer">
        <div class="footer-left-side">
            <div class="motivation-text">
                <h3> ! مفتاح المستقبل &lrm;</h3>
                <p>  العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك بالمعرفة دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك        &lrm;</p>
            </div>
            <br>
            <div class="footer-contacts">
                <div class="phone"><i class="fa-brands fa-whatsapp"></i><p>Phone Number : 0712345678</p></div>
                <div class="mail" ><i class="fa-regular fa-envelope"></i><p>Gmail : adeladel@gmail.com</p></div>
            </div>
        </div>

        <div class="footer-right-side">
            <div class="footer-logo"><img src="assets/images/Math.png" alt=""></div>
            <p id=""> ★ منصة الاستاذ عبد الباسط للرياضيات </p>
            <div class="footer-socials">
                <a href="https://web.facebook.com/"><i class="fa-brands fa-facebook"></i></a>
                <a href="https://www.instagram.com/abdelbassetprof/"><i class="fa-brands fa-instagram"></i></a>
                <a href="https://www.youtube.com/@%D8%A7%D9%84%D8%A3%D8%B3%D8%AA%D8%A7%D8%B0%D8%B9%D8%A8%D8%AF%D8%A7%D9%84%D8%A8%D8%A7%D8%B3%D8%B7-%D8%B31%D9%88"><i class="fa-brands fa-youtube"></i></a>
            </div>
        </div>

        <div class="footer-lower-part">
            <p>
                © 2024 جميع الحقوق محفوظة. Developed by - Adel Hassen Mahdi -
            </p>
        </div>

    </div>
    </div>


</body>


</html>