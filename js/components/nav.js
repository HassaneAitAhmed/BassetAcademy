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

dropBtn.addEventListener("change", dropBtnDisplay);
window.addEventListener("resize", dropBtnDisplay);
