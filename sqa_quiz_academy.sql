-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2025 at 11:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sqa_quiz_academy`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Software Testing Fundamentals', 'Basic concepts and principles of software testing', '2025-08-09 08:02:47'),
(2, 'Test Planning & Strategy', 'Test planning, strategy development, and test case design', '2025-08-09 08:02:47'),
(3, 'Test Execution & Management', 'Test execution, defect management, and test reporting', '2025-08-09 08:02:47'),
(4, 'Automation Testing', 'Test automation frameworks, tools, and best practices', '2025-08-09 08:02:47'),
(5, 'Performance Testing', 'Load testing, stress testing, and performance monitoring', '2025-08-09 08:02:47'),
(6, 'Security Testing', 'Security testing methodologies and vulnerability assessment', '2025-08-09 08:02:47'),
(7, 'API Testing', 'REST API testing, web services testing, and integration testing', '2025-08-09 08:02:47'),
(8, 'Mobile Testing', 'Mobile application testing strategies and tools', '2025-08-09 08:02:47'),
(9, 'Database Testing', 'Database testing, data validation, and SQL testing', '2025-08-09 08:02:47'),
(10, 'Agile Testing', 'Testing in agile environments, continuous testing, and DevOps', '2025-08-09 08:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL,
  `explanation` text DEFAULT NULL,
  `difficulty_level` enum('easy','medium','hard') DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`, `explanation`, `difficulty_level`, `created_at`, `updated_at`) VALUES
