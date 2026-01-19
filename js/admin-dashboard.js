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

    // Code from AdminDashboard.js
    function showContent(sectionId) {
        document.querySelectorAll('.content-section').forEach(section => {
            section.style.display = 'none';
        });
    
        const sectionToShow = document.getElementById(sectionId);
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
        }
    
        if (window.innerWidth <= 768) {
            if(sectionToShow) {
                sectionToShow.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }

    // Attach event listeners to sidebar links
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function(event) {
            const sectionId = this.getAttribute('onclick').match(/'([^']+)'/)[1];
            if(sectionId) {
                event.preventDefault();
                showContent(sectionId);
            }
        });
    });


    // Generic form submission handler
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = event.target;
        const url = form.getAttribute('action');
        const successMessage = form.dataset.successMessage;
        const formData = new FormData(form);

        document.querySelectorAll(`#${form.id} .error-message`).forEach(div => div.textContent = '');

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(successMessage);
                location.reload(); // Reload or redirect as needed
            } else {
                if (data.errors) {
                    for (const [field, message] of Object.entries(data.errors)) {
                        const errorElement = document.getElementById(`${field}-error`);
                        if (errorElement) {
                            errorElement.textContent = message;
                            errorElement.classList.add('active');
                        }
                    }
                }

                if (data.errors && data.errors.general) {
                    alert(data.errors.general);
                }
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Initialize form submissions
    const tutorialForm = document.getElementById('tutorialForm');
    if(tutorialForm) {
        tutorialForm.setAttribute('action', 'create_tutorial.php');
        tutorialForm.dataset.successMessage = 'تم إنشاء الدورة التعليمية بنجاح!';
        tutorialForm.addEventListener('submit', handleFormSubmit);
    }

    const courseForm = document.getElementById('courseForm');
    if(courseForm) {
        courseForm.setAttribute('action', 'create_course.php');
        courseForm.dataset.successMessage = 'تم إنشاء الدورة بنجاح!';
        courseForm.addEventListener('submit', handleFormSubmit);
    }

    const assignmentForm = document.getElementById('assignmentForm');
    if(assignmentForm) {
        assignmentForm.setAttribute('action', 'create_assignment.php');
        assignmentForm.dataset.successMessage = 'تم إنشاء الواجب بنجاح!';
        assignmentForm.addEventListener('submit', handleFormSubmit);
    }
    
    const examForm = document.getElementById('examForm');
    if(examForm) {
        examForm.setAttribute('action', 'create_exam.php');
        examForm.dataset.successMessage = 'تم إنشاء الامتحان بنجاح!';
        examForm.addEventListener('submit', handleFormSubmit);
    }

    // redirectToHome function
    window.redirectToHome = function() {
        window.location.href = "../admin.php";
    }

    // Logout functionality
    const logoutBtn = document.querySelector("#logoutBtn");
    if (logoutBtn) {
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

    // Listandpay.js code
    let selectedRow;

    // Show student info in the popup
    window.showStudentInfo = function(name, email, phone, date, wallet, row) {
        selectedRow = row;
        document.getElementById("studentName").value = name;
        document.getElementById("studentEmail").value = email;
        document.getElementById("studentPhone").value = phone;
        document.getElementById("studentDate").value = date;
        document.getElementById("studentWallet").value = wallet;
        document.getElementById("studentpopUpStudentinfo").style.display = "block";
    }

    // Save edited student info
    window.saveStudentInfo = function() {
        const name = document.getElementById("studentName").value;
        const email = document.getElementById("studentEmail").value;
        const phone = document.getElementById("studentPhone").value;
        const date = document.getElementById("studentDate").value;
        const wallet = document.getElementById("studentWallet").value;
        selectedRow.cells[0].innerText = name;
        selectedRow.cells[1].innerText = email;
        selectedRow.cells[2].innerText = phone;
        selectedRow.cells[3].innerText = date;
        selectedRow.cells[4].innerText = wallet;
        closepopUpStudentinfo();
    }

    // Close the student info popup
    window.closepopUpStudentinfo = function() {
        document.getElementById("studentpopUpStudentinfo").style.display = "none";
    }

    // Show payment details in the popup
    window.showPaymentDetails = function(amount, date, proofImage, row) {
        selectedRow = row;
        document.getElementById("paymentAmount").value = amount;
        document.getElementById("paymentDate").value = date;
        document.getElementById("downloadProof").href = `../assets/images/${proofImage}`;
        document.getElementById("paymentPopUp").style.display = "block";
    }

    window.savePaymentChanges = function() {
        const amount = document.getElementById("paymentAmount").value;
        selectedRow.cells[1].innerText = amount;
        closePaymentPopUp();
    }

    window.acceptPayment = function() {
        showMessage("تم قبول الدفع");
        const paymentId = selectedRow.closest("tr").getAttribute("data-id");
        const paymentValue = document.getElementById("paymentAmount").value;  

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_payment_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const rowToRemove = selectedRow.closest("tr"); 
                        rowToRemove.remove(); 
                        closePaymentPopUp();
                        closepopUpStudentinfo();
                    } else {
                        alert("حدث خطأ أثناء قبول الدفع.");
                    }
                } catch(e) {
                    console.error("Could not parse JSON response: " + xhr.responseText);
                    alert("An error occurred while processing the response from the server.");
                }
            }
        };
        xhr.send("payment_id=" + paymentId + "&status=accepted&payment_value=" + paymentValue);
    }

    window.rejectPayment = function() {
        showMessage("تم رفض الدفع");
        const paymentId = selectedRow.closest("tr").getAttribute("data-id");
        const paymentValue = document.getElementById("paymentAmount").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_payment_status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try{
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        const rowToRemove = selectedRow.closest("tr"); 
                        rowToRemove.remove(); 
                        closePaymentPopUp();
                        closepopUpStudentinfo();
                    } else {
                        alert("حدث خطأ أثناء رفض الدفع.");
                    }
                } catch(e) {
                    console.error("Could not parse JSON response: " + xhr.responseText);
                    alert("An error occurred while processing the response from the server.");
                }
            }
        };
        xhr.send("payment_id=" + paymentId + "&status=rejected&payment_value=" + paymentValue);
    }
    
    function showMessage(message) {
        const messagePopUp = document.getElementById("messagePopUp");
        const messageText = document.getElementById("messageText");
        
        if(messagePopUp && messageText) {
            messageText.textContent = message;
            messagePopUp.style.display = "flex";

            setTimeout(() => {
                closeMessagePopUp();
            }, 3000);
        }
    }

    window.closeMessagePopUp = function() {
        const messagePopUp = document.getElementById("messagePopUp");
        if(messagePopUp) {
            messagePopUp.style.display = "none";
        }
        const paymentPopUp = document.getElementById("paymentPopUp");
        if(paymentPopUp) {
            paymentPopUp.style.display = "none";
        }
    }
    
    window.onclick = function (event) {
        const popUpStudentinfo = document.getElementById("studentpopUpStudentinfo");
        const paymentPopUp = document.getElementById("paymentPopUp");

        if (event.target === popUpStudentinfo) {
            popUpStudentinfo.style.display = "none";
        }

        if (event.target === paymentPopUp) {
            paymentPopUp.style.display = "none";
        }
    }

    const searchInput = document.getElementById("search");
    if(searchInput) {
        searchInput.addEventListener("input", searchStudents);
    }

    function searchStudents() {
        const input = document.getElementById("search").value.toLowerCase();
        const rows = document.querySelectorAll(".TableStudent table tr");

        rows.forEach((row, index) => {
            if (index === 0) return;

            const nameCell = row.cells[0];
            if (nameCell) {
                const nameText = nameCell.innerText.toLowerCase();
                row.style.display = nameText.includes(input) ? "" : "none";
            }
        });
    }

});