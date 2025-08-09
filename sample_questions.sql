-- Sample SQA Questions for SQA Quiz Academy

-- Software Testing Fundamentals
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(1, 'What is the primary goal of software testing?', 'To find bugs', 'To ensure software meets requirements', 'To make software faster', 'To reduce development time', 'B', 'The primary goal is to ensure software meets specified requirements and works as expected.', 'easy'),
(1, 'Which testing type focuses on testing individual components?', 'Integration testing', 'System testing', 'Unit testing', 'Acceptance testing', 'C', 'Unit testing focuses on testing individual components or units of code in isolation.', 'medium'),
(1, 'What is the difference between verification and validation?', 'Verification checks if we built it right, validation checks if we built the right thing', 'Verification is manual testing, validation is automated testing', 'Verification is functional testing, validation is non-functional testing', 'There is no difference', 'A', 'Verification ensures the product is built correctly, while validation ensures we built the right product.', 'medium'),
(1, 'Which testing principle states that testing shows the presence of defects?', 'Testing shows absence of defects', 'Testing shows presence of defects', 'Testing prevents defects', 'Testing fixes defects', 'B', 'Testing can show that defects are present, but cannot prove that there are no defects.', 'easy'),
(1, 'What is the V-Model in software testing?', 'A testing tool', 'A development methodology', 'A testing framework', 'A verification and validation model', 'D', 'The V-Model is a verification and validation model that shows the relationship between development phases and testing phases.', 'hard');

-- Test Planning & Strategy
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(2, 'What is a test plan?', 'A document describing test cases', 'A document describing the testing approach', 'A tool for test execution', 'A bug report template', 'B', 'A test plan is a document that describes the testing approach, scope, resources, and schedule.', 'easy'),
(2, 'Which factor is NOT considered in test strategy?', 'Test objectives', 'Test scope', 'Test environment', 'Developer salaries', 'D', 'Developer salaries are not a factor in test strategy. Test strategy focuses on testing approach and methodology.', 'medium'),
(2, 'What is risk-based testing?', 'Testing without planning', 'Testing based on probability and impact of failures', 'Testing only high-priority features', 'Testing in production', 'B', 'Risk-based testing prioritizes testing based on the probability and impact of potential failures.', 'medium'),
(2, 'Which document defines what to test and what not to test?', 'Test plan', 'Test scope', 'Test strategy', 'Test cases', 'B', 'Test scope defines the boundaries of testing - what features will be tested and what will be excluded.', 'easy'),
(2, 'What is the purpose of entry and exit criteria?', 'To define when testing starts and ends', 'To define test cases', 'To define test data', 'To define test tools', 'A', 'Entry criteria define when testing can begin, and exit criteria define when testing can be considered complete.', 'medium');

-- Test Execution & Management
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(3, 'What is a test case?', 'A bug report', 'A set of test inputs and expected results', 'A test plan', 'A test tool', 'B', 'A test case is a set of test inputs, execution conditions, and expected results developed for a particular objective.', 'easy'),
(3, 'What is the difference between a test case and a test scenario?', 'There is no difference', 'Test case is detailed, test scenario is high-level', 'Test case is automated, test scenario is manual', 'Test case is for functional testing, test scenario is for non-functional testing', 'B', 'A test scenario is a high-level description of what to test, while a test case provides detailed steps and expected results.', 'medium'),
(3, 'What is defect severity?', 'How difficult it is to fix the defect', 'How much the defect affects the system', 'How many users are affected', 'How long it takes to reproduce', 'B', 'Defect severity indicates the impact of the defect on the system or application functionality.', 'easy'),
(3, 'What is defect priority?', 'How difficult it is to fix the defect', 'How important it is to fix the defect', 'How many users are affected', 'How long it takes to reproduce', 'B', 'Defect priority indicates the urgency or importance of fixing the defect.', 'easy'),
(3, 'What is regression testing?', 'Testing new features', 'Testing to ensure old features still work', 'Testing performance', 'Testing security', 'B', 'Regression testing ensures that previously developed and tested software still performs correctly after changes.', 'medium');

