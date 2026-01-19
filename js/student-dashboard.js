document.addEventListener("DOMContentLoaded", function() {

    // Code from nav.js
    const dropBtn = document.getElementById("drop-down-menu");
    const dropDownMenu = document.getElementsByClassName("media-drop-down-btns")[0];

    const dropBtnDisplay = function () {
        if (window.innerWidth <= 768) {
            if (dropBtn.checked) {
                dropDownMenu.classList.add("show");
            } else {
                dropDownMenu.classList.remove("show"); 
            }
        } else {
            dropDownMenu.classList.remove("show"); 
        }
    };

    if(dropBtn) {
        dropBtn.addEventListener("change", dropBtnDisplay);
    }
    window.addEventListener("resize", dropBtnDisplay);

    // Code from Student-Dashboard.js
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

    const paymentForm = document.getElementById("payment-form");
    if(paymentForm) {
        paymentForm.addEventListener('submit', function(event) {
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
        });
    }
    
    window.closePopup = function() {
        const popup = document.getElementById("popup");
        popup.style.display = "none";
    }
    
    window.redirectToHome = function() {
        window.location.href = "../student.php";
    }
    
    window.redirectToCourse = function(courseID) {
        window.location.href = "pages/Courseframe-stud.php?courseID=" + courseID;
    }

    // Code from Feedback-section.js
    const stars = document.querySelectorAll('.fa-star');
    let selectedRating = 0;
    
    function highlightStars(upToIndex) {
      stars.forEach((star, index) => {
        if (index <= upToIndex) {
          star.style.color = 'blue';
        } else {
          star.style.color = '';
        }
      });
    }
    
    function resetStars() {
      stars.forEach(star => {
        star.style.color = '';
      });
    }
    
    stars.forEach((star, index) => {
      star.addEventListener('mouseover', () => {
        highlightStars(index);
      });
    
      star.addEventListener('mouseout', () => {
        if (selectedRating === 0) {
          resetStars();
        } else {
          highlightStars(selectedRating - 1);
        }
      });
    
      star.addEventListener('click', () => {
        if (selectedRating === index + 1) {
          selectedRating = 0;
          resetStars();
        } else {
          selectedRating = index + 1;
          highlightStars(index);
        }
      });
    });

    // Logout functionality
    const logoutBtn = document.querySelector("#logoutBtn");
    if(logoutBtn) {
        logoutBtn.addEventListener("click", () => {
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "logout.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhttp.onload = function () {
                if (xhttp.status === 200) {
                    window.location.href = "SignIn.php";
                } else {
                    console.error("Logout failed.");
                }
            };

            xhttp.onerror = function () {
                console.error("Request error.");
            };

            xhttp.send("logout=true");
        });
    }

    const updateProfileBtn = document.querySelector("#updateProfileBtn");
    if(updateProfileBtn) {
        updateProfileBtn.addEventListener("click", function () {
            window.location.href = "updateProfile.php";
        });
    }
    
    const closeButtons = document.querySelectorAll('.close-btn');
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var popupId = button.getAttribute('data-popup-id');
            var popup = document.getElementById(popupId);
            if (popup) {
                popup.style.display = 'none';
            } else {
                console.error("Popup element not found with ID:", popupId);
            }
        });
    });
});
