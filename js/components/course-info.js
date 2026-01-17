const course_title = document.querySelector(".course-name h4");
let course_info = document.querySelector(".course-info");
const course_creation_date = document.querySelector(".creation-date")

//function load content according to choosed course
function loadCourseInfo(title, content, date) {
    course_title.innerText = title;
    
    content = content.replace(".", "<br>");
    course_info.innerHTML = content; 

    course_creation_date.innerText = date;
}
