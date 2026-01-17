function handleTutorialSubmit(event) {
    event.preventDefault(); 
    let isValid = true;

    const title = document.getElementById("title");
    const description = document.getElementById("description");
    const video = document.getElementById("video");
    const course_id = document.getElementById("course_id");
    const materials = document.getElementById("materials");
    const summaries = document.getElementById("summaries");
    const alertMessage = document.getElementById("alertMessageTutorial");

    const titleError = document.getElementById("titleError");
    const descriptionError = document.getElementById("descriptionError");
    const videoError = document.getElementById("videoError");
    const courseError = document.getElementById("courseError");
    const materialsError = document.getElementById("materialsError");
    const summariesError = document.getElementById("summariesError");

    titleError.textContent = "";
    descriptionError.textContent = "";
    videoError.textContent = "";
    courseError.textContent = "";
    materialsError.textContent = "";
    summariesError.textContent = "";
    alertMessage.textContent = "";

    // Validate title
    if (title.value.trim().length < 5) {
        titleError.textContent = "العنوان يجب أن يكون أكثر من 5 أحرف.";
        isValid = false;
    }

    // Validate description
    if (description.value.trim().length < 10) {
        descriptionError.textContent = "الوصف يجب أن يكون أكثر من 10 أحرف.";
        isValid = false;
    }

    // Validate course selection
    if (!course_id.value) {
        courseError.textContent = "يرجى اختيار الدورة.";
        isValid = false;
    }

    // Validate video
    if (!video.files.length) {
        videoError.textContent = "يرجى اختيار فيديو.";
        isValid = false;
    }

    // Validate materials (at least one material must be uploaded)
    if (!materials.files.length) {
        materialsError.textContent = "يرجى تحميل مواد تعليمية.";
        isValid = false;
    }

    // Validate summaries (at least one summary file must be uploaded)
    if (!summaries.files.length) {
        summariesError.textContent = "يرجى تحميل ملخصات.";
        isValid = false;
    }

    // If form is valid
    if (isValid) {
        alertMessage.textContent = "تم إنشاء الدورة التعليمية بنجاح!";
        alertMessage.className = "alert-message alert-success";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
            document.getElementById("tutorialForm").reset();
        }, 3000);
    } else {
        alertMessage.textContent = "يرجى تصحيح الأخطاء أعلاه.";
        alertMessage.className = "alert-message alert-error";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
        }, 5000);
    }
}


function handleVideoUploadSubmit(event) {
    event.preventDefault(); 
    let isValid = true; 

    const videoName = document.getElementById("videoName");
    const videoNameError = document.getElementById("videoNameError");
    if (videoName.value.trim().length < 5) {
        videoNameError.textContent = "اسم الفيديو يجب أن يكون أكثر من 5 أحرف.";
        isValid = false;
    } else {
        videoNameError.textContent = "";
    }

    const videoDescription = document.getElementById("videoDescription");
    const videoDescriptionError = document.getElementById("videoDescriptionError");
    if (videoDescription.value.trim().length < 10) {
        videoDescriptionError.textContent = "وصف الفيديو يجب أن يكون أكثر من 10 أحرف.";
        isValid = false;
    } else {
        videoDescriptionError.textContent = "";
    }

    const videoThumbnail = document.getElementById("videoThumbnail");
    const videoThumbnailError = document.getElementById("videoThumbnailError");
    if (!videoThumbnail.files.length) {
        videoThumbnailError.textContent = "يرجى تحميل صورة مصغرة للفيديو.";
        isValid = false;
    } else {
        const file = videoThumbnail.files[0];
        const validImageTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!validImageTypes.includes(file.type)) {
            videoThumbnailError.textContent = "يرجى تحميل صورة بصيغة JPEG, PNG, أو GIF.";
            isValid = false;
        } else {
            videoThumbnailError.textContent = "";
        }
    }

    const courseCategory = document.getElementById("courseCategory");
    const courseCategoryError = document.getElementById("courseCategoryError");
    if (!courseCategory.value) {
        courseCategoryError.textContent = "يرجى اختيار الدورة.";
        isValid = false;
    } else {
        courseCategoryError.textContent = "";
    }

    const summaryPdf = document.getElementById("summaryPdf");
    const summaryPdfError = document.getElementById("summaryPdfError");
    if (!summaryPdf.files.length) {
        summaryPdfError.textContent = "يرجى تحميل ملف الملخص.";
        isValid = false;
    } else {
        const file = summaryPdf.files[0];
        if (file.type !== "application/pdf") {
            summaryPdfError.textContent = "يرجى تحميل ملف بصيغة PDF.";
            isValid = false;
        } else {
            summaryPdfError.textContent = "";
        }
    }

    const materialsPdf = document.getElementById("materialsPdf");
    const materialsPdfError = document.getElementById("materialsPdfError");
    if (materialsPdf.files.length) {
        const file = materialsPdf.files[0];
        if (file.type !== "application/pdf") {
            materialsPdfError.textContent = "يرجى تحميل ملف الأدوات بصيغة PDF.";
            isValid = false;
        } else {
            materialsPdfError.textContent = "";
        }
    } else {
        materialsPdfError.textContent = "";
    }

    const assignmentsPdf = document.getElementById("assignmentsPdf");
    const assignmentsPdfError = document.getElementById("assignmentsPdfError");
    if (assignmentsPdf.files.length) {
        const file = assignmentsPdf.files[0];
        if (file.type !== "application/pdf") {
            assignmentsPdfError.textContent = "يرجى تحميل ملف التمارين بصيغة PDF.";
            isValid = false;
        } else {
            assignmentsPdfError.textContent = "";
        }
    } else {
        assignmentsPdfError.textContent = "";
    }

    if (isValid) {
        alert("تم إرسال النموذج بنجاح!");
        event.target.submit();
    }
}


