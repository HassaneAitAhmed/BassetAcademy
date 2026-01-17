<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity Page</title>
    <link rel="stylesheet" href="../css/components/sessions-tracking.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <div class="logout-stats">
            <h3>🔐 عدد مرات تسجيل الخروج خلال اليوم</h3>
            <p class="logout-message">⚠️ لم يتم تسجيل الخروج بواسطة المستخدم اليوم</p>
            <h3>📅 عدد مرات تسجيل الخروج خلال الاسبوع</h3>
            <p class="logout-message">⚠️ لم يتم تسجيل الخروج بواسطة المستخدم هذا الاسبوع</p>
        </div>

        <div class="download-section">
            <button class="download-btn">📥 تحميل ملف اكسيل</button>
        </div>

        <div class="activity-table">
            <table>
                <thead>
                    <tr>
                        <th>🗓️ تاريخ تسجيل الدخول</th>
                        <th>⏱️ اخر نشاط</th>
                        <th>🌐 المتصفح</th>
                        <th>💻 نظام التشغيل</th>
                        <th>🔍 اسم الجهاز</th>
                        <th>📱 نوع الجهاز</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>الاثنين، 30 سبتمبر 2024 01:17</td>
                        <td>الاحد، 20 اكتوبر 2024 02:50</td>
                        <td><i class="fab fa-edge"></i> Microsoft Edge 129</td>
                        <td><i class="fab fa-windows"></i> Windows 10</td>
                        <td>🔍 Unknown</td>
                        <td>🖥️ Desktop</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="pagination">
            <p>صفوف الصفحة 1 من 1</p>
        </div>
    </div>

</body>
</html>
