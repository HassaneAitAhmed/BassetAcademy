/*const email = document.querySelector("#SI-Email");
const pass = document.querySelector("#SI-Password");
const SIform = document.querySelector("#SI-form");

const setErrorMsg = (selector, message) => {
    document.querySelector(selector).innerText = message;
};

function isEmail(value) {
    return /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,5}$/.test(value);
}

//form validation function of Sign In process
const validateForm = function () {
    SIform.addEventListener("submit", (e) => {
        let isValid = true;

        if (email.value.trim() === "") {
            setErrorMsg(".SI-email-error", "الرجاء إدخال البريد الإلكتروني");
            isValid = false;
        } else if (!isEmail(email.value)) {
            setErrorMsg(".SI-email-error", "الرجاء إدخال بريد إلكتروني صالح");
            isValid = false;
        } else {
            setErrorMsg(".SI-email-error", "");
        }

        if (pass.value.length < 8) {
            setErrorMsg(".SI-pass-error", "يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل");
            isValid = false;
        } else if (!/[A-Z]/.test(pass.value)) {
            setErrorMsg(".SI-pass-error", "يجب أن تحتوي كلمة المرور على حرف كبير واحد على الأقل");
            isValid = false;
        } else if (!/[a-z]/.test(pass.value)) {
            setErrorMsg(".SI-pass-error", "يجب أن تحتوي كلمة المرور على حرف صغير واحد على الأقل");
            isValid = false;
        } else if (!/[0-9]/.test(pass.value)) {
            setErrorMsg(".SI-pass-error", "يجب أن تحتوي كلمة المرور على رقم واحد على الأقل");
            isValid = false;
        } else if (!/[!@$%*]/.test(pass.value)) {
            setErrorMsg(".SI-pass-error", "يجب أن تحتوي كلمة المرور على رمز خاص واحد على الأقل");
            isValid = false;
        } else {
            setErrorMsg(".SI-pass-error", "");
        }

        if (!isValid) e.preventDefault();
    });
};

validateForm();*/
document.addEventListener('DOMContentLoaded', function () {
    const signInForm = document.getElementById('SI-form');
    
    signInForm.addEventListener('submit', function (event) {
        const emailField = document.getElementById('SI-Email');
        const passwordField = document.getElementById('SI-Password');
        
        if (!emailField.value || !passwordField.value) {
            event.preventDefault();
            alert("Please fill in both fields.");
        }
    });
});

function redirectToHome() {
    window.location.href = "../guest.php";
}
