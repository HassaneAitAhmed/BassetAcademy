-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2025 at 10:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bassetdb`
--
CREATE DATABASE IF NOT EXISTS `bassetdb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bassetdb`;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `Course_title` varchar(100) NOT NULL,
  `Course_description` text DEFAULT NULL,
  `Course_image` varchar(255) DEFAULT NULL,
  `semester` varchar(100) DEFAULT NULL CHECK (`semester` in ('S1','S2','S3')),
  `price` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `Course_title`, `Course_description`, `Course_image`, `semester`, `price`, `UserID`) VALUES
(5, 'الدالة الأسية', 'في هذه الوحدة سنتطرق إلى:تعريف واضح ومبسط للدالة الأسية وفهم صيغتها العامة.شرح خصائص الدوال الأسية مثل النمو الأسي والتغيرات الناتجة عن قاعدة الأس.دراسة العلاقات بين الدالة الأسية والدوال اللوغاريتمية.استعراض تطبيقات عملية على الدوال الأسية في المجالات العلمية والحياتية.حل أكثر من 15 تمريناً ونموذج امتحان يشمل مختلف المستويات المتعلقة بالدوال الأسية.تقديم محاضرات مسجلة وأخرى مباشرة لتوضيح النقاط الصعبة ودعم الفهم.تقييم مستوى تقدمك من خلال اختبارات دورية قصيرة.هدفنا هو التأكد من فهمك الكامل للدوال الأسية وقدرتك على تطبيقها في الامتحانات والمسائل المعقدة.', 'uploads/images/677d215a02f709.41666144.jpg', 'S3', 2200, 5),
(6, 'الاحتمالات', 'في هذه الوحدة سنتطرق إلى:\r\n\r\nتعريف الاحتمالات وفهم مفهوم التجربة العشوائية.\r\nشرح المسلمات الأساسية للاحتمالات وقواعدها.\r\nدراسة مفهوم فضاء العينة والأحداث وكيفية تمثيلها.\r\nتحليل قوانين الاحتمالات مثل مجموع الأحداث وحاصل الضرب.\r\nاستعراض الأمثلة العملية لحساب الاحتمالات في مواقف مختلفة.\r\nشرح الاحتمالات المشروطة ومستقلات الأحداث.\r\nحل أكثر من 20 تمريناً ونماذج امتحانات مرتبطة بموضوع الاحتمالات.\r\nتقديم محاضرات مباشرة ومسجلة لتوضيح المفاهيم بأسلوب مبسط ودقيق.\r\nتقديم اختبارات تقييم شبه أسبوعية لمتابعة مستوى تقدمك.\r\nهدفنا هو الوصول بك إلى مستوى يمكّنك من حل أي مسألة احتمالية مهما كانت معقدة.', 'uploads/images/677d219017a665.11663106.jpg', 'S3', 1500, 5),
(7, 'المتتاليات', 'تعريف المتتاليات العددية ومفهوم الحد النوني.\r\nدراسة أنواع المتتاليات: المتتالية الحسابية، والهندسية، والمتتاليات العامة.\r\nشرح القوانين الأساسية لحساب الحدود والمجموعات.\r\nفهم خواص التزايد، التناقص، وحدود التقارب للمتتاليات.\r\nتطبيقات المتتاليات في الحسابات والحياة اليومية.\r\nحل أكثر من 25 تمريناً ونماذج امتحانات شاملة حول المتتاليات.\r\nتقديم شروحات مباشرة ومسجلة لجميع أنواع المتتاليات مع أمثلة عملية.\r\nإجراء اختبارات دورية لتقييم تقدمك في فهم المادة.\r\nهدفنا هو بناء قاعدة معرفية متينة تجعلك قادراً على التعامل مع أي مسألة أو تمرين متعلق بالمتتاليات بسهولة وكفاءة.', 'uploads/images/year3-sequence.jpg', 'S3', 500, 5),
(8, 'المعادلات الخطية والمتراجحات', 'في هذه الدورة سنتطرق إلى:\r\n\r\nتعريف المعادلة والمتراجحة وتمييز الفرق بينهما.\r\nدراسة طرق حل المعادلات الخطية بأنواعها.\r\nاستعراض طرق حل المتراجحات الخطية بأسلوب مبسط.\r\nحل أنظمة المعادلات الخطية باستخدام طريقة التعويض وطريقة الحذف.\r\nتقديم تمارين تطبيقية ونماذج امتحانات لتعزيز المهارات المكتسبة.\r\nالتركيز على الفهم التطبيقي وربط المادة بحل المسائل العلمية.\r\nمتابعة تقدم الطلاب عبر اختبارات قصيرة لتقييم المهارات.', 'uploads/images/year2-angle.jpg', 'S1', 800, 5),
(9, 'النهايات', 'في هذه الدورة سنتطرق إلى:\r\n\r\nتعريف النهاية ومفهوم الاقتراب للقيم العددية.\r\nدراسة الخواص والقوانين الأساسية للنهايات.\r\nشرح النظريات المتعلقة بالاتصال ومعنى دالة متصلة.\r\nتطبيق النهايات والاتصال في دراسة التغيرات ومعدل النمو.\r\nحل تمارين متنوعة حول حساب النهايات وحالات عدم التعيين.\r\nتقديم أمثلة من الحياة الواقعية لشرح التطبيقات العملية للنهايات.\r\nمتابعة الأداء من خلال امتحانات قصيرة ومراجعات شاملة.', 'uploads/images/year1-functions.jpg', 'S2', 1500, 5);

-- --------------------------------------------------------

--
-- Table structure for table `coursesummarize`
--

CREATE TABLE `coursesummarize` (
  `summarizeID` int(11) NOT NULL,
  `summary_content` varchar(5000) DEFAULT NULL,
  `CourseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coursesummarize`
--

INSERT INTO `coursesummarize` (`summarizeID`, `summary_content`, `CourseID`) VALUES
(1, 'uploads/summaries/expf.pdf', 5),
(2, 'uploads/summaries/dzexams-docs-3as-903987.pdf', 6),
(3, 'uploads/summaries/dzexams-docs-2as-900606.pdf', 7);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `FeedbackContent` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 5),
  `FeedbackSendDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `MessageID` int(11) NOT NULL,
  `UserName` varchar(100) DEFAULT NULL,
  `UserEmail` varchar(255) DEFAULT NULL,
  `MessageContent` text DEFAULT NULL,
  `MessageStatus` varchar(100) DEFAULT NULL CHECK (`MessageStatus` in ('READ','NOTREAD')),
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_codes`
--

CREATE TABLE `password_reset_codes` (
  `PassID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Code` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payement`
