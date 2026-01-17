const postCreationBtn = document.getElementById("create-post-btn");
const postsContainer = document.querySelector(".posts");
const postSubmitBtn = document.querySelector("#post-submit");
const textError = document.querySelector(".text-error");
const imageError = document.querySelector(".image-error");
const postText = document.querySelector("#post-form-text");
const postImage = document.querySelector("#post-img");

const postsArray = [];

function loadData() {
    fetch('../../components/actionMontada.php')
        .then(response => response.json())
        .then(data => {
            data.posts.forEach(row => {
                const likedPost = data.likedStatus.find(like => like.PostID == row.PostID);
                postsArray.push({
                    postID: row.PostID,
                    text: row.PostDescription,
                    imgLink: "../" + row.PostImage,
                    likesCounter: row.PostLikesCounter,
                    likedByme: likedPost ? true : false,
                    postDate: new Date(row.PostPublicationDate),
                });
            });
            postDisplay();
            console.log(postsArray);
        })
        .catch(error => {
            console.error('Error loading data:', error);
        });
}
loadData();

postCreationBtn.addEventListener("click", () => {
    document.getElementsByClassName("popUpPostForm")[0].style.display = "flex";
    document.body.style.overflow = 'auto';
});

document.querySelector("#cancel-post").addEventListener("click", () => {
    document.getElementsByClassName("popUpPostForm")[0].style.display = "none";
    document.body.style.overflow = 'auto';
    resetPostForm("#post-form-text", "#post-img", ".image-added");
});

function errorMsg(element, text) {
    element.innerText = text;
}

function resetForm() {
    postText.value = "";
    postImage.value = null;
    errorMsg(textError, "");
    errorMsg(imageError, "");
    resetPostForm("#post-form-text", "#post-img", ".image-added");
}

postSubmitBtn.addEventListener("click", (e) => {
    let isValid = true;

    if (postText.value.length <= 5) {
        errorMsg(textError, "الرجاء إدخال نص يحتوي على 6 أحرف على الأقل.");
        isValid = false;
    } else if (/^[0-9]*$/.test(postText.value)) {
        errorMsg(textError, "الرجاء إدخال نص لا يحتوي على أرقام فقط.");
        isValid = false;
    } else if (/[^a-zA-Z0-9\s[\u0621-\u064A\s]+$]/.test(postText.value)) {
        errorMsg(textError, "الرجاء إدخال نص بدون رموز خاصة.");
        isValid = false;
    } else {
        errorMsg(textError, "");
    }

    if (!postImage.files[0]) {
        errorMsg(imageError, "الرجاء تحميل صورة.");
        isValid = false;
    } else {
        errorMsg(imageError, "");
    }

    if (isValid) {
        const imageFile = postImage.files[0];
        const imagelink = URL.createObjectURL(imageFile);
        createPost(postText.value, imagelink);
        document.querySelector(".popUpPostForm").style.display = "none";
        document.body.style.overflow = "auto";
    } else {
        e.preventDefault();
    }
});

function createPost(newtext, imagelink) {
    let newPost = {
        text: newtext,
        imgLink: imagelink,
        likesCounter: 0,
        likedByme: false,
    };
    postsArray.unshift(newPost);
    postDisplay();
}

function postDisplay() {
    postsContainer.innerHTML = "";

    postsArray.forEach((post, index) => {
        const postClone = document.querySelector(".postClone").cloneNode(true);
        postClone.style.display = "block";

        postClone.querySelector(".post-image img").src = post.imgLink;
        postClone.querySelector(".post-text p").textContent = post.text;
        postClone.querySelector(".likes label span").textContent = post.likesCounter;

        const likeBtn = postClone.querySelector(".fa-heart");
        likeBtn.style.color = post.likedByme ? "red" : "white";
        likeBtn.dataset.index = index; // Attach index as a dataset property
        postClone.querySelector(".post-delete").dataset.index = index; // Attach index for delete button

        postsContainer.appendChild(postClone);
    });
    PostLikeUnLike();
}