(1, 1, 'What is the primary goal of software testing?', 'To find bugs', 'To ensure software meets requirements', 'To make software faster', 'To reduce development time', 'B', 'The primary goal is to ensure software meets specified requirements and works as expected.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(2, 1, 'Which testing type focuses on testing individual components?', 'Integration testing', 'System testing', 'Unit testing', 'Acceptance testing', 'C', 'Unit testing focuses on testing individual components or units of code in isolation.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(3, 1, 'What is the difference between verification and validation?', 'Verification checks if we built it right, validation checks if we built the right thing', 'Verification is manual testing, validation is automated testing', 'Verification is functional testing, validation is non-functional testing', 'There is no difference', 'A', 'Verification ensures the product is built correctly, while validation ensures we built the right product.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(4, 1, 'Which testing principle states that testing shows the presence of defects?', 'Testing shows absence of defects', 'Testing shows presence of defects', 'Testing prevents defects', 'Testing fixes defects', 'B', 'Testing can show that defects are present, but cannot prove that there are no defects.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(5, 1, 'What is the V-Model in software testing?', 'A testing tool', 'A development methodology', 'A testing framework', 'A verification and validation model', 'D', 'The V-Model is a verification and validation model that shows the relationship between development phases and testing phases.', 'hard', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(6, 2, 'What is a test plan?', 'A document describing test cases', 'A document describing the testing approach', 'A tool for test execution', 'A bug report template', 'B', 'A test plan is a document that describes the testing approach, scope, resources, and schedule.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(7, 2, 'Which factor is NOT considered in test strategy?', 'Test objectives', 'Test scope', 'Test environment', 'Developer salaries', 'D', 'Developer salaries are not a factor in test strategy. Test strategy focuses on testing approach and methodology.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(8, 2, 'What is risk-based testing?', 'Testing without planning', 'Testing based on probability and impact of failures', 'Testing only high-priority features', 'Testing in production', 'B', 'Risk-based testing prioritizes testing based on the probability and impact of potential failures.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(9, 2, 'Which document defines what to test and what not to test?', 'Test plan', 'Test scope', 'Test strategy', 'Test cases', 'B', 'Test scope defines the boundaries of testing - what features will be tested and what will be excluded.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(10, 2, 'What is the purpose of entry and exit criteria?', 'To define when testing starts and ends', 'To define test cases', 'To define test data', 'To define test tools', 'A', 'Entry criteria define when testing can begin, and exit criteria define when testing can be considered complete.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(11, 3, 'What is a test case?', 'A bug report', 'A set of test inputs and expected results', 'A test plan', 'A test tool', 'B', 'A test case is a set of test inputs, execution conditions, and expected results developed for a particular objective.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(12, 3, 'What is the difference between a test case and a test scenario?', 'There is no difference', 'Test case is detailed, test scenario is high-level', 'Test case is automated, test scenario is manual', 'Test case is for functional testing, test scenario is for non-functional testing', 'B', 'A test scenario is a high-level description of what to test, while a test case provides detailed steps and expected results.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(13, 3, 'What is defect severity?', 'How difficult it is to fix the defect', 'How much the defect affects the system', 'How many users are affected', 'How long it takes to reproduce', 'B', 'Defect severity indicates the impact of the defect on the system or application functionality.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(14, 3, 'What is defect priority?', 'How difficult it is to fix the defect', 'How important it is to fix the defect', 'How many users are affected', 'How long it takes to reproduce', 'B', 'Defect priority indicates the urgency or importance of fixing the defect.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(15, 3, 'What is regression testing?', 'Testing new features', 'Testing to ensure old features still work', 'Testing performance', 'Testing security', 'B', 'Regression testing ensures that previously developed and tested software still performs correctly after changes.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(16, 4, 'What is Selenium?', 'A programming language', 'A web browser', 'A web automation tool', 'A database', 'C', 'Selenium is an open-source web automation tool used for testing web applications.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(17, 4, 'Which programming language is commonly used with Selenium?', 'Python', 'Java', 'JavaScript', 'All of the above', 'D', 'Selenium supports multiple programming languages including Python, Java, JavaScript, C#, and others.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(18, 4, 'What is the difference between Selenium WebDriver and Selenium IDE?', 'WebDriver is for automation, IDE is for recording', 'WebDriver is free, IDE is paid', 'WebDriver is for mobile testing, IDE is for web testing', 'There is no difference', 'A', 'Selenium WebDriver is a programming interface for browser automation, while Selenium IDE is a record-and-playback tool.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(19, 4, 'What is Page Object Model (POM)?', 'A design pattern for web automation', 'A testing framework', 'A programming language', 'A database model', 'A', 'Page Object Model is a design pattern that creates an object repository for web UI elements.', 'hard', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(20, 4, 'What is the purpose of implicit wait in Selenium?', 'To wait for a specific element', 'To wait for a specific condition', 'To wait for a specified time for all elements', 'To wait for page load', 'C', 'Implicit wait tells WebDriver to wait for a specified amount of time when trying to find elements.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(21, 5, 'What is load testing?', 'Testing under normal conditions', 'Testing under expected load', 'Testing under maximum load', 'Testing under stress conditions', 'B', 'Load testing verifies that the system can handle the expected number of users and transactions.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(22, 5, 'What is stress testing?', 'Testing under normal conditions', 'Testing under expected load', 'Testing beyond normal capacity', 'Testing security vulnerabilities', 'C', 'Stress testing determines the system\'s behavior under conditions that exceed normal or peak load conditions.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(23, 5, 'What is JMeter?', 'A web browser', 'A performance testing tool', 'A database', 'A programming language', 'B', 'Apache JMeter is an open-source performance testing tool used to analyze and measure the performance of web applications.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(24, 5, 'What is response time in performance testing?', 'Time to load the page', 'Time between request and response', 'Time to process data', 'Time to connect to server', 'B', 'Response time is the time taken between sending a request and receiving the response.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(25, 5, 'What is throughput in performance testing?', 'Number of requests per second', 'Response time', 'CPU usage', 'Memory usage', 'A', 'Throughput is the number of requests that can be processed per unit of time (usually per second).', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(26, 6, 'What is SQL Injection?', 'A database optimization technique', 'A security vulnerability where SQL code is inserted into input fields', 'A type of database backup', 'A database migration tool', 'B', 'SQL Injection is a code injection technique that exploits vulnerabilities in an application\'s software by inserting malicious SQL statements.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(27, 6, 'What is XSS (Cross-Site Scripting)?', 'A CSS framework', 'A security vulnerability where malicious scripts are injected into web pages', 'A JavaScript library', 'A web development tool', 'B', 'XSS is a security vulnerability that allows attackers to inject malicious scripts into web pages viewed by other users.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(28, 6, 'What is penetration testing?', 'Testing software performance', 'Testing software functionality', 'Testing software security by simulating attacks', 'Testing software usability', 'C', 'Penetration testing is a security testing method where testers simulate attacks to identify security vulnerabilities.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(29, 6, 'What is OWASP?', 'A programming language', 'A security testing tool', 'An organization focused on web application security', 'A database', 'C', 'OWASP (Open Web Application Security Project) is a nonprofit organization focused on improving software security.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(30, 6, 'What is authentication in security testing?', 'Verifying user identity', 'Verifying user permissions', 'Verifying data integrity', 'Verifying system performance', 'A', 'Authentication is the process of verifying the identity of a user or system.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(31, 7, 'What is REST API?', 'A programming language', 'A web service architecture style', 'A database', 'A testing tool', 'B', 'REST (Representational State Transfer) is an architectural style for designing networked applications.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(32, 7, 'What is Postman?', 'A web browser', 'An API testing tool', 'A database', 'A programming language', 'B', 'Postman is a popular API testing tool used for testing and documenting APIs.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(33, 7, 'What is the difference between GET and POST HTTP methods?', 'GET is faster than POST', 'GET is for retrieving data, POST is for sending data', 'GET is secure, POST is not', 'There is no difference', 'B', 'GET is used to retrieve data from the server, while POST is used to send data to the server.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(34, 7, 'What is JSON?', 'A programming language', 'A data format', 'A database', 'A testing tool', 'B', 'JSON (JavaScript Object Notation) is a lightweight data interchange format.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(35, 7, 'What is API endpoint?', 'A programming language', 'A URL that provides access to a resource', 'A database', 'A testing tool', 'B', 'An API endpoint is a URL that provides access to a specific resource or functionality.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(36, 8, 'What is Appium?', 'A mobile app', 'A mobile automation testing tool', 'A mobile operating system', 'A mobile database', 'B', 'Appium is an open-source tool for automating native, mobile web, and hybrid applications.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(37, 8, 'What is the difference between native and hybrid mobile apps?', 'Native apps are faster', 'Native apps are built for specific platforms, hybrid apps work on multiple platforms', 'Native apps are free, hybrid apps are paid', 'There is no difference', 'B', 'Native apps are built specifically for one platform (iOS or Android), while hybrid apps work on multiple platforms.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(38, 8, 'What is mobile responsive testing?', 'Testing app performance', 'Testing app functionality', 'Testing app appearance on different screen sizes', 'Testing app security', 'C', 'Mobile responsive testing ensures that the app displays correctly on different screen sizes and orientations.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(39, 8, 'What is device fragmentation in mobile testing?', 'Breaking devices', 'Different devices with different specifications', 'Device security issues', 'Device performance issues', 'B', 'Device fragmentation refers to the variety of devices with different screen sizes, operating systems, and hardware specifications.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(40, 8, 'What is mobile app testing?', 'Testing only iOS apps', 'Testing only Android apps', 'Testing mobile applications on various devices and platforms', 'Testing mobile websites only', 'C', 'Mobile app testing involves testing mobile applications on various devices, operating systems, and network conditions.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(41, 9, 'What is database testing?', 'Testing database performance', 'Testing database security', 'Testing data integrity, accuracy, and consistency', 'Testing database backup', 'C', 'Database testing involves verifying data integrity, accuracy, and consistency in the database.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(42, 9, 'What is data validation testing?', 'Testing data types', 'Testing data accuracy and completeness', 'Testing data security', 'Testing data backup', 'B', 'Data validation testing ensures that data is accurate, complete, and meets specified requirements.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(43, 9, 'What is SQL testing?', 'Testing SQL syntax', 'Testing database queries and stored procedures', 'Testing database performance', 'Testing database security', 'B', 'SQL testing involves testing database queries, stored procedures, and database operations.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(44, 9, 'What is referential integrity?', 'Data accuracy', 'Data consistency between related tables', 'Data security', 'Data backup', 'B', 'Referential integrity ensures that relationships between tables remain consistent.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(45, 9, 'What is ACID in database testing?', 'A testing tool', 'Database properties (Atomicity, Consistency, Isolation, Durability)', 'A database type', 'A testing framework', 'B', 'ACID properties ensure reliable database transactions: Atomicity, Consistency, Isolation, and Durability.', 'hard', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(46, 10, 'What is Agile testing?', 'Testing without planning', 'Testing approach that follows Agile principles', 'Testing only at the end', 'Testing without documentation', 'B', 'Agile testing is a testing approach that follows Agile principles and practices.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(47, 10, 'What is continuous testing?', 'Testing continuously without breaks', 'Testing integrated into the development pipeline', 'Testing only in production', 'Testing without automation', 'B', 'Continuous testing is the process of testing integrated into the development pipeline to provide immediate feedback.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(48, 10, 'What is test-driven development (TDD)?', 'Writing tests after development', 'Writing tests before development', 'Writing tests during development', 'Writing tests without development', 'B', 'TDD is a development approach where tests are written before the actual code.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(49, 10, 'What is behavior-driven development (BDD)?', 'A testing framework', 'A development approach using natural language', 'A programming language', 'A database', 'B', 'BDD is a development approach that uses natural language to describe software behavior.', 'medium', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(50, 10, 'What is the role of a tester in Agile teams?', 'Only manual testing', 'Only automated testing', 'Active participation throughout the development cycle', 'Only testing at the end', 'C', 'In Agile teams, testers actively participate throughout the development cycle, not just at the end.', 'easy', '2025-08-09 08:14:03', '2025-08-09 08:14:03'),
(51, 1, 'What is the primary goal of software testing?', 'To find bugs', 'To ensure software meets requirements', 'To make software faster', 'To reduce development time', 'B', 'The primary goal is to ensure software meets specified requirements and works as expected.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(52, 1, 'Which testing type focuses on testing individual components?', 'Integration testing', 'System testing', 'Unit testing', 'Acceptance testing', 'C', 'Unit testing focuses on testing individual components or units of code in isolation.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(53, 1, 'What is a test case?', 'A tool for automation testing', 'A set of conditions to verify functionality', 'A programming language', 'A type of software bug', 'B', 'A test case is a set of conditions or variables used to determine if a system works correctly.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(54, 1, 'What does black-box testing focus on?', 'Code structure', 'Internal logic', 'Input-output functionality', 'Database schema', 'C', 'Black-box testing focuses on testing the functionality of an application without knowledge of its internal code.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(55, 1, 'What is regression testing?', 'Testing new features', 'Testing after changes to ensure existing functionality works', 'Testing system performance', 'Testing database integrity', 'B', 'Regression testing ensures that new changes have not negatively impacted existing functionality.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(56, 2, 'What is the purpose of a test plan?', 'To write code', 'To define testing scope and strategy', 'To execute test cases', 'To deploy software', 'B', 'A test plan outlines the scope, objectives, resources, and strategy for testing a project.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(57, 2, 'Which factor is critical in test strategy development?', 'Project budget', 'Marketing goals', 'Hardware specifications', 'Risk assessment', 'D', 'Risk assessment helps prioritize testing efforts based on potential impact and likelihood of issues.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(58, 2, 'What is a traceability matrix used for?', 'Tracking test execution time', 'Mapping requirements to test cases', 'Automating test scripts', 'Monitoring server performance', 'B', 'A traceability matrix ensures all requirements are covered by test cases.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(59, 2, 'What is risk-based testing?', 'Testing only critical features', 'Testing based on potential risks to the system', 'Testing with random inputs', 'Testing without a plan', 'B', 'Risk-based testing prioritizes testing based on the likelihood and impact of risks.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(60, 2, 'Which document defines the entry and exit criteria for testing?', 'Test case', 'Test plan', 'Bug report', 'User manual', 'B', 'The test plan specifies entry and exit criteria to guide the testing process.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(61, 3, 'What is the purpose of test execution?', 'To write test scripts', 'To run test cases and verify results', 'To design test cases', 'To plan testing activities', 'B', 'Test execution involves running test cases and comparing actual results with expected outcomes.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(62, 3, 'Which tool is commonly used for test management?', 'Selenium', 'TestRail', 'Postman', 'JMeter', 'B', 'TestRail is a test management tool used to track test cases, execution, and results.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(63, 3, 'What is a defect lifecycle?', 'The process of writing test cases', 'The stages a bug goes through from detection to closure', 'The time taken to execute tests', 'The process of automating tests', 'B', 'The defect lifecycle tracks a bug from discovery to resolution, including states like open, fixed, and closed.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(64, 3, 'What does a test report typically include?', 'Code snippets', 'Test execution results and defect summary', 'Marketing strategies', 'Database schema', 'B', 'A test report summarizes test execution outcomes, defects found, and testing coverage.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(65, 3, 'What is exploratory testing?', 'Testing with predefined test cases', 'Testing without a formal plan, guided by intuition', 'Testing only performance metrics', 'Testing database queries', 'B', 'Exploratory testing involves simultaneous learning, test design, and execution without predefined scripts.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(66, 4, 'What is a key benefit of automation testing?', 'Eliminates all bugs', 'Reduces manual effort for repetitive tests', 'Replaces all manual testing', 'Ensures code quality without testing', 'B', 'Automation testing saves time and effort by automating repetitive test cases, especially for regression testing.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(67, 4, 'Which tool is widely used for web automation testing?', 'JMeter', 'Selenium', 'Burp Suite', 'TestRail', 'B', 'Selenium is a popular tool for automating web application testing across browsers.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(68, 4, 'What is a test script in automation testing?', 'A manual test case', 'A program to execute automated tests', 'A database query', 'A bug report', 'B', 'A test script is a set of instructions written in a programming language to automate test execution.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(69, 4, 'What is a common challenge in automation testing?', 'Low cost of implementation', 'Maintaining test scripts for changing applications', 'Eliminating all defects', 'Lack of tools', 'B', 'Maintaining test scripts to keep up with application changes is a significant challenge in automation.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(70, 4, 'Which framework is commonly used in Selenium?', 'TestNG', 'Apache', 'Spring', 'Hibernate', 'A', 'TestNG is a testing framework used with Selenium for test configuration and parallel execution.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(71, 5, 'What is the main goal of performance testing?', 'To find functional bugs', 'To evaluate system speed and scalability', 'To test database queries', 'To verify security protocols', 'B', 'Performance testing evaluates system responsiveness, scalability, and stability under various conditions.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(72, 5, 'Which tool is used for load testing?', 'Selenium', 'JMeter', 'Postman', 'Zephyr', 'B', 'JMeter is a popular tool for load and performance testing of applications.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(73, 5, 'What is stress testing?', 'Testing normal system behavior', 'Testing system limits under extreme conditions', 'Testing user interfaces', 'Testing API endpoints', 'B', 'Stress testing evaluates system behavior under extreme conditions to identify breaking points.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(74, 5, 'What does throughput measure in performance testing?', 'Number of defects found', 'Rate of successful transactions per second', 'Code complexity', 'Test case coverage', 'B', 'Throughput measures the rate at which a system processes transactions successfully.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(75, 5, 'What is a bottleneck in performance testing?', 'A fast system component', 'A point where system performance degrades', 'A test case failure', 'A secure endpoint', 'B', 'A bottleneck is a system component that limits overall performance under load.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(76, 6, 'What is the primary focus of security testing?', 'Improving system speed', 'Identifying vulnerabilities and threats', 'Testing user interfaces', 'Validating database schema', 'B', 'Security testing aims to identify vulnerabilities and ensure the system is protected against threats.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(77, 6, 'Which tool is used for penetration testing?', 'Selenium', 'Burp Suite', 'TestRail', 'JMeter', 'B', 'Burp Suite is a popular tool for conducting penetration testing and identifying security vulnerabilities.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(78, 6, 'What is SQL injection?', 'A performance testing technique', 'A security attack injecting malicious SQL code', 'A database optimization method', 'A type of unit testing', 'B', 'SQL injection is an attack where malicious SQL code is inserted to manipulate a database.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(79, 6, 'What does OWASP stand for?', 'Open Web Application Security Project', 'Open Workflow Analysis System Protocol', 'Operational Web Automation Security Plan', 'Open Web Accessibility Standards Project', 'A', 'OWASP is a community-driven organization focused on improving software security.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(80, 6, 'What is a common goal of a security audit?', 'To improve system performance', 'To ensure compliance with security standards', 'To automate test cases', 'To design user interfaces', 'B', 'A security audit ensures systems comply with security standards and policies.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(81, 7, 'What does API testing primarily validate?', 'User interface design', 'API functionality, performance, and security', 'Database structure', 'Code complexity', 'B', 'API testing validates the functionality, performance, and security of application programming interfaces.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(82, 7, 'Which tool is commonly used for API testing?', 'Selenium', 'Postman', 'JMeter', 'TestRail', 'B', 'Postman is a widely used tool for testing APIs by sending requests and validating responses.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(83, 7, 'What is a common HTTP status code for a successful API request?', '404', '500', '200', '403', 'C', 'The HTTP status code 200 indicates a successful request and response.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(84, 7, 'What is the purpose of a mock server in API testing?', 'To execute test cases', 'To simulate API responses for testing', 'To monitor system performance', 'To manage test data', 'B', 'A mock server simulates API responses to test client behavior without relying on a live server.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(85, 7, 'What does SOAP stand for in API testing?', 'Simple Object Access Protocol', 'System Operation Analysis Protocol', 'Standard Output Automation Process', 'Secure Object Application Protocol', 'A', 'SOAP is a protocol for exchanging structured information in web services.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(86, 8, 'What is a key focus of mobile testing?', 'Testing database queries', 'Ensuring app compatibility across devices', 'Testing server hardware', 'Writing unit tests', 'B', 'Mobile testing ensures apps work across various devices, OS versions, and screen sizes.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(87, 8, 'Which tool is used for mobile app automation?', 'JMeter', 'Appium', 'TestRail', 'Burp Suite', 'B', 'Appium is an open-source tool for automating mobile app testing on iOS and Android.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(88, 8, 'What is a common challenge in mobile testing?', 'Lack of testing tools', 'Device fragmentation', 'No need for automation', 'Simple test case design', 'B', 'Device fragmentation, with varied OS versions and hardware, complicates mobile testing.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(89, 8, 'What is emulator testing in mobile apps?', 'Testing on physical devices', 'Testing on virtual devices', 'Testing server performance', 'Testing database integrity', 'B', 'Emulator testing uses virtual devices to simulate mobile environments for testing.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(90, 8, 'What is a key aspect of usability testing for mobile apps?', 'Testing server load', 'Ensuring intuitive user experience', 'Validating database queries', 'Testing code coverage', 'B', 'Usability testing ensures the app is intuitive and user-friendly on mobile devices.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(91, 9, 'What is the focus of database testing?', 'Testing user interfaces', 'Validating data integrity and schema', 'Testing API endpoints', 'Testing system performance', 'B', 'Database testing validates data integrity, schema, and performance of database operations.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(92, 9, 'Which language is commonly used in database testing?', 'JavaScript', 'SQL', 'Python', 'HTML', 'B', 'SQL is used to write queries for validating database functionality and data integrity.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(93, 9, 'What is a stored procedure in database testing?', 'A user interface component', 'A precompiled set of SQL statements', 'A performance testing tool', 'A type of API', 'B', 'A stored procedure is a precompiled set of SQL statements stored in the database for reuse.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(94, 9, 'What is data consistency in database testing?', 'Ensuring fast query execution', 'Ensuring data is accurate across tables', 'Testing user interfaces', 'Validating API responses', 'B', 'Data consistency ensures data remains accurate and synchronized across database tables.', 'hard', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(95, 9, 'Which tool is used for database testing?', 'Selenium', 'DBUnit', 'Postman', 'JMeter', 'B', 'DBUnit is a tool used for database testing, particularly for unit testing database-driven applications.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(96, 10, 'What is a key principle of Agile testing?', 'Testing only at the end of development', 'Continuous testing throughout the sprint', 'Testing without collaboration', 'Testing only performance metrics', 'B', 'Agile testing involves continuous testing throughout the development cycle to ensure quality.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(97, 10, 'Which tool is commonly used in Agile testing for task tracking?', 'Selenium', 'Jira', 'Burp Suite', 'Postman', 'B', 'Jira is widely used in Agile projects to track tasks, user stories, and testing progress.', 'medium', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(98, 10, 'What is a user story in Agile testing?', 'A detailed test case', 'A description of a feature from the user’s perspective', 'A performance metric', 'A security vulnerability', 'B', 'A user story describes a feature or requirement from the end user’s perspective to guide testing.', 'easy', '2025-08-09 08:32:13', '2025-08-09 08:32:13'),
(99, 10, 'What is the role of a tester in a Scrum team?', 'Only writing code', 'Collaborating with developers and stakeholders to ensure quality', 'Managing project budgets', 'Deploying the application', 'B', 'Testers in Scrum collaborate with the team to ensure quality throughout the development process.', 'medium', '2025-08-09 08:32:14', '2025-08-09 08:32:14'),
(100, 10, 'What is test-driven development (TDD) in Agile?', 'Testing after development is complete', 'Writing tests before writing code', 'Testing only user interfaces', 'Testing database queries', 'B', 'TDD involves writing automated tests before writing the code to implement functionality.', 'hard', '2025-08-09 08:32:14', '2025-08-09 08:32:14');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_answers`
--

CREATE TABLE `quiz_answers` (
  `id` int(11) NOT NULL,
  `session_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_answer` enum('A','B','C','D') DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0,
  `answered_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_answers`
--

INSERT INTO `quiz_answers` (`id`, `session_id`, `question_id`, `user_answer`, `is_correct`, `answered_at`) VALUES
(1, 7, 46, 'A', 0, '2025-08-09 08:54:54'),
(2, 7, 47, 'A', 0, '2025-08-09 08:54:54'),
(3, 7, 48, 'A', 0, '2025-08-09 08:54:54'),
(4, 7, 49, '', 0, '2025-08-09 08:54:54'),
(5, 7, 50, 'C', 1, '2025-08-09 08:54:54'),
(6, 7, 96, 'A', 0, '2025-08-09 08:54:54'),
(7, 7, 97, 'A', 0, '2025-08-09 08:54:54'),
(8, 7, 98, 'A', 0, '2025-08-09 08:54:54'),
(9, 7, 99, 'A', 0, '2025-08-09 08:54:54'),
(10, 7, 100, 'A', 0, '2025-08-09 08:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_sessions`
--

CREATE TABLE `quiz_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT 0,
  `total_questions` int(11) DEFAULT 0,
  `time_taken` int(11) DEFAULT 0,
  `completed` tinyint(1) DEFAULT 0,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_sessions`
--

INSERT INTO `quiz_sessions` (`id`, `user_id`, `category_id`, `score`, `total_questions`, `time_taken`, `completed`, `started_at`, `completed_at`) VALUES
(1, 1, 10, 0, 0, 0, 0, '2025-08-09 08:26:28', NULL),
(2, 3, 10, 0, 0, 0, 0, '2025-08-09 08:46:24', NULL),
(3, 3, 10, 0, 0, 0, 0, '2025-08-09 08:46:26', NULL),
(4, 3, 10, 0, 0, 0, 0, '2025-08-09 08:46:51', NULL),
(5, 3, 10, 0, 0, 0, 0, '2025-08-09 08:48:02', NULL),
(6, 3, 10, 0, 0, 0, 0, '2025-08-09 08:48:05', NULL),
(7, 3, 10, 10, 10, 27, 1, '2025-08-09 08:54:20', '2025-08-09 08:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `description`, `created_at`, `updated_at`) VALUES
(1, 'quiz_timer_minutes', '15', 'Default quiz timer duration in minutes', '2025-08-09 08:38:38', '2025-08-09 08:42:38'),
(2, 'questions_per_quiz', '15', 'Number of questions per quiz', '2025-08-09 08:38:38', '2025-08-09 08:42:38'),
(3, 'passing_score', '70', 'Minimum passing score percentage', '2025-08-09 08:38:38', '2025-08-09 08:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@sqaquiz.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-08-09 08:02:46', '2025-08-09 08:02:46'),
(2, 'tanim', 'tanim@gmail.com', '$2y$10$1WXbgZn2dx3xCMWOMwVFyuLQTBBNj829STdsSAYiDWJHF51rGKbMG', 'admin', '2025-08-09 08:28:24', '2025-08-09 08:29:07'),
(3, 'demo', 'demo@gmail.com', '$2y$10$ueusonpVXazfm6umw.1BjOaixvfr0YMSpcwpMvwWqxtNENn1OiaKK', 'user', '2025-08-09 08:46:05', '2025-08-09 08:46:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `quiz_sessions`
--
ALTER TABLE `quiz_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `quiz_sessions`
--
ALTER TABLE `quiz_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quiz_answers`
--
ALTER TABLE `quiz_answers`
  ADD CONSTRAINT `quiz_answers_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `quiz_sessions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `quiz_sessions`
--
ALTER TABLE `quiz_sessions`
  ADD CONSTRAINT `quiz_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quiz_sessions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
