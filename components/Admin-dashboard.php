<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user has the role of Admin
if ($_SESSION['user']['Role'] !== 'Admin') {
    echo "Access denied. You do not have permission to access this page.";
    exit();
}

?>



<?php include 'src/AdminDashboardLogic.php'; ?>



<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="../css/Admin-Dashboard1.css">
    <link rel="stylesheet" href="../css/nav-teacher.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/b88200da0c.js" crossorigin="anonymous"></script>
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
                <a href="pages/about-us-teacher.php" class="Navbtn" id="about-us-btn">من نحن ؟</a>
                <a href="pages/Montada-teacher.php" class="Navbtn" id="contact-us-btn">المنتدى</a>
            </div>
            <!--Navigation Bar right side-->
            <div class="right-side">
                <div class="LOG">
                    <a href="Admin-Dashboard.php" class="Navbtn" id="Acc"></i>ادارة الموقع </a>
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
            <a href="Admin-Dashboard.php" class="on-media-btns" dir="rtl">&nbsp;&nbsp;ادارة الموقع
                <i class="fas fa-sign-in-alt"></i></a>
            <a href="pages/about-us-teacher.php" class="on-media-btns">من نحن ؟</a>
            <a href="pages/Montada-teacher.php" class="on-media-btns">المنتدى</a>
        </div>
        </div>
    </nav>

    <div class="dashboard-container" dir="rtl">

        <nav class="sidebar">
            <h2>🚀 الخيارات</h2>
            <ul>
                <li><a href="../components/Admin-Tutorials.php" id="Tutorials" onclick="showContent('Tutorials')">
                        🎬
                        جميع الدورات 🎬</a></li>
                <li><a href="../components/Admin-courses.php" id="Tutorials" onclick="showContent('Tutorials')">🎞
                        جميع الفيديوهات 🎞</a></li>
                <li><a href="#" id="create-courses" onclick="showContent('course')">🎓 إنشاء دورة</a></li>
                <li><a href="#" id="create-tutorials" onclick="showContent('tutorial')">📚 إنشاء فيديو</a></li>
                <li><a href="#" id="create-assignments" onclick="showContent('assignment')">📝 إنشاء تقويم</a>
                </li>
                <li><a href="#" id="create-exams" onclick="showContent('exam')">📃 إنشاء إمتحان</a></li>
                </li>
                <li><a href="#" id="view-messages" onclick="showContent('messages')">📩 مشاهدة الرسائل</a></li>
                <li><a href="#" id="view-feedback" onclick="showContent('feedback')">💬 مشاهدة أراء الطلاب</a></li>
                <li><a href="../components/studentsList.php" id="view-messages" onclick="showContent('students')">👨‍🎓
                        قائمة الطلاب</a></li>
                <li><a href="#" id="view-messages" onclick="showContent('students-payement')">💰 إدارة طلبات الدفع</a>
                <li><a href="../components/admin_control.php" id="create-admin" onclick="showContent('admin')">🔑 إنشاء
                        مسؤول</a></li>
                <li><a href="../components/studentsTask.php" id="create-admin" onclick="showContent('admin')">
                        📊 تقييم الطلاب
                    </a></li>
                    <li>
    <button id="logoutBtn" class="logout-button">
        تسجيل الخروج
    </button>