function PostLikeUnLike() {
    const likeBtns = document.querySelectorAll(".fa-heart");
    likeBtns.forEach(likeBtn => {
        likeBtn.addEventListener("click", () => {
            const index = likeBtn.dataset.index; // Use dataset to get the correct index
            const post = postsArray[index];
            const isLiked = post.likedByme;

            if (!isLiked) {
                likeBtn.style.color = "red";
                likeBtn.parentNode.querySelector('span').innerText = Number(likeBtn.parentNode.querySelector('span').innerText) + 1;
                post.likedByme = true;
                post.likesCounter += 1;
            } else {
                likeBtn.style.color = "white";
                likeBtn.parentNode.querySelector('span').innerText = Number(likeBtn.parentNode.querySelector('span').innerText) - 1;
                post.likedByme = false;
                post.likesCounter -= 1;
            }

            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "../../components/actionMontada.php");
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(isLiked ? `UnLikedpostID=${post.postID}` : `LikedpostID=${post.postID}`);
        });
    });
}

function sortPostsByLikes() {
    postsArray.sort((a, b) => b.likesCounter - a.likesCounter);
    postDisplay();
}

function sortPostsByDate() {
    postsArray.sort((a, b) => b.postDate - a.postDate);
    postDisplay();
}

document.querySelector("#arrange-most-liked-btn").addEventListener("click", () => {
    sortPostsByLikes();
});

document.querySelector("#arrange-most-recent-btn").addEventListener("click", () => {
    sortPostsByDate();
});

const navigation_btns = document.querySelectorAll(".ul-hub-container li");
navigation_btns.forEach(button => {
    button.addEventListener("click", () => {
        if (window.innerWidth <= 768 && button !== postCreationBtn) {
            const posts_frame = document.querySelector(".hub-right-side");
            posts_frame.scrollIntoView({ behavior: "smooth" });
        }
    });
});

function postDelete() {
    postsContainer.addEventListener("click", (event) => {
        if (event.target.classList.contains("post-delete")) {
            const deletePopup = document.querySelector(".popUpDeleteForm");
            deletePopup.style.display = "flex";

            const postIndex = event.target.dataset.index; // Use dataset to get the correct index
            const cancelBtn = document.querySelector(".cancel-delete");
            const confirmBtn = document.querySelector(".confirm-delete");

            cancelBtn.onclick = () => {
                deletePopup.style.display = "none";
            };

            const postToBeDeleted = postsArray[postIndex].postID;
            confirmBtn.onclick = () => {
                fetch('../../components/actionMontadaAdmin.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'postToBeDeleted=' + encodeURIComponent(postToBeDeleted),
                })
                    .then(response => response.text())
                    .then(() => {
                        deletePopup.style.display = "none";
                        postsArray.splice(postIndex, 1);
                        postDisplay();
                    })
                    .catch(error => {
                        console.error('Error deleting post:', error);
                    });
            };
        }
    });
}

postDelete();
postDisplay();

postImage.addEventListener("change", () => {
    const imagePreview = document.querySelector(".image-added");

    if (postImage.files && postImage.files[0]) {
        const file = postImage.files[0];
        const fileURL = URL.createObjectURL(file);

        imagePreview.style.backgroundImage = `url(${fileURL})`;
        imagePreview.style.display = "block";
        errorMsg(imageError, "");
    } else {
        imagePreview.style.display = "none";
        errorMsg(imageError, "الرجاء تحميل صورة.");
    }
});

function resetPostForm(textInputSelector, imageInputSelector, imagePreviewSelector) {
    const textInput = document.querySelector(textInputSelector);
    if (textInput) {
        textInput.value = "";
    }

    const imageInput = document.querySelector(imageInputSelector);
    if (imageInput) {
        imageInput.value = null;
    }

    const imagePreview = document.querySelector(imagePreviewSelector);
    if (imagePreview) {
        imagePreview.style.backgroundImage = "none";
        imagePreview.style.display = "none";
    }
}
