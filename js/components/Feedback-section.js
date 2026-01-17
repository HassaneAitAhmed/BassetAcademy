const stars = document.querySelectorAll('.fa-star');
let selectedRating = 0;
const submit_feedback_btn = document.querySelector("#submit-feedback");
const textError = document.querySelector("#text-error");
const ratingError = document.querySelector("#rating-error");

// function to highlight stars
function highlightStars(upToIndex) {
  stars.forEach((star, index) => {
    if (index <= upToIndex) {
      star.style.color = 'blue';
    } else {
      star.style.color = '';
    }
  });
}

// reset stars function
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

// function to display error
/*function errorMsg(element, text) {
  element.innerText = text;
}*/



/*
// form validation
submit_feedback_btn.addEventListener("click", (e) => {
  let text = document.querySelector("#feedback-text").value;

  let isValid = true;

  if (text.length <= 5) {
    errorMsg(textError, "الرجاء إدخال تعليق يحتوي على 6 أحرف على الأقل.");
    isValid = false;
  } else if (/^[0-9]*$/.test(text)) {
    errorMsg(textError, "الرجاء إدخال تعليق لا يحتوي على أرقام فقط.");
    isValid = false;
  } else if (/[^a-zA-Z0-9\s[\u0621-\u064A\s]+$]/.test(text)) {
    errorMsg(textError, "الرجاء إدخال تعليق بدون رموز خاصة.");
    isValid = false;
  } else {
    errorMsg(textError, "");
  }

  if (selectedRating === 0) {
    errorMsg(ratingError, "الرجاء تحديد التقييم باستخدام النجوم");
    isValid = false;
  } else {
    errorMsg(ratingError, "");
  }

  if (!isValid) e.preventDefault();
});
*/