-- Automation Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(4, 'What is Selenium?', 'A programming language', 'A web browser', 'A web automation tool', 'A database', 'C', 'Selenium is an open-source web automation tool used for testing web applications.', 'easy'),
(4, 'Which programming language is commonly used with Selenium?', 'Python', 'Java', 'JavaScript', 'All of the above', 'D', 'Selenium supports multiple programming languages including Python, Java, JavaScript, C#, and others.', 'medium'),
(4, 'What is the difference between Selenium WebDriver and Selenium IDE?', 'WebDriver is for automation, IDE is for recording', 'WebDriver is free, IDE is paid', 'WebDriver is for mobile testing, IDE is for web testing', 'There is no difference', 'A', 'Selenium WebDriver is a programming interface for browser automation, while Selenium IDE is a record-and-playback tool.', 'medium'),
(4, 'What is Page Object Model (POM)?', 'A design pattern for web automation', 'A testing framework', 'A programming language', 'A database model', 'A', 'Page Object Model is a design pattern that creates an object repository for web UI elements.', 'hard'),
(4, 'What is the purpose of implicit wait in Selenium?', 'To wait for a specific element', 'To wait for a specific condition', 'To wait for a specified time for all elements', 'To wait for page load', 'C', 'Implicit wait tells WebDriver to wait for a specified amount of time when trying to find elements.', 'medium');

-- Performance Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(5, 'What is load testing?', 'Testing under normal conditions', 'Testing under expected load', 'Testing under maximum load', 'Testing under stress conditions', 'B', 'Load testing verifies that the system can handle the expected number of users and transactions.', 'easy'),
(5, 'What is stress testing?', 'Testing under normal conditions', 'Testing under expected load', 'Testing beyond normal capacity', 'Testing security vulnerabilities', 'C', 'Stress testing determines the system\'s behavior under conditions that exceed normal or peak load conditions.', 'medium'),
(5, 'What is JMeter?', 'A web browser', 'A performance testing tool', 'A database', 'A programming language', 'B', 'Apache JMeter is an open-source performance testing tool used to analyze and measure the performance of web applications.', 'easy'),
(5, 'What is response time in performance testing?', 'Time to load the page', 'Time between request and response', 'Time to process data', 'Time to connect to server', 'B', 'Response time is the time taken between sending a request and receiving the response.', 'easy'),
(5, 'What is throughput in performance testing?', 'Number of requests per second', 'Response time', 'CPU usage', 'Memory usage', 'A', 'Throughput is the number of requests that can be processed per unit of time (usually per second).', 'medium');

-- Security Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(6, 'What is SQL Injection?', 'A database optimization technique', 'A security vulnerability where SQL code is inserted into input fields', 'A type of database backup', 'A database migration tool', 'B', 'SQL Injection is a code injection technique that exploits vulnerabilities in an application\'s software by inserting malicious SQL statements.', 'medium'),
(6, 'What is XSS (Cross-Site Scripting)?', 'A CSS framework', 'A security vulnerability where malicious scripts are injected into web pages', 'A JavaScript library', 'A web development tool', 'B', 'XSS is a security vulnerability that allows attackers to inject malicious scripts into web pages viewed by other users.', 'medium'),
(6, 'What is penetration testing?', 'Testing software performance', 'Testing software functionality', 'Testing software security by simulating attacks', 'Testing software usability', 'C', 'Penetration testing is a security testing method where testers simulate attacks to identify security vulnerabilities.', 'medium'),
(6, 'What is OWASP?', 'A programming language', 'A security testing tool', 'An organization focused on web application security', 'A database', 'C', 'OWASP (Open Web Application Security Project) is a nonprofit organization focused on improving software security.', 'easy'),
(6, 'What is authentication in security testing?', 'Verifying user identity', 'Verifying user permissions', 'Verifying data integrity', 'Verifying system performance', 'A', 'Authentication is the process of verifying the identity of a user or system.', 'easy');

-- API Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(7, 'What is REST API?', 'A programming language', 'A web service architecture style', 'A database', 'A testing tool', 'B', 'REST (Representational State Transfer) is an architectural style for designing networked applications.', 'medium'),
(7, 'What is Postman?', 'A web browser', 'An API testing tool', 'A database', 'A programming language', 'B', 'Postman is a popular API testing tool used for testing and documenting APIs.', 'easy'),
(7, 'What is the difference between GET and POST HTTP methods?', 'GET is faster than POST', 'GET is for retrieving data, POST is for sending data', 'GET is secure, POST is not', 'There is no difference', 'B', 'GET is used to retrieve data from the server, while POST is used to send data to the server.', 'easy'),
(7, 'What is JSON?', 'A programming language', 'A data format', 'A database', 'A testing tool', 'B', 'JSON (JavaScript Object Notation) is a lightweight data interchange format.', 'easy'),
(7, 'What is API endpoint?', 'A programming language', 'A URL that provides access to a resource', 'A database', 'A testing tool', 'B', 'An API endpoint is a URL that provides access to a specific resource or functionality.', 'medium');

