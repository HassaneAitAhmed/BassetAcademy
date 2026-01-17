const postsContainer = document.querySelector(".posts");
const postText = document.querySelector("#post-form-text");
const postImage = document.querySelector("#post-img");

const postsArray = [];

function loadData() {
    fetch('../../components/actionMontada.php')
        .then(response => response.json())
        .then(data => {
            data.posts.forEach(row => {
                // Find if the post is liked by the user
                const likedPost = data.likedStatus.find(like => like.PostID == row.PostID);

                postsArray.push({
                    postID: row.PostID,
                    text: row.PostDescription,
                    imgLink: "../" + row.PostImage,
                    likesCounter: row.PostLikesCounter,
                    likedByme: likedPost ? true : false,
                    postDate: new Date(row.PostPublicationDate)
                });
            });
            postDisplay();
        })
        .catch(error => {
            console.error('Error loading data:', error);
        });
}
loadData();

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
        likeBtn.dataset.index = index; // Attach index as a dataset property for easy reference
        postsContainer.appendChild(postClone);
    });

    PostLikeUnLike(); // Rebind event listeners after displaying posts
}

function PostLikeUnLike() {
    const likeBtns = document.querySelectorAll(".fa-heart");
    likeBtns.forEach(likeBtn => {
        likeBtn.addEventListener("click", () => {
            const index = likeBtn.dataset.index; // Get the correct index
            const post = postsArray[index];
            const isLiked = post.likedByme;

            // Updating UI
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

            // Update Database
            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "../../components/actionMontada.php");
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(isLiked ? `UnLikedpostID=${post.postID}` : `LikedpostID=${post.postID}`);
        });
    });
}

// Filter Posts by likes (most liked posts first)
const mostLikedBtn = document.querySelector("#arrange-most-liked-btn");
mostLikedBtn.addEventListener("click", () => {
    sortPostsByLikes();
});

function sortPostsByLikes() {
    postsArray.sort((a, b) => b.likesCounter - a.likesCounter);
    postDisplay();
}

// Filter Posts by date (most recent posts first)
function sortPostsByDate() {
    postsArray.sort((a, b) => b.postDate - a.postDate); // Sort in descending order based on the date
    postDisplay();
}

const recentPostsLi = document.querySelector("#arrange-most-recent-btn");
recentPostsLi.addEventListener("click", () => {
    sortPostsByDate();
});

// Function to scroll to post when clicking on any item in the list 
const navigationBtns = document.querySelectorAll(".ul-hub-container li");
navigationBtns.forEach((button) => {
    button.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
            const postsFrame = document.querySelector(".hub-right-side");
            postsFrame.scrollIntoView({ behavior: "smooth" });
        }
    });
});

// Initialize by sorting posts by date
sortPostsByDate();
