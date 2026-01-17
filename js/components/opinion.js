function validateForm() {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var message = document.getElementById('message').value.trim();
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');

    if (name === "" || email === "" || message === "") {
        popupMessage.innerText = "جميع الحقول مطلوبة";
        popup.style.display = "block";
        return false;
    }

    var namePattern = /^[a-zA-Z\u0621-\u064A\s]+$/;
    if (!namePattern.test(name)) {
        popupMessage.innerText = "يجب أن يحتوي الاسم على أحرف فقط";
        popup.style.display = "block";
        return false;
    }

    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        popupMessage.innerText = "يرجى إدخال بريد إلكتروني صالح";
        popup.style.display = "block";
        return false;
    }

    popupMessage.innerText = "تم إرسال الرسالة بنجاح";
    popup.style.display = "block";
    return false; 
}

function closePopup() {
    var popup = document.getElementById('popup');
    popup.style.display = "none";
}
