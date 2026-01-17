/*const lastname = document.querySelector("#SU-LastName");
const firstname = document.querySelector("#SU-FirstName");
const email = document.querySelector("#SU-Email");
const phonenum = document.querySelector("#SU-PhoneNumber");
const pass = document.querySelector("#SU-Password");
const confirmpass = document.querySelector("#SU-ConfirmPassword");
const SUform = document.querySelector("#SU-form");

const errorMsg = (element, message) => {
    element.parentNode.lastElementChild.innerText = message;
};

function isPhoneNumber(value) {
    return /^([0]{1}[5-7]{1}[0-9]{8})$/.test(value);
}

function isEmail(value) {
    return /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,5}$/.test(value);
}

function containsNumber(value) {
    return /\d/.test(value);
}

function containsUppercase(value) {
    return /[A-Z]/.test(value);
}

function containsSpecialChar(value) {
    return /[!@$%*#]/.test(value);
}


//form validation function of Sign Up process
const validateForm = () => {
    SUform.addEventListener("submit", (e) => {
        let isValid = true;

        if (
            lastname.value.length < 3 ||
            lastname.value.length > 40 ||
            containsSpecialChar(lastname.value)
        ) {
            errorMsg(lastname, ".يجب أن يكون اسم العائلة بين 3 و 40 حرفًا ولا يحتوي على أحرف خاصة");
            isValid = false;
        } else {
            errorMsg(lastname, "");
        }
        
        if (
            firstname.value.length < 3 ||
            firstname.value.length > 40 ||
            containsSpecialChar(firstname.value)
        ) {
            errorMsg(firstname, ". يجب أن يكون الاسم الأول بين 3 و 40 حرفًا ولا يحتوي على أحرف خاصة");
            isValid = false;
        } else {
            errorMsg(firstname, "");
        }

        if (!isPhoneNumber(phonenum.value)) {
            errorMsg(phonenum, ". يرجى إدخال رقم هاتف صحيح");
            isValid = false;
        } else {
            errorMsg(phonenum, "");
        }

        if (email.value.trim() === "") {
            errorMsg(email, ". لا يمكن أن يكون البريد الإلكتروني فارغًا");
            isValid = false;
        } else if (!isEmail(email.value)) {
            errorMsg(email, ". يرجى إدخال بريد إلكتروني صالح");
            isValid = false;
        } else {
            errorMsg(email, "");
        }

        const passwordErrors = validatePassword(pass.value);
        if (passwordErrors.length > 0) {
            errorMsg(pass, passwordErrors.join("\n"));
            isValid = false;
        } else {
            errorMsg(pass, "");
        }

        if (confirmpass.value !== pass.value) {
            errorMsg(confirmpass, ".كلمة المرور غير مطابقة");
            isValid = false;
        } else {
            errorMsg(confirmpass, "");
        }

        if (!isValid) e.preventDefault();
    });

    SUform.addEventListener("reset", () => {
        errorMsg(lastname, "");
        errorMsg(firstname, "");
        errorMsg(email, "");
        errorMsg(phonenum, "");
        errorMsg(pass, "");
        errorMsg(confirmpass, "");
    });
};

validateForm();

const validatePassword = (password) => {
    let errors = [];

    if (password.length < 8) {
        errors.push("يجب أن تكون كلمة المرور مكونة من أكثر من 8 أحرف");
    }
    if (!containsNumber(password)) {
        errors.push("يجب أن تحتوي كلمة المرور على رقم واحد على الأقل");
    }
    if (!containsUppercase(password)) {
        errors.push("يجب أن تحتوي كلمة المرور على حرف كبير واحد على الأقل");
    }
    if (!containsSpecialChar(password)) {
        errors.push("يجب أن تحتوي كلمة المرور على رمز خاص واحد على الأقل");
    }

    return errors;
};*/