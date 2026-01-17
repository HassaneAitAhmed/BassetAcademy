const tutorials = [
    {
        id: 1,
        title: "1AS - دورة الاشتقااقية",
        description: ":عند اشتراكك في هذه الدورة ستجد",
        features: [
            "دروس الفصل الأول مشروحة و ملخصة",
            "تمارين و ملخصات PDF ملحولة و مفصلة",
            "حصص مباشرة للمناقشة و حل المواضيع",
            "مراجعات خاصة بالاختبارات و الفروض"
        ],
        image: "../assets/images/year1-derivative.jpg"
    },
    {
        id: 2,
        title: "1AS - الفصل المتتاليات",
        description: ":عند اشتراكك في هذه الدورة ستجد",
        features: [
            "دروس الفصل الأول مشروحة و ملخصة",
            "تمارين و ملخصات PDF ملحولة و مفصلة",
            "حصص مباشرة للمناقشة و حل المواضيع",
            "مراجعات خاصة بالاختبارات و الفروض"
        ],
        image: "../assets/images/year1-sequence.jpg"
    },
    {
        id: 3,
        title: "1AS - دورة الدوال",
        description: ":عند اشتراكك في هذه الدورة ستجد",
        features: [
            "دروس الفصل الأول مشروحة و ملخصة",
            "تمارين و ملخصات PDF ملحولة و مفصلة",
            "حصص مباشرة للمناقشة و حل المواضيع",
            "مراجعات خاصة بالاختبارات و الفروض"
        ],
        image: "../assets/images/year1-functions.jpg"
    },
];

const tutorialsContainer = document.getElementById("tutorialsContainer");
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const modal = document.getElementById("editModal");
const closeModal = document.querySelector(".close");
const editForm = document.getElementById("editForm");

let editingTutorialId = null;

function renderTutorials(data) {
    tutorialsContainer.innerHTML = "";
    data.forEach(tutorial => {
        const card = document.createElement("div");
        card.className = "tutorial card";
        card.innerHTML = `
            <div class="image_container">
                <img src="${tutorial.image}" alt="${tutorial.title}">
            </div>
            <h1>${tutorial.title}</h1>
            <hr>
            <p>${tutorial.description}</p>
            <ul>
                ${tutorial.features.map(feature => `<li><i class="fas fa-check-circle"></i> ${feature}</li>`).join("")}
            </ul>
            <div class="subscription">
                <button class="edit" onclick="openEditModal(${tutorial.id})">Edit</button>
                <button class="remove" onclick="deleteTutorial(${tutorial.id})">Delete</button>
            </div>
        `;
        tutorialsContainer.appendChild(card);
    });
}

function openEditModal(id) {
    const tutorial = tutorials.find(t => t.id === id);
    editingTutorialId = id;
    document.getElementById("title").value = tutorial.title;
    document.getElementById("description").value = tutorial.description;
    modal.style.display = "flex";
}

editForm.addEventListener("submit", (e) => {
    e.preventDefault();
    const tutorial = tutorials.find(t => t.id === editingTutorialId);
    tutorial.title = document.getElementById("title").value;
    tutorial.description = document.getElementById("description").value;
    modal.style.display = "none";
    renderTutorials(tutorials);
});

function closeEditModal() {
    modal.style.display = "none";
}

document.getElementById("cancelBtn").addEventListener("click", closeEditModal);




function deleteTutorial(id) {
    const confirmed = confirm("Are you sure you want to delete this tutorial?");
    if (confirmed) {
        const index = tutorials.findIndex(t => t.id === id);
        if (index !== -1) tutorials.splice(index, 1);
        renderTutorials(tutorials);
        alert("Tutorial deleted successfully!");
    }
}

searchBtn.addEventListener("click", () => {
    const query = searchInput.value.toLowerCase();
    const filtered = tutorials.filter(t => t.title.toLowerCase().includes(query));
    renderTutorials(filtered);
});

closeModal.addEventListener("click", () => {
    modal.style.display = "none";
});

renderTutorials(tutorials);
