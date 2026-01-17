let selectedRow;

// Show student info in the popup
function showStudentInfo(name, email, phone, date, wallet, row) {
    selectedRow = row;

    document.getElementById("studentName").value = name;
    document.getElementById("studentEmail").value = email;
    document.getElementById("studentPhone").value = phone;
    document.getElementById("studentDate").value = date;
    document.getElementById("studentWallet").value = wallet;

    document.getElementById("studentpopUpStudentinfo").style.display = "block";
}

// Save edited student info
function saveStudentInfo() {
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
function closepopUpStudentinfo() {
    document.getElementById("studentpopUpStudentinfo").style.display = "none";
}

// Show payment details in the popup
function showPaymentDetails(amount, date, proofImage, row) {
    selectedRow = row;
    document.getElementById("paymentAmount").value = amount;
    document.getElementById("paymentDate").value = date;
    document.getElementById("downloadProof").href = `../assets/images/${proofImage}`;
    document.getElementById("paymentPopUp").style.display = "block";
}

function savePaymentChanges() {
    const amount = document.getElementById("paymentAmount").value;
    selectedRow.cells[1].innerText = amount;
    closePaymentPopUp();
    
}

function acceptPayment() {
    showMessage("تم قبول الدفع");
    const paymentId = selectedRow.closest("tr").getAttribute("data-id");
    const paymentValue = document.getElementById("paymentAmount").value;  

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_payment_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                const rowToRemove = selectedRow.closest("tr"); 
                rowToRemove.remove(); 
                closePaymentPopUp();
                closepopUpStudentinfo();
            } else {
                alert("حدث خطأ أثناء قبول الدفع.");
            }
        }
    };
    xhr.send("payment_id=" + paymentId + "&status=accepted&payment_value=" + paymentValue);
}

function rejectPayment() {
    showMessage("تم رفض الدفع");
    const paymentId = selectedRow.closest("tr").getAttribute("data-id");
    const paymentValue = document.getElementById("paymentAmount").value;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_payment_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                const rowToRemove = selectedRow.closest("tr"); 
                rowToRemove.remove(); 
                closePaymentPopUp();
                closepopUpStudentinfo();
            } else {
                alert("حدث خطأ أثناء رفض الدفع.");
            }
        }
    };
    xhr.send("payment_id=" + paymentId + "&status=rejected&payment_value=" + paymentValue);
}
function showMessage(message) {
    const messagePopUp = document.getElementById("messagePopUp");
    const messageText = document.getElementById("messageText");
    
    messageText.textContent = message;
    messagePopUp.style.display = "flex";

    setTimeout(() => {
        closeMessagePopUp();
    }, 3000);
}

function closeMessagePopUp() {
    document.getElementById("messagePopUp").style.display = "none";
    document.getElementById("paymentPopUp").style.display = "none";
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

document.getElementById("search").addEventListener("input", searchStudents);