</li>



                </li>
            </ul>
        </nav>


        <section class="main-content" style="height: 180vh;">
            <div id="content-display">
                <h3 id="hidden-title">👋 مرحبًا بك استاذ في لوحة التحكم </h3>

                <div class="content-section" id="tutorial">
                    <form id="tutorialForm" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <h2>إنشاء الدورة التعليمية</h2>

                            <label for="title">العنوان:</label>
                            <input type="text" id="title" name="title" placeholder="أدخل العنوان..." dir="rtl">
                            <div class="error-message" id="title-error"></div>

                            <label for="description">الوصف:</label>
                            <textarea id="description" name="description" placeholder="أدخل الوصف..."
                                dir="rtl"></textarea>
                            <div class="error-message" id="description-error"></div>

                            <label for="video">الفيديو:</label>
                            <input type="file" id="video" name="video" accept="video/*">
                            <div class="error-message" id="video-error"></div>

                            <label for="course_id">الدورة:</label>
                            <select id="course_id" name="course_id">
                                <option value="" disabled selected>اختر الدورة</option>
                                <?php echo $courses; ?>
                            </select>
                            <div class="error-message" id="course_id-error"></div>

                            <label for="materials">الموراد التعليمية (اختر عدة ملفات):</label>
                            <input type="file" id="materials" name="materials[]" accept="application/pdf" multiple>
                            <div class="error-message" id="materials-error"></div>

                            <label for="summaries">الملخصات (اختر عدة ملفات):</label>
                            <input type="file" id="summaries" name="summaries[]" accept="application/pdf" multiple>
                            <div class="error-message" id="summaries-error"></div>

                            <button type="submit" class="submit-button">إنشاء الدورة
                                التعليمية</button>
                        </div>
                    </form>
                </div>

                <div class="content-section" id="course">
                    <form id="courseForm" method="POST" enctype="multipart/form-data">
                        <div class="modal-content">
                            <h2>إنشاء الدورة</h2>

                            <label for="course-title">العنوان:</label>
                            <input type="text" id="course-title" name="course-title" placeholder="أدخل العنوان..."
                                dir="rtl">
                            <div class="error-message" id="course-title-error"></div>

                            <label for="course-description">الوصف:</label>
                            <textarea id="course-description" name="course-description" placeholder="أدخل الوصف..."
                                dir="rtl"></textarea>
                            <div class="error-message" id="course-description-error"></div>

                            <label for="course-image">الصورة:</label>
                            <input type="file" id="course-image" name="image" accept="image/*">
                            <div class="error-message" id="course-image-error"></div>

                            <label for="course-semester">السنة الدراسية:</label>
                            <select id="course-semester" name="semester">
                                <option value="" disabled selected>إختر السنة</option>
                                <option value="S1">السنة الأولى</option>
                                <option value="S2">السنة الثانية</option>
                                <option value="S3">السنة الثالثة</option>
                            </select>
                            <div class="error-message" id="course-semester-error"></div>

                            <label for="course-price">السعر:</label>
                            <input type="number" id="course-price" name="price" placeholder="أدخل السعر..." dir="rtl">
                            <div class="error-message" id="course-price-error"></div>

                            <label for="course-summarize">الملخصات (اختر عدة ملفات):</label>
                            <input type="file" id="course-summarize" name="summarize[]" accept="application/pdf"
                                multiple>
                            <div class="error-message" id="course-summarize-error"></div>

                            <button type="submit" class="submit-button">إنشاء الدورة</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="content-section" id="assignment">
                <div class="exam-content">
                    <form id="assignmentForm" method="POST" enctype="multipart/form-data">
                        <div class="Assignment-Quizzes">
                            <div class="AQ-header">
                                <h2 id="AQ-header">(Assignment) إضافة واجب</h2>
                            </div>
                            <p id="general-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="AQ-title">عنوان الواجب:</label>
                            <input type="text" id="AQ-title" name="title" placeholder="أدخل عنوان الواجب" dir="rtl">
                            <p id="AQ-title-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="AQ-description">وصف الواجب:</label>
                            <textarea id="AQ-description" name="description" placeholder="أدخل وصف الواجب" rows="2"
                                dir="rtl"></textarea>
                            <p id="AQ-description-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="course_id">الدورة:</label>
                            <select id="course_id" name="course_id">
                                <option value="" disabled selected>اختر الدورة</option>
                                <!-- Dynamically populated course options -->
                                <?php echo $courses; ?>
                            </select>
                            <p id="course_id-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="AQ-files">تحميل ملف الواجب:</label>
                            <input type="file" id="AQ-files" name="file" accept="application/pdf">
                            <p id="AQ-files-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="AQ-files-solution">تحميل حل الواجب:</label>
                            <input type="file" id="AQ-files-solution" name="Task_solution" accept="application/pdf">
                            <p id="AQ-files-solution-error" class="error-message" style="color:red;"></p>
                        </div>

                        <div class="exam-field">
                            <label for="AQ-deadline">تاريخ التسليم:</label>
                            <input type="date" id="AQ-deadline" name="duedate">
                            <p id="AQ-deadline-error" class="error-message" style="color:red;"></p>
                        </div>

                        <button type="submit" class="submit-btn">إنشاء الواجب</button>
                    </form>
                </div>
            </div>

            <div class="content-section" id="exam">
                <div class="exam-content">
                    <form id="examForm" method="POST" enctype="multipart/form-data">
                        <div class="create-exam">
                            <h2>إنشاء الامتحان</h2>
                            <p id="general-error" class="error-message" style="color:red;"></p>

                            <div class="exam-field">
                                <label for="examTitle">عنوان الامتحان:</label>
                                <input type="text" id="examTitle" name="exam_title" placeholder="أدخل عنوان الامتحان"
                                    dir="rtl">
                                <p id="exam_title-error" class="error-message" style="color:red;"></p>
                            </div>

                            <div class="exam-field">
                                <label for="examDescription">وصف الامتحان:</label>
                                <textarea id="examDescription" name="exam_description" placeholder="أدخل وصف الامتحان"
                                    dir="rtl"></textarea>
                                <p id="exam_description-error" class="error-message" style="color:red;"></p>
                            </div>

                            <div class="exam-field">
                                <label for="course_id">الدورة:</label>
                                <select id="course_id" name="exam_course_id">
                                    <option value="" disabled selected>اختر الدورة</option>
                                    <?php echo $courses; ?>
                                </select>
                                <p id="exam_course_id-error" class="error-message" style="color:red;"></p>
                            </div>

                            <div class="exam-field">
                                <label for="examFile">رفع ملف الامتحان:</label>
                                <input type="file" id="examFile" name="exam_file" accept="application/pdf">
                                <p id="exam_file-error" class="error-message" style="color:red;"></p>
                            </div>

                            <div class="exam-field">
                                <label for="AQ-files-solution">تحميل حل الامتحان:</label>
                                <input type="file" id="AQ-files-solution" name="exam_solution" accept="application/pdf">
                                <p id="exam_solution-error" class="error-message" style="color:red;"></p>
                            </div>

                            <div class="exam-field">
                                <label for="AQ-deadline">تاريخ انتهاء الامتحان:</label>
                                <input type="date" id="AQ-deadline" name="exam_due_date">
                                <p id="exam_due_date-error" class="error-message" style="color:red;"></p>
                            </div>

                            <button type="submit" class="submit-btn">إنشاء الامتحان</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="content-section scrollable-section" id="feedback">
                <div class="messages-content">
                    <h2>عرض التقييمات</h2>
                    <div class="messages-container">
                        <?php include 'fetch_feedback.php'; ?>
                    </div>
                </div>
            </div>


            <?php
            if (isset($_GET['message'])) {
                echo "<p>" . htmlspecialchars($_GET['message']) . "</p>";
            }
            ?>

            <div class="content-section scrollable-section" id="messages">
                <div class="messages-content">
                    <h2>عرض الرسائل</h2>
                    <div class="messages-container">
                        <?php include 'fetch_messages.php'; ?>
                    </div>
                </div>
            </div>



            <div class="content-section scrollable-section" id="students-payement">
                <div class="PaymentReview">
                    <h1>مراجعة الدفع</h1>
                    <div class="TablePayment">
                        <table>
                            <tr>
                                <th>الاسم الكامل للطالب</th>
                                <th>مبلغ الدفع</th>
                                <th>تاريخ الدفع</th>
                                <th>صورة إثبات الدفع</th>
                                <th>خيارات</th>
                            </tr>
                            <?php include './payements.php'; ?>
                        </table>
                    </div>

                    <div id="paymentPopUp" class="paymentPopUp">
                        <div class="paymentPopUp-content">
                            <span class="close" onclick="closePaymentPopUp()">&times;</span>
                            <h2>تفاصيل الدفع</h2>
                            <div class="paymentPopUp-field">
                                <p>: المبلغ المدفوع</p>
                                <input type="number" id="paymentAmount" />
                            </div>

                            <div class="paymentPopUp-field">
                                <p>: تاريخ الدفع</p>
                                <input type="date" id="paymentDate" readonly />
                            </div>

                            <div style="display: none;" class="paymentPopUp-field">
                                <p>:</p>
                                <a id="downloadProof" href="" download="Proof_of_Payment.jpg">
                                    <button class="download-btn">تحميل الإثبات</button>
                                </a>
                            </div>
                            <div class="revbutton">
                                <button class="accept-btn" onclick="acceptPayment()">قبول</button>
                                <button class="reject-btn" onclick="rejectPayment()">رفض</button>
                                <div id="messagePopUp" class="messagePopUp">
                                    <div class="messagePopUp-content">
                                        <span class="close" onclick="closeMessagePopUp()">&times;</span>
                                        <p id="messageText"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="blocker" class="blocker" style="display: none;"></div>
                </div>
            </div>
        </section>
    </div>
    <div>
        <div class="footer">
            <div class="footer-left-side">
                <div class="motivation-text">
                    <h3> ! مفتاح المستقبل &lrm;</h3>
                    <p> العلم هو الأساس الذي تبنى عليه الإنجازات، فلا تستخف بجهودك اليوم. كل ساعة تقضيها في الدراسة
                        تقربك من تحقيق أحلامك. التحديات التي تواجهها هي مجرد خطوات على طريق النجاح. اجعل شغفك بالمعرفة
                        دافعًا، وكن واثقًا أن مستقبلك المشرق ينتظرك &lrm;</p>
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
<script defer src="../js/admin-dashboard.js"></script>
</body>

</html>