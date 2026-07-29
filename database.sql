CREATE DATABASE IF NOT EXISTS namaa_campus_events
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE namaa_campus_events;

DROP TABLE IF EXISTS registrations;
DROP TABLE IF EXISTS events;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(150) NOT NULL,
    short_description VARCHAR(300) NOT NULL,
    full_description TEXT NOT NULL,
    image VARCHAR(180) NOT NULL,
    available_seats INT NOT NULL DEFAULT 0,
    organizer VARCHAR(150) NOT NULL,
    registration_deadline DATE NOT NULL,
    intended_audience VARCHAR(180) NOT NULL,
    featured TINYINT(1) NOT NULL DEFAULT 0
);

CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    student_id VARCHAR(20) NOT NULL,
    email VARCHAR(120) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    college VARCHAR(100) NOT NULL,
    academic_level VARCHAR(40) NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_namaa_registration_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

INSERT INTO events
(title, category, event_date, event_time, location, short_description, full_description, image, available_seats, organizer, registration_deadline, intended_audience, featured)
VALUES
(
    'Arabic Calligraphy for Digital Interfaces',
    'Design and Culture',
    '2026-07-24',
    '10:00:00',
    'College of Design Project Room',
    'A practical session on using Arabic calligraphy ideas in simple digital interface designs.',
    'Students will examine readable Arabic letterforms, spacing, visual balance, and suitable use of decorative styles in digital screens. The activity includes a small interface sketch that combines a heading, navigation labels, and a cultural visual element without reducing usability.',
    'images/calligraphy-ui.svg',
    30,
    'Visual Communication Club',
    '2026-07-23',
    'Design, media, computing, and Arabic language students',
    1
),
(
    'Saudi Food Heritage Documentation Day',
    'Heritage and Media',
    '2026-07-27',
    '13:00:00',
    'Qassim Cultural Activities Studio',
    'Students document local dishes through short interviews, notes, photographs, and recipe histories.',
    'Participants will work in groups to prepare a small record about a Saudi dish or food tradition. The activity covers respectful interviewing, source notes, image permissions, regional differences, and writing a clear description for a student archive.',
    'images/food-heritage.svg',
    42,
    'Saudi Heritage Society',
    '2026-07-25',
    'Students interested in culture, media, tourism, and local history',
    0
),
(
    'Introduction to Drone Mapping',
    'Engineering Technology',
    '2026-07-29',
    '09:30:00',
    'Dammam Engineering Workshop',
    'An introductory demonstration of how aerial images can support mapping and site inspection.',
    'The session explains basic flight planning, image overlap, safety rules, and how captured photographs can be combined into a simple map. Students will review a prepared dataset; no unsupervised drone operation is included.',
    'images/drone-mapping.svg',
    36,
    'Geomatics and Engineering Group',
    '2026-07-28',
    'Engineering, geography, environmental science, and computing students',
    0
),
(
    'Campus Mental Wellbeing Conversation',
    'Wellbeing',
    '2026-07-31',
    '16:00:00',
    'Student Wellbeing Center',
    'A moderated student conversation about study pressure, routines, and available university support.',
    'The session provides a respectful space to discuss common academic pressures, healthy routines, peer support, and when to contact professional university services. It is an awareness activity and does not provide diagnosis or individual treatment.',
    'images/wellbeing.svg',
    45,
    'Student Wellbeing Center',
    '2026-07-30',
    'All currently enrolled students',
    0
),
(
    'Accessible Web Design Practice',
    'Digital Skills',
    '2026-08-02',
    '11:00:00',
    'Digital Skills Laboratory',
    'A beginner workshop on creating clearer web pages for keyboard and screen-reader users.',
    'Students will improve a small HTML page by fixing heading order, labels, alternative text, colour contrast, link wording, and keyboard focus. The examples use basic HTML and CSS so participants can explain every change.',
    'images/accessibility.svg',
    34,
    'Web Development Society',
    '2026-08-01',
    'Computing, information systems, and design students',
    0
),
(
    'Desert Plant Identification Walk',
    'Environment',
    '2026-08-04',
    '07:30:00',
    'Abha Environmental Field Center',
    'A supervised morning walk introducing selected native and drought-tolerant plant species.',
    'Participants will observe plant shape, leaf features, habitat, and water adaptation. The facilitator will also discuss safe field behaviour, photography notes, and why native plants are useful in local landscaping projects.',
    'images/desert-plants.svg',
    28,
    'Environmental Studies Club',
    '2026-08-02',
    'Students interested in biology, environment, agriculture, or landscape design',
    0
),
(
    'Mobile Video Reporting Workshop',
    'Media Production',
    '2026-08-06',
    '14:30:00',
    'Jeddah Creative Media Room',
    'A hands-on workshop for planning and recording a short campus report using a mobile phone.',
    'Students will practise writing a simple opening, choosing stable shots, recording clear audio, asking concise interview questions, and arranging clips into a short sequence. The focus is responsible student reporting rather than advanced editing.',
    'images/mobile-reporting.svg',
    32,
    'University News Team',
    '2026-08-05',
    'Media, communication, marketing, and interested beginner students',
    0
),
(
    'Cloud Computing Career Panel',
    'Professional Development',
    '2026-08-08',
    '17:00:00',
    'Al Khobar Business Innovation Room',
    'Professionals discuss entry-level cloud roles, certifications, projects, and workplace expectations.',
    'Panel members will explain common roles in cloud support, infrastructure, security, and data services. Students will hear how university projects, internships, and basic certifications can support a first job application.',
    'images/cloud-careers.svg',
    78,
    'Technology Careers Office',
    '2026-08-07',
    'Computing, cybersecurity, data science, and information systems students',
    0
),
(
    'Student Debate on Sustainable Cities',
    'Student Dialogue',
    '2026-08-10',
    '15:00:00',
    'Madinah Student Dialogue Hall',
    'Two student teams discuss transport, public spaces, energy use, and community priorities.',
    'The debate uses a prepared motion about sustainable urban development. Participants must support their points with examples, respond respectfully to the opposing team, and finish with one practical recommendation relevant to Saudi cities.',
    'images/sustainable-debate.svg',
    70,
    'Student Dialogue Forum',
    '2026-08-08',
    'Students interested in public policy, cities, environment, and communication',
    0
),
(
    'Emergency Planning for Club Leaders',
    'Safety and Leadership',
    '2026-08-12',
    '10:30:00',
    'Main Library Seminar Room',
    'A planning session on contacts, responsibilities, crowd movement, and incident reporting.',
    'Student club leaders will prepare a basic event safety checklist covering emergency contacts, room capacity, evacuation routes, weather concerns, attendee communication, and post-incident reporting. The session stays at an introductory organisational level.',
    'images/emergency-planning.svg',
    40,
    'Student Activities Administration',
    '2026-08-11',
    'Club presidents, committee members, and student event organisers',
    0
),
(
    'Arabic CV Writing Clinic',
    'Career Skills',
    '2026-08-14',
    '12:00:00',
    'Riyadh Learning Commons',
    'A review clinic for improving Arabic CV structure, wording, consistency, and readability.',
    'Students may bring a draft CV and receive guidance on profile summaries, education, experience, projects, skills, and formatting. The clinic also addresses translation consistency and avoiding vague claims without evidence.',
    'images/arabic-cv.svg',
    35,
    'Graduate Preparation Unit',
    '2026-08-13',
    'Students preparing internship, cooperative training, or graduate applications',
    0
),
(
    'University Book Exchange Day',
    'Community Activity',
    '2026-08-16',
    '11:00:00',
    'University Central Courtyard',
    'Students exchange suitable academic and general-interest books through an organised campus table.',
    'Participants may bring clean books in good condition and exchange them according to the event guidelines. Volunteers will organise books by subject and help maintain a simple record of contributed and collected items.',
    'images/book-exchange.svg',
    120,
    'Reading and Community Club',
    '2026-08-15',
    'All students and university staff',
    0
),
(
    'Local Business Data Challenge',
    'Business Analytics',
    '2026-08-18',
    '09:00:00',
    'Al Khobar Business Innovation Room',
    'Teams analyse a small fictional retail dataset and present one practical business recommendation.',
    'The challenge includes sales, products, branches, and customer feedback data. Teams will clean selected values, calculate simple measures, prepare one useful chart, and explain a recommendation without using advanced analytical tools.',
    'images/business-data.svg',
    50,
    'Business Analytics Club',
    '2026-08-16',
    'Business, data science, information systems, and computing students',
    0
),
(
    'Renewable Energy Model Exhibition',
    'Science and Innovation',
    '2026-08-20',
    '13:30:00',
    'Dammam Engineering Workshop',
    'Student groups display small models related to solar power, energy storage, and efficient buildings.',
    'Each group will explain the purpose of its model, materials used, basic operating idea, limitations, and possible Saudi application. Projects should be safe, low-voltage, and suitable for classroom demonstration.',
    'images/renewable-energy.svg',
    95,
    'Engineering Innovation Society',
    '2026-08-18',
    'Engineering, science, architecture, and sustainability students',
    0
);
