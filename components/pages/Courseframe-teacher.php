<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course</title>
    <link rel="stylesheet" href="../../css/nav1.css">
    <script defer src="../../js/components/nav.js"></script>
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script>
        function redirectToHome() {
            window.location.href = "../../admin.php";
        }
    </script>
    <link rel="stylesheet" href="../css/course-info.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
    <script defer src="../js/components/course-info.js"></script>
    <link rel="stylesheet" href="../css/detail.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/ContentCourse.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
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
                <a href="../../admin.php #courses " class="Navbtn" id="courses-btn">دوراتنا</a>
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
            <a href="../../admin.php #courses" class="on-media-btns">دوراتنا</a>
            <a href="about-us-teacher.php" class="on-media-btns">من نحن ؟</a>
            <a href="Montada-teacher.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div>
    <div class="course-info-container">
        <div class="stats">
            <div class="number-videos stat-number">
                <div class="stat-left-side"><span>ملفات </span></div>
                <div class="stat-right-side video-num"><span>1</span><i class="fa-solid fa-plus"></i></div>
            </div>
            <div class="number-files stat-number">
                <div class="stat-left-side"><span>واجبات </i></span></div>
                <div class="stat-right-side files-num"><span>1</span><i class="fa-solid fa-plus"></i></div>
            </div>
            <div class="number-exams stat-number">
                <div class="stat-left-side"><span>امتحانات </span></div>
                <div class="stat-right-side exams-num"><span>1</span><i class="fa-solid fa-plus"></i></div>
            </div>
            <div class="number-homeworks stat-number">
                <div class="stat-left-side"><span>فيديوهات</span></div>
                <div class="stat-right-side homeworks-num"><span>1</span><i class="fa-solid fa-plus"></i></div>
            </div>
            
        </div>

        <div class="course-name"> <h4>الوحدة01: المتتاليات</h4></div>
        <div class="course-info">
            في هذه الوحدة سنتطرق إلى: <br>
            - المفاهيم الأساسية والمتقدمة حول المتتاليات العددية. <br>
            - سنحتاج لمكتسبات السنة الأولى والثانية، وستجدها في الدورة التأسيسية الخاصة بالرياضيات. <br>
            - سنقوم بدراسة جميع أنواع المتتاليات مثل المتتاليات الحسابية والهندسية بالتفصيل، في حصص مباشرة ومسجلة. <br>
            - سنحل معًا أكثر من 20 تمريناً ونماذج امتحانات بكالوريا متعلقة بالمتتاليات. <br>
            - سأقوم بتقييم مستواك من خلال اختبارات شبه أسبوعية لقياس مدى تقدمك في فهم المتتاليات. <br>
            - هدفنا هو أن نصلك لمستوى يمكّنك من حل أي تمرين بكالوريا متعلق بموضوع المتتاليات.
        </div>
        
        <div class="course-creation-date" dir="rtl">
            <div class="creation-date-text">
                <span>  تاريخ انشاء الدورة :</span>
            </div>

            <div class="creation-date"> 2024/5/23</div>
        </div>

    </div>
    </div>


    <div>
    <div class="main-course">
        <div class="course-card-section">
            <div class="course-image">
                <img src="../assets/images/year1-functions.jpg" alt="math Course">
            </div>
            <div class="course-info-section">
                <h1>أولى ثانوي 1AS</h1>
                <p>حصص مباشرة عبر Zoom<br>حصص مسجلة في المنصة<br>تمارين مكثفة واختبارات تقويم</p>
            </div>
            <div class="course-price">
                <div class="price-currency">دينار</div>
                <div class="price-amount">3000.00</div>
            </div>
            <button class="subscribe-btn">
                <span>اشترك الآن !</span>
            </button>
            <div class="course-details">
                <div class="detail">
                    <span>+10 ساعات</span>
                    <small>المحتوى</small>
                </div>
                <div class="detail">
                    <span>+8 أسئلة</span>
                    <small>إجمالي الأسئلة</small>
                </div>
            </div>
        </div>

        <div class="video">
        <iframe src="https://www.youtube.com/embed/8XfF7a5F5Vc?si=olXKS3QRkQV99GMJ" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>        </div>
    </div>
    </div>


    <div>

    <section class="course-content1">
        <h1 class="course-content-title">محتوى
            <span>الدورة</span>
        </h1>


        <div class="accordion ">
            <div class="accordion-header">
                <i class="fas fa-file-alt"></i>
                <span>الدروس المسجلة</span>
                <button class="toggle-btn">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="accordion-content">

                <div class="document">
                    <i class="fas fa-video"></i>
                    <span>01- مقارنة أولية لطاقة جملة و انحفاظها (الدرس)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: في هذا الدرس سنتعرف على مفهوم طاقة الجملة وكيفية انحفاظها عبر
                        الأنظمة المختلفة.</p>
                </div>

                <div class="document">
                    <i class="fas fa-video"></i>
                    <span>02- عمل قوة ثابتة - عمل قوة النقل (التمارين)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: هنا سنتعلم كيفية حساب عمل القوة الثابتة عبر مسافة ثابتة والنقل
                        عبر الزمن.</p>
                </div>
            </div>
        </div>

        <div class="accordion ">
            <div class="accordion-header">
                <i class="fas fa-file-alt"></i>
                <span>الملفات و الوثائق</span>
                <button class="toggle-btn">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="accordion-content">

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>01- مقارنة أولية لطاقة جملة و انحفاظها (الدرس)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: في هذا الدرس سنتعرف على مفهوم طاقة الجملة وكيفية انحفاظها عبر
                        الأنظمة المختلفة.</p>
                </div>

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>02- عمل قوة ثابتة - عمل قوة النقل (التمارين)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: هنا سنتعلم كيفية حساب عمل القوة الثابتة عبر مسافة ثابتة والنقل
                        عبر الزمن.</p>
                </div>
            </div>
        </div>

        <div class="accordion ">
            <div class="accordion-header">
                <i class="fas fa-file-alt"></i>
                <span>الحصص المباشرة عبر Zoom</span>
                <button class="toggle-btn">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="accordion-content">

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>01- مقارنة أولية لطاقة جملة و انحفاظها (الدرس)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: في هذا الدرس سنتعرف على مفهوم طاقة الجملة وكيفية انحفاظها عبر
                        الأنظمة المختلفة.</p>
                </div>

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>02- عمل قوة ثابتة - عمل قوة النقل (التمارين)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: هنا سنتعلم كيفية حساب عمل القوة الثابتة عبر مسافة ثابتة والنقل
                        عبر الزمن.</p>
                </div>
            </div>
        </div>

        <div class="accordion ">
            <div class="accordion-header">
                <i class="fas fa-file-alt"></i>
                <span>التقويمات</span>
                <button class="toggle-btn">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="accordion-content">

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>01- مقارنة أولية لطاقة جملة و انحفاظها (الدرس)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: في هذا الدرس سنتعرف على مفهوم طاقة الجملة وكيفية انحفاظها عبر
                        الأنظمة المختلفة.</p>
                </div>

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>02- عمل قوة ثابتة - عمل قوة النقل (التمارين)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: هنا سنتعلم كيفية حساب عمل القوة الثابتة عبر مسافة ثابتة والنقل
                        عبر الزمن.</p>
                </div>
            </div>
        </div>

        <div class="accordion ">
            <div class="accordion-header">
                <i class="fas fa-file-alt"></i>
                <span>خاص بشعبتي تقني رياضي و رياضيات</span>
                <button class="toggle-btn">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="accordion-content">

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>01- مقارنة أولية لطاقة جملة و انحفاظها (الدرس)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: في هذا الدرس سنتعرف على مفهوم طاقة الجملة وكيفية انحفاظها عبر
                        الأنظمة المختلفة.</p>
                </div>

                <div class="document">
                    <i class="fas fa-file"></i>
                    <span>02- عمل قوة ثابتة - عمل قوة النقل (التمارين)</span>
                </div>
                <div class="document-content">
                    <p class="document-description">وصف: هنا سنتعلم كيفية حساب عمل القوة الثابتة عبر مسافة ثابتة والنقل
                        عبر الزمن.</p>
                </div>
            </div>
        </div>

    </section>
    </div>

    <footer>
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
    </footer>


    <script src="../js/main.js"></script>
    <script>
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', () => {
                const accordion = header.parentElement;
                const content = accordion.querySelector('.accordion-content');
                accordion.classList.toggle('active');
                content.style.maxHeight = accordion.classList.contains('active') ? content.scrollHeight + "px" : null;
            });
        });

        const documentItems = document.querySelectorAll('.document');

        documentItems.forEach(document => {
            document.addEventListener('click', () => {
                const content = document.nextElementSibling;
                document.classList.toggle('active');
                content.style.maxHeight = document.classList.contains('active') ? content.scrollHeight + "px" : null;
            });
        });
    </script>
</body>

</html>