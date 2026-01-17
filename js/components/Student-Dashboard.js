const navigation_btns = document.querySelectorAll(".dashboard-right-side li");
const dashboard_divs = [
    "user-exams",
    "user-exams-result",
    "user-feedback",
    "user-payment",
    "userI",
    "user-tracking",
    "user-courses"
];

function showDiv(divId) {
    dashboard_divs.forEach((id) => {
        const div = document.getElementsByClassName(id)[0];
        if (div) {
            if (id === divId) {
                div.style.display = (id === "userI") ? "block" : "flex";
            } else {
                div.style.display = "none";
            }
        }
    });
}

navigation_btns.forEach((link) => {
    link.addEventListener("click", () => {
        let targetDivId = "";

        if (link.id === "user-paiment-btn") {
            targetDivId = "user-payment";
        } else if (link.id === "user-info-btn") {
            targetDivId = "userI";
        } else if (link.id === "user-exam-btn") {
            targetDivId = "user-exams";
        } else if (link.id === "user-exam-results-btn") {
            targetDivId = "user-exams-result";
        } else if (link.id === "user-feedback-btn") {
            targetDivId = "user-feedback";
        } else if (link.id === "user-security-btn") {
            targetDivId = "user-tracking";
        } else if (link.id === "user-courses-btn") {
            targetDivId = "user-courses";
        }

        if (targetDivId) {
            showDiv(targetDivId);
            localStorage.setItem('activeDiv', targetDivId);
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const activeDiv = localStorage.getItem('activeDiv');
    if (activeDiv && dashboard_divs.includes(activeDiv)) {
        showDiv(activeDiv);
    } else {
        showDiv("user-exams");
    }

    const popupMessage = localStorage.getItem('popupMessage');
    if (popupMessage) {
        const popup = document.getElementById("popup");
        const popupMessageElement = document.getElementById("popup-message");
        popupMessageElement.innerText = popupMessage;
        popup.style.display = "block";

        localStorage.removeItem('popupMessage');
    }
});

function validateForm(event) {
    const amount = document.getElementById("amount").value;
    const receipt = document.getElementById("receipt").files.length;

    const amountPattern = /^\d+$/;

    if (!amountPattern.test(amount) || amount <= 0 || amount < 500) {
        const errorMessage = "يرجى إدخال مبلغ صحيح (أكبر من 500) باستخدام أرقام صحيحة فقط.";
        localStorage.setItem('popupMessage', errorMessage);

        const popup = document.getElementById("popup");
        const popupMessageElement = document.getElementById("popup-message");
        popupMessageElement.innerText = errorMessage;
        popup.style.display = "block";

        event.preventDefault();
        return false;
    }

    if (receipt === 0) {
        const errorMessage = "يرجى تحميل صورة الإيصال.";
        localStorage.setItem('popupMessage', errorMessage);

        const popup = document.getElementById("popup");
        const popupMessageElement = document.getElementById("popup-message");
        popupMessageElement.innerText = errorMessage;
        popup.style.display = "block";

        event.preventDefault();
        return false;
    }

    const successMessage = "تم إرسال الطلب بنجاح. سيتم مراجعة عملية الدفع قريباً.";
    localStorage.setItem('popupMessage', successMessage);

    const popup = document.getElementById("popup");
    const popupMessageElement = document.getElementById("popup-message");
    popupMessageElement.innerText = successMessage;
    popup.style.display = "block";

    return true;
}

function closePopup() {
    const popup = document.getElementById("popup");
    popup.style.display = "none";
}

function redirectToHome() {
    window.location.href = "../student.php";
}

function redirectToCourse(courseID) {
    window.location.href = "pages/Courseframe-stud.php?courseID=" + courseID;
}
