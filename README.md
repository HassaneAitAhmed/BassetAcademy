# BassetAcademy

**Higher School of Artificial Intelligence, Algeria**  
*Supervised by: Professor Amir Djouama*

🔗 **Repository**: [https://github.com/ENSIA-AI/BassetAcademy](https://github.com/ENSIA-AI/BassetAcademy)

---

## Project Overview

BassetAcademy is an educational platform designed specifically for the famous Algerian math teacher, Abdelbasset. The website serves as a dedicated learning hub offering comprehensive paid courses, materials, and interactive tools. Students can access high-quality math lessons, resources like videos, images, PDFs, and benefit from features such as assignment submission, feedback, and rating services. The project aims to create an efficient digital learning space for students pursuing math education.

## How to Run the Project

### Prerequisites
- Download and install [XAMPP](https://www.apachefriends.org/download.html)

### Setup Instructions

1. **Clone or copy the project folder**
   - Place the `BassetAcademy` folder inside the XAMPP `htdocs` directory
   - Default path: `C:\xampp\htdocs\BassetAcademy`

2. **Start XAMPP**
   - Open the XAMPP Control Panel
   - Start the **Apache** module (click "Start" button)
   - Start the **MySQL** module (click "Start" button)

3. **Set up the Database**
   - Open your browser and go to `http://localhost/phpmyadmin`
   - Click on the **Import** tab
   - Browse and select the SQL file located at: `lib/BassetDBusedForPresentation.sql`
   - Click **Go** to import the database structure and data

4. **Access the Website**
   - Open your browser and navigate to: `http://localhost/BassetAcademy`
   - The website should now be running!

### Test Accounts
- **Admin**: admin2@gmail.com / Admin123*
- **Student**: adel@gmail.com / Adel123*
- **Student**: hassan@gmail.com / Hassane123*

## Services Provided

BassetAcademy offers the following key online services:

### Login and Registration Service
Students and teachers will have access to a secure login and registration process. This service will ensure account management and proper access control to courses and materials. New users can create accounts, and returning users can log in with their credentials.

### Subscription Service
Students will subscribe to courses by purchasing points. These points allow them to access premium content, including lessons, exercises, and supplementary materials. This system provides flexible payment options, ensuring ease of access based on student needs.

### Material (Course) Manipulation Service
This service allows teachers to manage course content. Teachers can create, update, and delete courses. They also have the ability to upload relevant materials, such as PDFs, videos, and other resources, ensuring that students always have access to updated learning tools.

### Assignment (Exam) Service
Teachers can assign tasks and exams (like midterms) to students. This service allows them to create, update, read, and delete assignments. It helps students to interact directly with course material through homework or tests, fostering better understanding and practice.

### Feedback and Rating Service
After completing courses or assignments, students can rate their experience and leave feedback about the quality of teaching or the course material. This will help other students in making informed decisions about courses and provide valuable feedback to teachers.

## Target Audience

### Individuals
- **Age-range**: Primarily targeted at high school students aged 15-19 and people who wants to study high school mathematics.
- **Gender**: the web application is directed to both men and women.
- **Country**: Most visitors will come from Algeria.
- **Location**: Users are likely to be from urban areas, where internet access is more reliable, although the platform will be accessible to anyone with internet.
- **Average income**: This platform will be directed to students from any range of income..
- **Education**: The target audience includes students at the secondary school level (high school), as well as some advanced middle school students or early university-level individuals.


## Key Motivations for Visiting the Website

- **Achieving Specific Goals**: Most visitors will come to the site with a clear goal: to improve their math skills or access valuable learning materials.
- **Personal Goals**: Students are motivated by personal academic success, often to achieve better grades or improve understanding of specific math topics.
- **Essential Activity**: Spending time on this platform is considered essential for students who are committed to advancing their education, particularly those preparing for high school exams or national assessments.


### What Visitors Are Trying to Achieve
Visitors, primarily high school students, are trying to:
- Improve their math skills through structured courses.
- Prepare for exams and tests.
- Complete assignments and homework.
- Access educational resources such as videos, PDFs, and interactive exercises.
- Receive feedback from teachers to improve performance.
- Provide ratings and feedback to help improve the course quality and guide future students.

### Key Tasks and Motivations
Key reasons why people visit the BassetAcademy website include:
- To access educational content such as math lessons, videos, and PDFs.
- To complete and submit assignments, exams, and other tasks set by the teacher.

## What Information Do Visitors Need to Achieve Their Goals?
Visitors need the following information to achieve their goals (Teacher will provide a video to explain how things works) :
- Clear instructions on how to subscribe and unlock content.
- Detailed descriptions of courses, including content, difficulty level, and outcomes.


## Site-map :

<img width="768" alt="BassetAcademy Site map" src="https://github.com/user-attachments/assets/b668d625-72cb-450b-a08e-ebfcf28fea83">

## Work Distribution For JAVASCRIPT Part.
### Garamida Abderraouf Adel :
- Sign In and Sign Up pages (Form validations)  (in SignIn.js and SignUp.js files).
- Hub (المنتدى) Page  (Post Creation Form and Filtering Posts according to most liked ones and Post deletion ...) (All js in Montada.js file)
- FeedBack form in Student Dashboard (Form for the Student to rate teacher) (Feedback-section.js file)
- Navigation Bar js (nav.js)
- Student Dashboard Design js (in Student-Dzshboard.js file)

### Hassane Ait Ahmed Lamara :
- contact-us in the end of the home page for the validation of email and name.
- Student Dashboard in the payement section.
- Revise Payment Information in the Teacher Dashboard.
- Student list in Teacher Dashboard.


### Mahi yahya abderrahmane :
- Adding client-side validation for input fields (e.g., text length, file type, and required selections) to prevent invalid submissions inside the admin dashborad.
- Enabled dynamic alert messages to inform users about the success or failure of their actions, with auto-dismissal for better usability.
- Implemented a search feature using JavaScript to allow admins to quickly find tutorials by their names.
- Dynamically loading and displaying tutorials, allowing admins to view and manage content effectively (eidt, delete tutorials) in the manage tutorial page.


## Work Distribution

### Home Page

- **Navigation Bar and Footer** (Garamida Abderraouf Adel): Dynamic Navigation Bar (for non-logged-in users, logged-in users, or Admin) and the web application footer.
  
- **Hero Section** (Hassane Ait Ahmed Lamara): Greets visitors with engaging visuals or messages, encouraging them to explore the site.

- **Courses Section** (Yahya Mehdi Abdrahman): Displays courses categorized by academic year (First Year, Second Year, Third Year), making it easy for students to navigate to the appropriate level.

- **Course Section** (Yahya Mehdi Abdrahman): Showcases courses available, organized within their respective details.

- **Wave Part** (Garamida Abderraouf Adel): A visually dynamic appealing wave design element to add flair and modern design to the homepage.

- **Reviews Section** (Hassane Ait Ahmed Lamara): User reviews displayed to enhance credibility and build trust in the platform.

- **Motivation Section** (Yahya Mehdi Abdrahman): A motivational section that encourages students to enroll, combined with a feedback form to gather inputs from users.
- 
- **ContactUs Section** (Hassane Ait Ahmed Lamara): A FeedBack Section Implemented a ContactUs form to gather user reviews and suggestions.
---

### Student Dashboard

- **Dashboard Design** (Garamida Abderraouf Adel): A personalized interface for students, allowing easy navigation of courses, materials, and other options.

- **Student Info Page** (Yahya Mehdi Abdrahman): Displays details of the student's personal and academic information.

- **Student Security Page** (Yahya Mehdi Abdrahman): Tracks and monitors student behavior for enhanced security.

- **Exam Reviews Table** (Garamida Abderraouf Adel): Displays details of exam dates, results, and marks.

- **Payment Section** (Hassane Ait Ahmed Lamara): Subscription (Buying Points) form.

- **Courses Section** (Hassane Ait Ahmed Lamara): Users can view and manage their enrolled courses here.

- **FeedBack Section** (Garamida Abderraouf Adel) : Form where user can rate the platform content.

---

### Admin Dashboard

- **Dashboard Design** (Yahya Mehdi Abdrahman): An interface displaying all course management operations (CRUD) and an overview of teacher-assigned courses.

- **Create Courses Section (CRUD)** (Yahya Mehdi Abdrahman): A dedicated page for creating and managing courses.

- **Courses Videos Section (CRUD)** (Hassane Ait Ahmed Lamara): Allows the admins to add, delete, or modify videos or course-related files.

---

### Course Details Section

- **Specific Course Description** (Garamida Abderraouf Adel & Hassane Ait Ahmed Lamara): Detailed view of a specific course, including materials and other relevant information (number of videos in the course, number of files, etc.).

- **Course Materials Section** (Yahya Mehdi Abdrahman): Displays various course resources, such as videos, documents, and exams.

---

### Sign in & Sign Up Pages (Garamida Abderraouf Adel)
Two separated pages that allow users to create an account or sign in as already registered users.

### Hub (Garamida Abderraouf Adel):
A Hub where teacher can upload posts to keep students updated and give them all latest news.

# BassetAcademy Backend

## Project Structure

The backend is organized by functionality and responsibility, with each team member assigned specific modules as outlined below:

### **Modules and Responsibilities**

#### 1. **Authentication and User Interaction**
   - **Garamida Abderraouf Adel**
     - **Login and Registration**: Handles user authentication and registration processes.
     - **Reviews and Messages**: Manages user reviews and messaging services.
     - **Hub (Posts Manipulation)**: Enables creation and deletion of posts within the platform.

#### 2. **Teacher Dashboard**
   - **Yahya Mehdi Abderahman**
     - **Courses Manipulation**: Manages course creation, updates, and deletions.
     - **Assignments Manipulation**: Allows teachers to manage student assignments and exams.

#### 3. **Student Dashboard**
   - **Hassan Ait Ahmed Lamara**
     - **Session Tracking**: Tracks students' learning sessions and course progress.
     - **Personal Information**: Handles updates to student profiles and personal data.
     - **Courses Management**: Facilitates students' access to subscribed courses.
     - **Subscription Management**: Manages course subscription processes for students.
     - **Exams and assignments Management**: Student uploaded answers and received exams and assignments.


 