-- Mobile Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(8, 'What is Appium?', 'A mobile app', 'A mobile automation testing tool', 'A mobile operating system', 'A mobile database', 'B', 'Appium is an open-source tool for automating native, mobile web, and hybrid applications.', 'medium'),
(8, 'What is the difference between native and hybrid mobile apps?', 'Native apps are faster', 'Native apps are built for specific platforms, hybrid apps work on multiple platforms', 'Native apps are free, hybrid apps are paid', 'There is no difference', 'B', 'Native apps are built specifically for one platform (iOS or Android), while hybrid apps work on multiple platforms.', 'medium'),
(8, 'What is mobile responsive testing?', 'Testing app performance', 'Testing app functionality', 'Testing app appearance on different screen sizes', 'Testing app security', 'C', 'Mobile responsive testing ensures that the app displays correctly on different screen sizes and orientations.', 'easy'),
(8, 'What is device fragmentation in mobile testing?', 'Breaking devices', 'Different devices with different specifications', 'Device security issues', 'Device performance issues', 'B', 'Device fragmentation refers to the variety of devices with different screen sizes, operating systems, and hardware specifications.', 'medium'),
(8, 'What is mobile app testing?', 'Testing only iOS apps', 'Testing only Android apps', 'Testing mobile applications on various devices and platforms', 'Testing mobile websites only', 'C', 'Mobile app testing involves testing mobile applications on various devices, operating systems, and network conditions.', 'easy');

-- Database Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(9, 'What is database testing?', 'Testing database performance', 'Testing database security', 'Testing data integrity, accuracy, and consistency', 'Testing database backup', 'C', 'Database testing involves verifying data integrity, accuracy, and consistency in the database.', 'easy'),
(9, 'What is data validation testing?', 'Testing data types', 'Testing data accuracy and completeness', 'Testing data security', 'Testing data backup', 'B', 'Data validation testing ensures that data is accurate, complete, and meets specified requirements.', 'medium'),
(9, 'What is SQL testing?', 'Testing SQL syntax', 'Testing database queries and stored procedures', 'Testing database performance', 'Testing database security', 'B', 'SQL testing involves testing database queries, stored procedures, and database operations.', 'medium'),
(9, 'What is referential integrity?', 'Data accuracy', 'Data consistency between related tables', 'Data security', 'Data backup', 'B', 'Referential integrity ensures that relationships between tables remain consistent.', 'medium'),
(9, 'What is ACID in database testing?', 'A testing tool', 'Database properties (Atomicity, Consistency, Isolation, Durability)', 'A database type', 'A testing framework', 'B', 'ACID properties ensure reliable database transactions: Atomicity, Consistency, Isolation, and Durability.', 'hard');

-- Agile Testing
INSERT INTO questions (category_id, question_text, option_a, option_b, option_c, option_d, correct_answer, explanation, difficulty_level) VALUES
(10, 'What is Agile testing?', 'Testing without planning', 'Testing approach that follows Agile principles', 'Testing only at the end', 'Testing without documentation', 'B', 'Agile testing is a testing approach that follows Agile principles and practices.', 'easy'),
(10, 'What is continuous testing?', 'Testing continuously without breaks', 'Testing integrated into the development pipeline', 'Testing only in production', 'Testing without automation', 'B', 'Continuous testing is the process of testing integrated into the development pipeline to provide immediate feedback.', 'medium'),
(10, 'What is test-driven development (TDD)?', 'Writing tests after development', 'Writing tests before development', 'Writing tests during development', 'Writing tests without development', 'B', 'TDD is a development approach where tests are written before the actual code.', 'medium'),
(10, 'What is behavior-driven development (BDD)?', 'A testing framework', 'A development approach using natural language', 'A programming language', 'A database', 'B', 'BDD is a development approach that uses natural language to describe software behavior.', 'medium'),
(10, 'What is the role of a tester in Agile teams?', 'Only manual testing', 'Only automated testing', 'Active participation throughout the development cycle', 'Only testing at the end', 'C', 'In Agile teams, testers actively participate throughout the development cycle, not just at the end.', 'easy');
