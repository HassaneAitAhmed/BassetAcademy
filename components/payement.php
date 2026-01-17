<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>PAYEMENT</title>
    <link rel="stylesheet" type="text/css" href="../css/payement.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="pay-prin">
    <div class="payment-container">
        <h1>شحن المحفظة</h1>

        <div class="instructions">
            <h2>التعليمات</h2>
            <ul>
                <li>اختر طريقة دفع مناسبة وحول المبلغ المراد شحنه.</li>
                <li>أدخل رقم الرصيد وارفق صورة واضحة للإيصال.</li>
                <li>ستتم المراجعة خلال 24 ساعة وشحن المحفظة تلقائياً.</li>
            </ul>
        </div>

        <div class="payment-methods">
            <div class="payment-method">
                <img src="../assets/img/Baridimob.png" alt="AlgeriePoste">
                <h3>حساب البريد</h3>
                <p>18520078 clé 20</p>
            </div>
            <div class="payment-method">
                <img src="../assets/img/Baridimob.png" alt="Baridimob">
                <h3>حساب Baridimob</h3>
                <p>00799999001852007820</p>
            </div>
        </div>

        <form id="payment-form">
            <div class="amount-input">
                <label for="amount">المبلغ:</label>
                <input type="number" id="amount" name="amount" required>
            </div>

            <div class="file-upload">
                <label for="receipt">اختر ملف الإيصال</label>
                <input type="file" id="receipt" name="receipt" accept="image/*" required>
            </div>

            <button type="submit">تأكيد العملية</button>
        </form>

        <div class="transaction-history">
            <h2>العمليات السابقة</h2>
            <p>لا توجد بيانات</p>
            <p>لا توجد بيانات</p>
        </div>
    </div>
</div>
</body>

</html>