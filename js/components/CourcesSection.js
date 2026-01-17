document.addEventListener("DOMContentLoaded", function () {
    const years = document.querySelectorAll(".year");
    const semesters = document.querySelectorAll(".semesters");
    const backButton = document.getElementById("backButton");
    const coursesSection = document.getElementById("courses-section");

    years.forEach(year => {
        year.addEventListener("click", function () {
            const yearId = this.id; 
            const semesterContainer = document.getElementById(`semesters-${yearId}`);

            document.querySelector(".years").style.display = "none";
            semesters.forEach(sem => sem.style.display = "none");
            semesterContainer.style.display = "grid";
            backButton.style.display = "block"; 

            coursesSection.style.backgroundImage = "url('/assets/images/years-section-bg.png')";
        });
    });

    backButton.addEventListener("click", function () {
        document.querySelector(".years").style.display = "grid";
        semesters.forEach(sem => sem.style.display = "none");
        backButton.style.display = "none";
    });
});
