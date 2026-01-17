CREATE TABLE User (
  UserID INT PRIMARY KEY AUTO_INCREMENT,
  User_Email VARCHAR(100) UNIQUE NOT NULL,
  User_Password VARCHAR(255) NOT NULL,
  `Role` VARCHAR(10) NOT NULL CHECK (Role IN ('Student', 'Admin')),
  User_FirstName VARCHAR(100),
  User_LastName VARCHAR(100),
  User_Phone VARCHAR(15),
  User_Branch VARCHAR(100) CHECK (User_Branch IN ('ST', 'MT', 'ML')),
  User_Level VARCHAR(100) CHECK (User_Level IN ('1AS', '2AS', '3AS')),
  User_Points INT DEFAULT 0 CHECK (User_Points >= 0)
);

CREATE TABLE Course (
  CourseID INT PRIMARY KEY AUTO_INCREMENT,
  Course_title VARCHAR(100) NOT NULL,
  Course_description TEXT,
  Course_image VARCHAR(255),
  semester VARCHAR(100) CHECK (semester IN ('S1', 'S2', 'S3')),
  price INT,
  UserID INT,
  CONSTRAINT fk_Course_UserID FOREIGN KEY (UserID) REFERENCES User (UserID) ON DELETE CASCADE
);

CREATE TABLE Tasks (
  TaskID INT PRIMARY KEY AUTO_INCREMENT,
  UserID INT,
  course_ID INT,
  Task_title VARCHAR(100),
  Task_description VARCHAR(100),
  Task_file TEXT,
  Task_solution TEXT,
  DueDate DATE,
  Type VARCHAR(50),
  CONSTRAINT fk_Tasks_CourseID FOREIGN KEY (course_ID) REFERENCES Course (CourseID) ON DELETE CASCADE,
  CONSTRAINT fk_Tasks_UserID FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE StudentTasks (
  TaskID INT,
  StudentID INT,
  CourseID INT,
  stud_solution TEXT,
  AssessmentStatus VARCHAR(100),
  AssessmentDate DATE,
  AssessmentScore INT,
  PRIMARY KEY (TaskID, StudentID,CourseID),
  CONSTRAINT fk_StudentTasks_TaskID FOREIGN KEY (TaskID) REFERENCES Tasks (TaskID) ON DELETE CASCADE,
  CONSTRAINT fk_StudentTasks_StudentID FOREIGN KEY (StudentID) REFERENCES User (UserID),
  CONSTRAINT fk_StudentTasks_CourseID FOREIGN KEY (CourseID) REFERENCES Course (CourseID)
);

CREATE TABLE StudentCourse (
  CourseID INT,
  UserID INT,
  `Status` VARCHAR(100) CHECK (`Status` IN ('ACTIVE', 'NOTACTIVE')),
  PRIMARY KEY (CourseID, UserID),
  CONSTRAINT fk_StudentCourse_CourseID FOREIGN KEY (CourseID) REFERENCES Course (CourseID) ON DELETE CASCADE,
  CONSTRAINT fk_StudentCourse_UserID FOREIGN KEY (UserID) REFERENCES User (UserID) ON DELETE CASCADE
);

CREATE TABLE StudentSecurity (
  studSecuID INT PRIMARY KEY AUTO_INCREMENT,
  UserID INT,
  devicetype VARCHAR(100),
  devicename VARCHAR(100),
  deviceoperator VARCHAR(100),
  browser VARCHAR(100),
  logtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_StudentSecurity_UserID FOREIGN KEY (UserID) REFERENCES User (UserID) ON DELETE CASCADE
);

CREATE TABLE Post (
  PostID INT PRIMARY KEY AUTO_INCREMENT,
  PostDescription TEXT,
  PostLikesCounter INT DEFAULT 0,
  PostStatus VARCHAR(100) NOT NULL CHECK (PostStatus IN ('ACTIVE', 'DELETED')),
  PostImage VARCHAR(255),
  PostPublicationDate DATE NOT NULL,
  UserID INT,
  CONSTRAINT fk_Post_UserID FOREIGN KEY (UserID) REFERENCES User (UserID) ON DELETE CASCADE
);

CREATE TABLE StudentPost (
  PostID INT,
  UserID INT,
  PRIMARY KEY (PostID, UserID),
  CONSTRAINT fk_StudentPost_PostID FOREIGN KEY (PostID) REFERENCES Post (PostID),
  CONSTRAINT fk_StudentPost_UserID FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE Message (
  MessageID INT PRIMARY KEY AUTO_INCREMENT,
  UserName VARCHAR(100),
  UserEmail VARCHAR(255),
  MessageContent TEXT,
  MessageStatus VARCHAR(100) CHECK (MessageStatus IN ('READ', 'NOTREAD')),
  UserID INT,
  CONSTRAINT fk_Message_UserID FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE Feedback (
  FeedbackID INT PRIMARY KEY AUTO_INCREMENT,
  UserID INT,
  FeedbackContent TEXT,
  Rating INT CHECK (Rating BETWEEN 1 AND 5),
  FeedbackSendDate DATE,
  CONSTRAINT fk_Feedback_UserID FOREIGN KEY (UserID) REFERENCES User (UserID)
);

CREATE TABLE CourseSummarize (
  summarizeID INT AUTO_INCREMENT,
  summary_content VARCHAR(5000),
  CourseID INT,
  PRIMARY KEY (summarizeID),
  CONSTRAINT fk_CourseSummarize_CourseID FOREIGN KEY (CourseID) REFERENCES Course (CourseID) ON DELETE CASCADE
);

CREATE TABLE Tutorials (
  tutorial_ID INT PRIMARY KEY AUTO_INCREMENT,
  tutorial_title VARCHAR(100),
  tutorial_description VARCHAR(100),
  course_ID INT,
  tutorial_video VARCHAR(100),
  UserID INT,
  CONSTRAINT fk_Tutorials_UserID FOREIGN KEY (UserID) REFERENCES User (UserID),
  CONSTRAINT fk_Tutorials_CourseID FOREIGN KEY (course_ID) REFERENCES Course (CourseID) ON DELETE CASCADE
);

CREATE TABLE TutorialMaterials (
  MaterialID INT AUTO_INCREMENT,
  Material_content VARCHAR(5000),
  tutorial_ID INT,
  PRIMARY KEY (MaterialID),
  CONSTRAINT fk_TutorialMaterials_tutorial_ID FOREIGN KEY (tutorial_ID) REFERENCES Tutorials(tutorial_ID) ON DELETE CASCADE
);

CREATE TABLE TutorialSummary (
  SummaryID INT AUTO_INCREMENT,
  summary_content VARCHAR(5000),
  tutorial_ID INT,
  PRIMARY KEY (SummaryID),
  CONSTRAINT fk_TutorialSummary_tutorial_ID FOREIGN KEY (tutorial_ID) REFERENCES Tutorials(tutorial_ID) ON DELETE CASCADE
);

CREATE TABLE Payement (
  PayementID INT PRIMARY KEY AUTO_INCREMENT,
  StudentID INT,
  Payementphoto VARCHAR(255),
  Payementvalue VARCHAR(100),
  PaymentStatus VARCHAR(100),
  payment_date date,
  AdminID INT,
  CONSTRAINT fk_Payment_StudentID FOREIGN KEY (StudentID) REFERENCES User (UserID),
  CONSTRAINT fk_Payment_AdminID FOREIGN KEY (AdminID) REFERENCES User (UserID)
);

CREATE TABLE Password_reset_codes (
    PassID INT AUTO_INCREMENT PRIMARY KEY,
    UserID INT NOT NULL,
    Code VARCHAR(6) NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID)
);