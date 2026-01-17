document.addEventListener("DOMContentLoaded", () => {
    const adminForm = document.querySelector("#adminForm");
<<<<<<< HEAD
    const nameField = document.querySelector("#adminName");
=======
>>>>>>> 364b5b921ae54ca467665e9453cf5670f4afb71d
    const emailField = document.querySelector("#adminEmail");
    const passwordField = document.querySelector("#adminPassword");
    const confirmPasswordField = document.querySelector("#adminConfirmPassword");
    const adminTableBody = document.querySelector("#adminTableBody");

    let admins = []; // Array to hold admin data

    // Utility functions
    const errorMsg = (field, message) => {
        field.nextElementSibling.innerText = message;
    };

    const isEmailValid = (email) => /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z]{2,5}$/.test(email);
    const validatePassword = (password) => {
        const errors = [];
        if (password.length < 8) errors.push("8 أحرف على الأقل");
        if (!/[A-Z]/.test(password)) errors.push("حرف كبير");
        if (!/[0-9]/.test(password)) errors.push("رقم");
        if (!/[!@$%*#]/.test(password)) errors.push("رمز خاص");
        return errors.length > 0 ? `كلمة المرور يجب أن تحتوي على: ${errors.join(", ")}` : "";
    };

    // Add admin
    adminForm.addEventListener("submit", (e) => {
<<<<<<< HEAD
        const name = nameField.value.trim();
=======

>>>>>>> 364b5b921ae54ca467665e9453cf5670f4afb71d
        const email = emailField.value.trim();
        const password = passwordField.value.trim();
        const confirmPassword = confirmPasswordField.value.trim();

        let isValid = true;

<<<<<<< HEAD
        if (!name) {
            errorMsg(nameField, "الاسم مطلوب");
            isValid = false;
        } else {
            errorMsg(nameField, "");
        }

=======
>>>>>>> 364b5b921ae54ca467665e9453cf5670f4afb71d
        if (!isEmailValid(email)) {
            errorMsg(emailField, "بريد إلكتروني غير صالح");
            isValid = false;
        } else {
            errorMsg(emailField, "");
        }

        const passwordError = validatePassword(password);
        if (passwordError) {
            errorMsg(passwordField, passwordError);
            isValid = false;
        } else {
            errorMsg(passwordField, "");
        }

        if (password !== confirmPassword) {
            errorMsg(confirmPasswordField, "كلمات المرور غير متطابقة");
            isValid = false;
        } else {
            errorMsg(confirmPasswordField, "");
        }

        if (isValid) {
<<<<<<< HEAD
            admins.push({ id: admins.length + 1, name, email });
=======
            admins.push({ id: admins.length + 1, email });
>>>>>>> 364b5b921ae54ca467665e9453cf5670f4afb71d
            renderAdmins();
            adminForm.reset();
        }
    });

    // Render admin list
    const renderAdmins = () => {
        adminTableBody.innerHTML = admins
            .map(
                (admin, index) => `
            <tr>
                <td>${index + 1}</td>
<<<<<<< HEAD
                <td>${admin.name}</td>
=======
>>>>>>> 364b5b921ae54ca467665e9453cf5670f4afb71d
                <td>${admin.email}</td>
                <td>
                    <button class="delete-btn" onclick="deleteAdmin(${index})">
                        <i class="fa fa-trash"></i> حذف
                    </button>
                </td>
            </tr>`
            )
            .join("");
    };

    // Delete admin
    window.deleteAdmin = (index) => {
        if (confirm("هل تريد حذف المسؤول؟")) {
            admins.splice(index, 1);
            renderAdmins();
        }
    };
});