function handleExamSubmit(event) {
    event.preventDefault();

    const examTitle = document.getElementById("AQ-title").value.trim();
    const examType = document.getElementById("AQ-type").value;
    const examDescription = document.getElementById("AQ-description").value.trim();
    const examDeadline = document.getElementById("AQ-deadline").value;
    const examFiles = document.getElementById("AQ-exam-files").files;
    const examThumbnail = document.getElementById("AQexam-thumbnail").files;

    const alertMessage = document.getElementById("alertMessageAssignment");
    const titleError = document.getElementById("AQ-title-error");
    const typeError = document.getElementById("AQ-type-error");
    const descriptionError = document.getElementById("AQ-description-error");
    const deadlineError = document.getElementById("AQ-deadline-error");
    const fileError = document.getElementById("AQ-exam-files-error");
    const thumbnailError = document.getElementById("AQ-thumbnail-error");

    titleError.textContent = "";
    typeError.textContent = "";
    descriptionError.textContent = "";
    deadlineError.textContent = "";
    fileError.textContent = "";
    thumbnailError.textContent = "";

    let isValid = true;

    if (!examTitle || examTitle.length < 5) {
        titleError.textContent = "عنوان الامتحان يجب أن يكون أكثر من 5 أحرف.";
        isValid = false;
    }
    if (!examType) {
        typeError.textContent = "يرجى اختيار نوع الامتحان.";
        isValid = false;
    }
    if (!examDescription || examDescription.length < 10) {
        descriptionError.textContent = "معلومات الامتحان يجب أن تكون أكثر من 10 أحرف.";
        isValid = false;
    }
    if (!examDeadline) {
        deadlineError.textContent = "يرجى تحديد تاريخ انتهاء الامتحان.";
        isValid = false;
    }
    if (!examFiles.length) {
        fileError.textContent = "يرجى تحميل ملف الإمتحان.";
        isValid = false;
    }
    if (!examThumbnail.length) {
        thumbnailError.textContent = "يرجى تحميل صورة للإمتحان.";
        isValid = false;
    }

    if (isValid) {
        alertMessage.textContent = "تم إنشاء الامتحان بنجاح!";
        alertMessage.className = "alert-message alert-success";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
            document.getElementById("assignmentForm").reset();
        }, 3000);
    } else {
        alertMessage.textContent = "يرجى إصلاح الأخطاء أعلاه.";
        alertMessage.className = "alert-message alert-error";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
        }, 5000);
    }
}



function handleTestSubmit(event) {
    event.preventDefault(); 
    let isValid = true;

    const examTitle = document.getElementById("examTitle");
    const examDescription = document.getElementById("examDescription");
    const examDeadline = document.getElementById("examDeadline");
    const examImages = document.getElementById("examImages");
    const alertMessage = document.getElementById("alertMessageExam");

    const examTitleError = document.getElementById("examTitleError");
    const examDescriptionError = document.getElementById("examDescriptionError");
    const examDeadlineError = document.getElementById("examDeadlineError");
    const examImagesError = document.getElementById("examImagesError");

    examTitleError.textContent = "";
    examDescriptionError.textContent = "";
    examDeadlineError.textContent = "";
    examImagesError.textContent = "";
    alertMessage.textContent = "";

    if (examTitle.value.trim().length < 5) {
        examTitleError.textContent = "العنوان يجب أن يكون أكثر من 5 أحرف.";
        isValid = false;
    }

    if (examDescription.value.trim().length < 10) {
        examDescriptionError.textContent = "الوصف يجب أن يكون أكثر من 10 أحرف.";
        isValid = false;
    }

    if (!examDeadline.value) {
        examDeadlineError.textContent = "يرجى تحديد تاريخ انتهاء الامتحان.";
        isValid = false;
    }

    if (!examImages.files.length) {
        examImagesError.textContent = "يرجى تحميل صورة واحدة على الأقل.";
        isValid = false;
    } else {
        for (const file of examImages.files) {
            if (!["image/jpeg", "image/png", "image/gif"].includes(file.type)) {
                examImagesError.textContent = "يرجى تحميل صور بصيغة JPEG, PNG, أو GIF.";
                isValid = false;
                break;
            }
        }
    }

    if (isValid) {
        alertMessage.textContent = "تم إنشاء الامتحان بنجاح!";
        alertMessage.className = "alert-message alert-success";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
            document.getElementById("examForm").reset();
        }, 3000);
    } else {
        alertMessage.textContent = "يرجى تصحيح الأخطاء أعلاه.";
        alertMessage.className = "alert-message alert-error";
        alertMessage.style.display = "block";

        setTimeout(() => {
            alertMessage.style.display = "none";
        }, 5000);
    }
}


function isValidUrl(url) {
    const urlPattern = /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w .-]*)*\/?$/;
    return urlPattern.test(url);
}





function showContent(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });

    const sectionToShow = document.getElementById(sectionId);
    if (sectionToShow) {
        sectionToShow.style.display = 'block';
    }

    if (window.innerWidth <= 768) {
        sectionToShow.scrollIntoView({ behavior: 'smooth' });
    }
}
