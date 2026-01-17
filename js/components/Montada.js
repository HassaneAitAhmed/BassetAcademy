const postsContainer = document.querySelector(".posts");
const postsArray = [];

// Load data from the server and populate the postsArray
function loadData() {
    fetch('../components/actionMontadaGuest.php')
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Data:", data);

            data.forEach(row => {
                postsArray.push({
                    text: row.PostDescription,
                    imgLink: row.PostImage,
                    likesCounter: row.PostLikesCounter,
                    likedByme: false,
                    postDate: new Date(row.PostPublicationDate),
                });
            });

            console.log("Updated Posts Array:", postsArray);
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
        likeBtn.dataset.index = index; // Attach index to identify the post

        likeBtn.addEventListener("click", () => {
            toggleLike(index, likeBtn);
        });

        postsContainer.appendChild(postClone);
    });
}

// Sort posts by likes (most liked first)
function sortPostsByLikes() {
    postsArray.sort((a, b) => b.likesCounter - a.likesCounter);
    postDisplay();
}

// Sort posts by date (most recent first)
function sortPostsByDate() {
    postsArray.sort((a, b) => b.postDate - a.postDate);
    postDisplay();
}

document.querySelector("#arrange-most-liked-btn").addEventListener("click", sortPostsByLikes);
document.querySelector("#arrange-most-recent-btn").addEventListener("click", sortPostsByDate);

// Navigation buttons for smaller screens
document.querySelectorAll(".ul-hub-container li").forEach(button => {
    button.addEventListener("click", () => {
        if (window.innerWidth <= 768) {
            const postsFrame = document.querySelector(".hub-right-side");
            postsFrame.scrollIntoView({ behavior: "smooth" });
        }
    });
});

// Initial display setup
postDisplay();