--

CREATE TABLE `payement` (
  `PayementID` int(11) NOT NULL,
  `StudentID` int(11) DEFAULT NULL,
  `Payementphoto` varchar(255) DEFAULT NULL,
  `Payementvalue` varchar(100) DEFAULT NULL,
  `PaymentStatus` varchar(100) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payement`
--

INSERT INTO `payement` (`PayementID`, `StudentID`, `Payementphoto`, `Payementvalue`, `PaymentStatus`, `payment_date`, `AdminID`) VALUES
(1, 3, '677d2e7ca1d20.jpg', '5000', 'accepted', '2025-01-07', NULL),
(2, 3, '677d2ec82d6aa.jpg', '5000', 'Pending', '2025-01-07', NULL),
(3, 4, '677d2fd13cc07.jpg', '5000', 'accepted', '2025-01-07', NULL),
(4, 4, '677d2fd824bba.jpg', '5000', 'Pending', '2025-01-07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `PostID` int(11) NOT NULL,
  `PostDescription` text DEFAULT NULL,
  `PostLikesCounter` int(11) DEFAULT 0,
  `PostStatus` varchar(100) NOT NULL CHECK (`PostStatus` in ('ACTIVE','DELETED')),
  `PostImage` varchar(255) DEFAULT NULL,
  `PostPublicationDate` date NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`PostID`, `PostDescription`, `PostLikesCounter`, `PostStatus`, `PostImage`, `PostPublicationDate`, `UserID`) VALUES
(1, 'يسرنا أن نعلن أنه تم إضافة دورة \"الدالة الأسية\" إلى موقعنا. استفيدوا من محتواها الغني والمهم تحت إشراف الأستاذ عبد الباسط لتعزيز معرفتكم وفهمكم في هذا الموضوع الحيوي.', 1, 'ACTIVE', '../assets/images/677d215a02f709.41666144.jpg', '2025-01-07', 2),
(2, 'نود إعلامكم بإضافة دورة \"الاحتمالات\" إلى موقعنا. اغتنموا الفرصة للاستفادة من المحتوى القيم والمفيد تحت إشراف الأستاذ عبد الباسط، لتطوير مهاراتكم وفهمكم في هذا المجال الأساسي.', 1, 'ACTIVE', '../assets/images/677d219017a665.11663106.jpg', '2025-01-07', 2),
(3, 'ترقبوا مفاجأة هذا الفصل الدراسي قريبًا جدًا! تابعونا لتكونوا أول من يعرف التفاصيل.', 2, 'ACTIVE', '../assets/images/677d21d741ca30.11108403.jpg', '2025-01-07', 2);

-- --------------------------------------------------------

--
-- Table structure for table `studentcourse`
--

CREATE TABLE `studentcourse` (
  `CourseID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Status` varchar(100) DEFAULT NULL CHECK (`Status` in ('ACTIVE','NOTACTIVE'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentcourse`
--

INSERT INTO `studentcourse` (`CourseID`, `UserID`, `Status`) VALUES
(5, 3, 'ACTIVE'),
(7, 3, 'ACTIVE'),
(9, 3, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `studentpost`
--

CREATE TABLE `studentpost` (
  `PostID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentpost`
--

INSERT INTO `studentpost` (`PostID`, `UserID`) VALUES
(1, 2),
(2, 5),
(3, 2),
(3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `studentsecurity`
--

CREATE TABLE `studentsecurity` (
  `studSecuID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `devicetype` varchar(100) DEFAULT NULL,
  `devicename` varchar(100) DEFAULT NULL,
  `deviceoperator` varchar(100) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `logtime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentsecurity`
--

INSERT INTO `studentsecurity` (`studSecuID`, `UserID`, `devicetype`, `devicename`, `deviceoperator`, `browser`, `logtime`) VALUES
(1, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 12:39:12'),
(2, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:36:37'),
(3, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:39:56'),
(4, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:42:15'),
(5, 4, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:43:26'),
(6, 2, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:52:47'),
(7, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:57:51'),
(8, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 13:58:55'),
(9, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 14:05:41'),
(10, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 14:16:19'),
(11, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-07 15:22:28'),
(12, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 17:30:43'),
(13, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 17:42:09'),
(14, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 21:10:16'),
(15, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 21:16:39'),
(16, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 21:17:59'),
(17, 5, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 21:18:16'),
(18, 3, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Sa', 'Desktop', 'Windows', 'Chrome', '2025-01-08 21:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `studenttasks`
--

CREATE TABLE `studenttasks` (
  `TaskID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `CourseID` int(11) NOT NULL,
  `stud_solution` text DEFAULT NULL,
  `AssessmentStatus` varchar(100) DEFAULT NULL,
  `AssessmentDate` date DEFAULT NULL,
  `AssessmentScore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `TaskID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `course_ID` int(11) DEFAULT NULL,
  `Task_title` varchar(100) DEFAULT NULL,
  `Task_description` varchar(100) DEFAULT NULL,
  `Task_file` text DEFAULT NULL,
  `Task_solution` text DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`TaskID`, `UserID`, `course_ID`, `Task_title`, `Task_description`, `Task_file`, `Task_solution`, `DueDate`, `Type`) VALUES
(1, 5, 6, 'test', 'test', 'uploads/677eba4c0286b_2-ENSIA 2024-2025 Worksheet 2 (1).pdf', 'uploads/677eba4c02abb_DSA2_chapter 7_Sorting(part1) (1).pdf', '2025-01-16', 'assignment'),
(2, 5, 7, 'testqwer', 'rwrwq', 'uploads/677eba8a9370a_Y2_DSA2_Tutorial 6_2024.docx (1).pdf', 'uploads/677eba8a939e9_2-ENSIA 2024-2025 Worksheet 2 (1).pdf', '2025-01-21', 'exam'),
(3, 5, 6, 'إمتحان شامل في وحدة الاحتمالات', 'يختبر هذا الامتحان جميع المفاهيم التي تمت دراستها في وحدة الاحتمالات. يشمل تعريف الاحتمالات، قوانينه', 'uploads/677ee872aec44_dzexams-docs-3as-904742.pdf', 'uploads/677ee872aef12_dzexams-docs-3as-907501.pdf', '2025-01-15', 'exam'),
(4, 5, 7, 'إمتحان شامل في وحدة المتتاليات', 'يغطي هذا الامتحان كافة المفاهيم المتعلقة بوحدة المتتاليات. يشمل تعريف المتتاليات العددية، الحد النون', 'uploads/677ee88e1d2ee_dzexams-docs-3as-904742.pdf', 'uploads/677ee88e1dca1_dzexams-docs-3as-907501.pdf', '2025-01-14', 'exam'),
(5, 5, 5, 'إمتحان شامل في وحدة الدالة الأسية', 'يتناول هذا الامتحان جميع الجوانب المتعلقة بالدالة الأسية. يبدأ بأسئلة عن تعريف الدالة الأسية وصيغتها', 'uploads/677ee8a6cee60_dzexams-docs-3as-904742.pdf', 'uploads/677ee8a6cf25e_dzexams-docs-3as-907501.pdf', '2025-01-17', 'exam'),
(6, 5, 7, 'تقويم حول المجاميع في وحدة المتتاليات', 'يركز هذا التقويم على اختبار فهمك للمفاهيم المتعلقة بحساب المجاميع في وحدة المتتاليات. يشمل أسئلة حول', 'uploads/677ee95496fdd_dzexams-docs-3as-904742.pdf', 'uploads/677ee954972fe_dzexams-docs-3as-907501.pdf', '2025-01-23', 'assignment'),
(7, 5, 5, 'تقويم تدريبي حول النهايات في الدول الأسية', 'يهدف هذا التقويم إلى قياس مدى استيعابك لمفهوم النهايات وتطبيقها في الدوال الأسية. يتضمن أسئلة حول حس', 'uploads/677ee97a7fbdb_dzexams-docs-3as-904742.pdf', 'uploads/677ee97a7fe9f_dzexams-docs-3as-907501.pdf', '2025-01-24', 'assignment');

-- --------------------------------------------------------

--
-- Table structure for table `tutorialmaterials`
--

CREATE TABLE `tutorialmaterials` (
  `MaterialID` int(11) NOT NULL,
  `Material_content` varchar(5000) DEFAULT NULL,
  `tutorial_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorialmaterials`
--

INSERT INTO `tutorialmaterials` (`MaterialID`, `Material_content`, `tutorial_ID`) VALUES
(2, 'uploads/materials/dzexams-docs-3as-907501.pdf', 2),
(3, 'uploads/materials/dzexams-docs-3as-907500.pdf', 2),
(4, 'uploads/materials/dzexams-docs-3as-907499.pdf', 2),
(5, 'uploads/materials/dzexams-docs-3as-904742.pdf', 2),
(6, 'uploads/materials/dzexams-docs-3as-907501.pdf', 3),
(7, 'uploads/materials/dzexams-docs-3as-907500.pdf', 3),
(8, 'uploads/materials/dzexams-docs-3as-907499.pdf', 3),
(9, 'uploads/materials/dzexams-docs-3as-907501.pdf', 4),
(10, 'uploads/materials/dzexams-docs-3as-907501.pdf', 5),
(11, 'uploads/materials/dzexams-docs-3as-907500.pdf', 6),
(12, 'uploads/materials/dzexams-docs-3as-907499.pdf', 6),
(13, 'uploads/materials/dzexams-docs-3as-907500.pdf', 7),
(14, 'uploads/materials/dzexams-docs-3as-907499.pdf', 8),
(15, 'uploads/materials/dzexams-docs-3as-904742.pdf', 8),
(16, 'uploads/materials/dzexams-docs-3as-907501.pdf', 9),
(17, 'uploads/materials/dzexams-docs-3as-907500.pdf', 9),
(18, 'uploads/materials/dzexams-docs-3as-907501.pdf', 10),
(19, 'uploads/materials/dzexams-docs-3as-904742.pdf', 11),
(20, 'uploads/materials/Exercices-Variables-aleatoires-a-densite.pdf', 11),
(21, 'uploads/materials/dzexams-docs-3as-907500.pdf', 12);

-- --------------------------------------------------------

--
-- Table structure for table `tutorials`
--

CREATE TABLE `tutorials` (
  `tutorial_ID` int(11) NOT NULL,
  `tutorial_title` varchar(100) DEFAULT NULL,
  `tutorial_description` varchar(100) DEFAULT NULL,
  `course_ID` int(11) DEFAULT NULL,
  `tutorial_video` varchar(100) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorials`
--

INSERT INTO `tutorials` (`tutorial_ID`, `tutorial_title`, `tutorial_description`, `course_ID`, `tutorial_video`, `UserID`) VALUES
(2, 'مقدمة إلى الدالة الأسية', 'في هذا الفصل، سنتعرف على المفهوم الأساسي للدالة الأسية وصيغتها العامة. سنستعرض أصول هذه الدالة وأهمي', 5, 'uploads/videos/yt1z.net - مراجعة اختبارات الفصل الأول 🔥.mp4', 5),
(3, 'خصائص الدوال الأسية', 'نناقش في هذا الفصل الخصائص الأساسية للدوال الأسية، مثل النمو الأسي، تغيرات القيم بناءً على قاعدة الأ', 5, 'uploads/videos/yt1z.net - التعريف بفكرة سلسلة أساسيات الرياضيات.mp4', 5),
(4, 'العلاقة بين الدوال الأسية واللوغاريتمية', 'سنتناول في هذا الفصل العلاقة الوثيقة بين الدوال الأسية والدوال اللوغاريتمية. ستتعلم كيفية الانتقال ب', 5, 'uploads/videos/yt1z.net - أقوى تحضير للباكالوريا التجريبية 2024 عبر قناة الأستاذ عبد الباسط 🔥.mp4', 5),
(5, 'مقدمة إلى الاحتمالات', 'في هذا الفصل، سنتعرف على مفهوم الاحتمالات بشكل عام، ونفهم أساسيات التجربة العشوائية. ستبدأ رحلتك مع ', 6, 'uploads/videos/yt1z.net - مراجعة اختبارات الفصل الأول 🔥.mp4', 5),
(6, ' المسلمات الأساسية وقواعد الاحتمالات', 'يشرح هذا الفصل المسلمات الأساسية التي تقوم عليها الاحتمالات، بالإضافة إلى القواعد الرئيسية مثل قاعدة', 6, 'uploads/videos/yt1z.net - أقوى تحضير للباكالوريا التجريبية 2024 عبر قناة الأستاذ عبد الباسط 🔥.mp4', 5),
(7, 'مفهوم النهاية والاقتراب', 'في هذا الفصل، نتعرف على تعريف النهاية ومفهوم الاقتراب من القيم العددية. ستتعلم كيف تقترب الدوال من ق', 9, 'uploads/videos/yt1z.net - مراجعة اختبارات الفصل الأول 🔥.mp4', 5),
(8, 'الخواص والقوانين الأساسية للنهايات', 'يشرح هذا الفصل القواعد والخواص الأساسية للنهايات، مثل الجمع، الطرح، الضرب، والقسمة. ستتعرف على كيفية', 9, 'uploads/videos/yt1z.net - أقوى تحضير للباكالوريا التجريبية 2024 عبر قناة الأستاذ عبد الباسط 🔥.mp4', 5),
(9, 'تعريف المعادلة والمتراجحة والفرق بينهما', 'في هذا الفصل، سنتعرف على مفهوم المعادلة والمتراجحة مع توضيح الفرق بينهما. ستتعلم الأساسيات اللازمة ل', 8, 'uploads/videos/yt1z.net - التعريف بفكرة سلسلة أساسيات الرياضيات.mp4', 5),
(10, 'طرق حل المعادلات الخطية', 'يُركز هذا الفصل على دراسة الطرق المختلفة لحل المعادلات الخطية بأنواعها، مثل المعادلات ذات المتغير ال', 8, 'uploads/videos/yt1z.net - التعريف بفكرة سلسلة أساسيات الرياضيات.mp4', 5),
(11, 'تعريف المتتاليات العددية ومفهوم الحد النوني', 'في هذا الفصل، سنتعرف على المتتاليات العددية ونشرح مفهوم الحد النوني. ستتعلم كيف تُعرّف المتتاليات ري', 7, 'uploads/videos/yt1z.net - أقوى تحضير للباكالوريا التجريبية 2024 عبر قناة الأستاذ عبد الباسط 🔥.mp4', 5),
(12, 'أنواع المتتاليات: الحسابية والهندسية والعامة', 'يركز هذا الفصل على تصنيف المتتاليات إلى متتاليات حسابية، هندسية، وعامة. ستتعرف على الفروقات بين هذه ', 7, 'uploads/videos/yt1z.net - التعريف بفكرة سلسلة أساسيات الرياضيات.mp4', 5);

-- --------------------------------------------------------

--
-- Table structure for table `tutorialsummary`
--

CREATE TABLE `tutorialsummary` (
  `SummaryID` int(11) NOT NULL,
  `summary_content` varchar(5000) DEFAULT NULL,
  `tutorial_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tutorialsummary`
--

INSERT INTO `tutorialsummary` (`SummaryID`, `summary_content`, `tutorial_ID`) VALUES
(2, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 2),
(3, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 3),
(4, 'uploads/summaries/dzexams-docs-3as-907500.pdf', 4),
(5, 'uploads/summaries/dzexams-docs-3as-907499.pdf', 4),
(6, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 4),
(7, 'uploads/summaries/dzexams-docs-3as-907500.pdf', 5),
(8, 'uploads/summaries/dzexams-docs-3as-907499.pdf', 5),
(9, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 5),
(10, 'uploads/summaries/Exercices-Variables-aleatoires-a-densite.pdf', 5),
(11, 'uploads/summaries/dzexams-docs-3as-907500.pdf', 6),
(12, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 7),
(13, 'uploads/summaries/Exercices-Variables-aleatoires-a-densite.pdf', 7),
(14, 'uploads/summaries/dzexams-docs-3as-907501.pdf', 8),
(15, 'uploads/summaries/Exercices-Variables-aleatoires-a-densite.pdf', 9),
(16, 'uploads/summaries/Exercices-Variables-aleatoires-a-densite.pdf', 10),
(17, 'uploads/summaries/dzexams-docs-3as-907500.pdf', 11),
(18, 'uploads/summaries/dzexams-docs-3as-904742.pdf', 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `User_Email` varchar(100) NOT NULL,
  `User_Password` varchar(255) NOT NULL,
  `Role` varchar(10) NOT NULL CHECK (`Role` in ('Student','Admin')),
  `User_FirstName` varchar(100) DEFAULT NULL,
  `User_LastName` varchar(100) DEFAULT NULL,
  `User_Phone` varchar(15) DEFAULT NULL,
  `User_Branch` varchar(100) DEFAULT NULL CHECK (`User_Branch` in ('ST','MT','ML')),
  `User_Level` varchar(100) DEFAULT NULL CHECK (`User_Level` in ('1AS','2AS','3AS')),
  `User_Points` int(11) DEFAULT 0 CHECK (`User_Points` >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `User_Email`, `User_Password`, `Role`, `User_FirstName`, `User_LastName`, `User_Phone`, `User_Branch`, `User_Level`, `User_Points`) VALUES
(2, 'adminadmin@gmail.com', '$2y$10$txyuYrPVvwZMULCpRZA13e560N.VHrmyUz6I4Ku6bFtgRIIeOdt/C', 'Admin', 'Admin', 'TOP', NULL, NULL, NULL, 0),
(3, 'adel@gmail.com', '$2y$10$RTzvhh4Ez1QDz7GYCsxGD.XyqN8xpe.Vr4lhNtNwUN92K2FpZfK12', 'Student', 'Abderraouf', 'Garamida', '0712345678', 'MT', '3AS', 8999500),
(4, 'hassan@gmail.com', '$2y$10$lkU9XD1rR1IQqVL2INBN1.DZmroaD4R7QrF9tC7uFCku7PFuDAPR.', 'Student', 'Hassan', 'Ait ahmed lamara', '0787699321', 'MT', '2AS', 5000),
(5, 'admin2@gmail.com', '$2y$10$qLNtz..r7F6FQlDCye4Qk.DNwg56Drmv9jgVIJYv5sE7ZDM2E2jfq', 'Admin', 'Admin', 'Admin', NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`),
  ADD KEY `fk_Course_UserID` (`UserID`);

--
-- Indexes for table `coursesummarize`
--
ALTER TABLE `coursesummarize`
  ADD PRIMARY KEY (`summarizeID`),
  ADD KEY `fk_CourseSummarize_CourseID` (`CourseID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `fk_Feedback_UserID` (`UserID`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`MessageID`),
  ADD KEY `fk_Message_UserID` (`UserID`);

--
-- Indexes for table `password_reset_codes`
--
ALTER TABLE `password_reset_codes`
  ADD PRIMARY KEY (`PassID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `payement`
--
ALTER TABLE `payement`
  ADD PRIMARY KEY (`PayementID`),
  ADD KEY `fk_Payment_StudentID` (`StudentID`),
  ADD KEY `fk_Payment_AdminID` (`AdminID`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`PostID`),
  ADD KEY `fk_Post_UserID` (`UserID`);

--
-- Indexes for table `studentcourse`
--
ALTER TABLE `studentcourse`
  ADD PRIMARY KEY (`CourseID`,`UserID`),
  ADD KEY `fk_StudentCourse_UserID` (`UserID`);

--
-- Indexes for table `studentpost`
--
ALTER TABLE `studentpost`
  ADD PRIMARY KEY (`PostID`,`UserID`),
  ADD KEY `fk_StudentPost_UserID` (`UserID`);

--
-- Indexes for table `studentsecurity`
--
ALTER TABLE `studentsecurity`
  ADD PRIMARY KEY (`studSecuID`),
  ADD KEY `fk_StudentSecurity_UserID` (`UserID`);

--
-- Indexes for table `studenttasks`
--
ALTER TABLE `studenttasks`
  ADD PRIMARY KEY (`TaskID`,`StudentID`,`CourseID`),
  ADD KEY `fk_StudentTasks_StudentID` (`StudentID`),
  ADD KEY `fk_StudentTasks_CourseID` (`CourseID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`TaskID`),
  ADD KEY `fk_Tasks_CourseID` (`course_ID`),
  ADD KEY `fk_Tasks_UserID` (`UserID`);

--
-- Indexes for table `tutorialmaterials`
--
ALTER TABLE `tutorialmaterials`
  ADD PRIMARY KEY (`MaterialID`),
  ADD KEY `fk_TutorialMaterials_tutorial_ID` (`tutorial_ID`);

--
-- Indexes for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD PRIMARY KEY (`tutorial_ID`),
  ADD KEY `fk_Tutorials_UserID` (`UserID`),
  ADD KEY `fk_Tutorials_CourseID` (`course_ID`);

--
-- Indexes for table `tutorialsummary`
--
ALTER TABLE `tutorialsummary`
  ADD PRIMARY KEY (`SummaryID`),
  ADD KEY `fk_TutorialSummary_tutorial_ID` (`tutorial_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `User_Email` (`User_Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coursesummarize`
--
ALTER TABLE `coursesummarize`
  MODIFY `summarizeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset_codes`
--
ALTER TABLE `password_reset_codes`
  MODIFY `PassID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payement`
--
ALTER TABLE `payement`
  MODIFY `PayementID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `PostID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `studentsecurity`
--
ALTER TABLE `studentsecurity`
  MODIFY `studSecuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `TaskID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tutorialmaterials`
--
ALTER TABLE `tutorialmaterials`
  MODIFY `MaterialID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tutorials`
--
ALTER TABLE `tutorials`
  MODIFY `tutorial_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tutorialsummary`
--
ALTER TABLE `tutorialsummary`
  MODIFY `SummaryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `fk_Course_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `coursesummarize`
--
ALTER TABLE `coursesummarize`
  ADD CONSTRAINT `fk_CourseSummarize_CourseID` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_Feedback_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_Message_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `password_reset_codes`
--
ALTER TABLE `password_reset_codes`
  ADD CONSTRAINT `password_reset_codes_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `payement`
--
ALTER TABLE `payement`
  ADD CONSTRAINT `fk_Payment_AdminID` FOREIGN KEY (`AdminID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `fk_Payment_StudentID` FOREIGN KEY (`StudentID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_Post_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `studentcourse`
--
ALTER TABLE `studentcourse`
  ADD CONSTRAINT `fk_StudentCourse_CourseID` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_StudentCourse_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `studentpost`
--
ALTER TABLE `studentpost`
  ADD CONSTRAINT `fk_StudentPost_PostID` FOREIGN KEY (`PostID`) REFERENCES `post` (`PostID`),
  ADD CONSTRAINT `fk_StudentPost_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `studentsecurity`
--
ALTER TABLE `studentsecurity`
  ADD CONSTRAINT `fk_StudentSecurity_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `studenttasks`
--
ALTER TABLE `studenttasks`
  ADD CONSTRAINT `fk_StudentTasks_CourseID` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`),
  ADD CONSTRAINT `fk_StudentTasks_StudentID` FOREIGN KEY (`StudentID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `fk_StudentTasks_TaskID` FOREIGN KEY (`TaskID`) REFERENCES `tasks` (`TaskID`) ON DELETE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `fk_Tasks_CourseID` FOREIGN KEY (`course_ID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Tasks_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `tutorialmaterials`
--
ALTER TABLE `tutorialmaterials`
  ADD CONSTRAINT `fk_TutorialMaterials_tutorial_ID` FOREIGN KEY (`tutorial_ID`) REFERENCES `tutorials` (`tutorial_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tutorials`
--
ALTER TABLE `tutorials`
  ADD CONSTRAINT `fk_Tutorials_CourseID` FOREIGN KEY (`course_ID`) REFERENCES `course` (`CourseID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_Tutorials_UserID` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `tutorialsummary`
--
ALTER TABLE `tutorialsummary`
  ADD CONSTRAINT `fk_TutorialSummary_tutorial_ID` FOREIGN KEY (`tutorial_ID`) REFERENCES `tutorials` (`tutorial_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
