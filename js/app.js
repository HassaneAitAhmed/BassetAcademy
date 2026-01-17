$(document).ready(function(){
    $('.testimonial-container').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
        dots: true,
        arrows: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });
});

function validateForm() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var message = document.getElementById('message').value;
    var popup = document.getElementById('popup');
    var popupMessage = document.getElementById('popup-message');
    var submissionBtn = document.getElementById('submitBtn');

    submissionBtn.addEventListener("click" ,(e)=>{
        if (name === "" || email === "" || message === "") {
            popupMessage.innerText = " يرجى ملئ جميع الحقول مطلوبة" ;
            popup.style.display = "block";
            e.preventDefault();
        }
    
        var namePattern = /^[a-zA-Z\u0621-\u064A\s]+$/;
        if (!namePattern.test(name)) {
            popupMessage.innerText = "يجب أن يحتوي الاسم على أحرف فقط";
            popup.style.display = "block";
            e.preventDefault();
        }
    
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            popupMessage.innerText = "يرجى إدخال بريد إلكتروني صالح";
            popup.style.display = "block";
            e.preventDefault();
        }
    
        popupMessage.innerText = "تم إرسال الرسالة بنجاح";
        popup.style.display = "block";
    })
}

function closePopup() {
    var popup = document.getElementById('popup');
    popup.style.display = "none";
}


document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(this);
    const responseMessage = document.getElementById('responseMessage');

    fetch('components/actionMessageGuest.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        responseMessage.innerHTML = data;
    })
    .catch(error => {
        responseMessage.innerHTML = 'حدث خطأ أثناء إرسال الرسالة.';
        console.error('Error:', error);
    });
});
