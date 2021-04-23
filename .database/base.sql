/* CREATES */

CREATE TABLE `user` (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    email VARCHAR(100) NOT NULL,
    `password` CHAR(32) NOT NULL,
    confirmed BOOLEAN  NOT NULL DEFAULT FALSE,
    confirmation_id CHAR(32) DEFAULT NULL,
    reset_password_id CHAR(32) DEFAULT NULL,
    UNIQUE (email)
); /* OK */

CREATE TABLE palette (
    id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(15) NOT NULL,
    first_color CHAR(6) NOT NULL,
    second_color CHAR(6) NOT NULL,
    third_color CHAR(6) NOT NULL
); /* OK */

CREATE TABLE project_type (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    image VARCHAR(80) NOT NULL,
    base_url VARCHAR(100) NOT NULL
); /* OK */

CREATE TABLE professional (
	user_id BIGINT PRIMARY KEY NOT NULL,
    name VARCHAR(50) NOT NULL,
    username VARCHAR(32) NOT NULL,
    description VARCHAR(620),
    goal VARCHAR(100),
    phone VARCHAR(14) NOT NULL,
    github VARCHAR(60),
    linkedin VARCHAR(40),
    site VARCHAR(60),
    picture VARCHAR(80),
    access_count BIGINT DEFAULT 0,
    palette_id BIGINT DEFAULT 1,
    FOREIGN KEY(user_id) references `user`(id),
    FOREIGN KEY(palette_id) references palette(id),
    UNIQUE (username)
); /* OK */

CREATE TABLE trivia (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    professional_user_id BIGINT NOT NULL,
    `value` VARCHAR(100) NOT NULL,
    FOREIGN KEY (professional_user_id) REFERENCES professional(user_id)
); /* OK */

CREATE TABLE graduation (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    professional_user_id BIGINT NOT NULL,
    title VARCHAR(100) NOT NULL,
    institution VARCHAR(100) NOT NULL,
    start_period DATE NOT NULL,
    end_period DATE,
    image VARCHAR(80),
    visible BOOLEAN DEFAULT true,
    FOREIGN KEY(professional_user_id) references professional(user_id)
); /* OK */

CREATE TABLE `work` (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    professional_user_id BIGINT NOT NULL,
    position VARCHAR(50) NOT NULL,
    company VARCHAR(100) NOT NULL,
    description VARCHAR(300) NOT NULL,
    start_period DATE NOT NULL,
    end_period DATE,
    image VARCHAR(80),
    visible BOOLEAN DEFAULT true,
    FOREIGN KEY(professional_user_id) references professional(user_id)
); /* OK */

CREATE TABLE project (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
	professional_user_id BIGINT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description VARCHAR(300) NOT NULL,
    image VARCHAR(80),
    visible BOOLEAN DEFAULT true,
    FOREIGN KEY(professional_user_id) references professional(user_id)
); /* OK */

CREATE TABLE project_link (
	id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    project_id BIGINT NOT NULL,
    project_type_id BIGINT NOT NULL,
    url VARCHAR(100) NOT NULL,
    FOREIGN KEY(project_id) references project(id),
    FOREIGN KEY(project_type_id) references project_type(id)
); /* OK */

CREATE TABLE skill(
    id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    entry_count TINYINT NOT NULL
);

CREATE TABLE skill_confirmed(
    id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (id) REFERENCES skill(id)
);

CREATE TABLE skill_professional(
    skill_id BIGINT NOT NULL,
    professional_id BIGINT NOT NULL,
    percentage TINYINT NOT NULL,
    visible BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (skill_id, professional_id),
    FOREIGN KEY (skill_id) REFERENCES skill(id),
    FOREIGN KEY (professional_id) REFERENCES professional(user_id)
);

CREATE TABLE access_log (
    id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    professional_user_id BIGINT NOT NULL,
    access_date TIMESTAMP NOT NULL,
    FOREIGN KEY (professional_user_id) REFERENCES professional(user_id)
); /* OK */

/* INSERTS */

INSERT INTO palette(
    id, name, first_color, second_color, third_color
) VALUES (
    1, 'autumn', 'D48A6E', 'BD5D38', '824027'
), (
    2, 'forest', 'ABB557', '8B9556', '756D54'
), (
    3, 'nude', 'FFC9B5', 'F7B1AB', 'D8AA96'
), (
    4, 'purple-haze', 'D90368', '820263', '291720'
), (
    5, 'summer', 'F3CA40', 'F2A541', 'F08A4B'
), (
    6, 'unicorn', '9EA9F0', 'A773C3', '553C8B'
), (
    7, 'winter', '81C3D7', '2F6690', '16425B'
);

INSERT INTO project_type(
    id, name, image, base_url
) VALUES
(1, 'Google Play', 'android.png', 'https://play.google.com/store/apps/details?id='),
(2, 'App Store', 'ios.png', 'https://apps.apple.com/br/app/'),
(3, 'Website', 'web.png', 'https://'),
(4, 'Github', 'github.png', 'https://www.github.com/'),
(5, 'Bitbucket', 'bitbucket.png', 'https://bitbucket.org/'),
(6, 'Jitpack', 'jitpack.png', 'https://jitpack.io/'),
(7, 'Gitlab', 'gitlab.png', 'https://gitlab.com/');

INSERT INTO skill (
    id, name, entry_count
) VALUES
(1, 'Java', 15),
(2, 'Kotlin', 15),
(3, 'Swift', 15),
(4, 'HTML', 15),
(5, 'CSS', 15),
(6, 'jQuery', 15),
(7, 'JavaScript', 15),
(8, 'PHP', 15),
(9, 'Spring', 15),
(10, 'node.js', 15),
(11, 'Oracle', 15),
(12, 'MySQL', 15),
(13, 'SQLite', 15),
(14, 'C', 15),
(15, 'Python', 15),
(16, 'C++', 15),
(17, 'C#', 15),
(18, 'Visual Basic', 15),
(19, '.Net', 15),
(20, 'R', 15),
(21, 'Go', 15),
(22, 'Perl', 15),
(23, 'Assembly', 15),
(24, 'Ruby', 15),
(25, 'Groovy', 15),
(26, 'Objective-C', 15),
(27, 'Rust', 15),
(28, 'Sass', 15),
(29, 'Less', 15),
(30, 'Gulp.js', 15),
(31, 'AWS', 15),
(32, 'Firebase', 15),
(33, 'Azure', 15),
(34, 'PL/SQL', 15),
(35, 'Dart', 15),
(36, 'Flutter', 15),
(37, 'Ionic', 15),
(38, 'React Native', 15),
(39, 'React JS', 15),
(40, 'Angular JS', 15),
(41, 'Vue JS', 15),
(42, 'Cordova', 15),
(43, 'Xamarin', 15),
(44, 'Delphi', 15),
(45, 'COBOL', 15),
(46, 'Deno', 15),
(47, 'Scala', 15),
(48, 'Prolog', 15),
(49, 'Lisp', 15),
(50, 'Lua', 15),
(51, 'Fortran', 15),
(52, 'Haskell', 15),
(53, 'TypeScript', 15),
(54, 'Bash', 15),
(55, 'Shell', 15),
(56, 'Clojure', 15),
(57, 'OCaml', 15),
(58, 'Elixir', 15),
(59, 'Erlang', 15),
(60, 'OpenCL', 15),
(61, 'PostgreSQL', 15),
(62, 'SQL Server', 15),
(63, 'MongoDB', 15),
(64, 'Redis', 15),
(65, 'CouchDB', 15),
(66, 'Django', 15),
(67, 'Laravel', 15),
(68, 'CakePHP', 15),
(69, 'Symfony', 15),
(70, 'Composer', 15),
(71, 'Gradle', 15),
(72, 'CodeIgniter', 15),
(73, 'Scrum', 15),
(74, 'Kanban', 15),
(75, 'Git', 15),
(76, 'Android', 15),
(77, 'iOS', 15);

INSERT INTO skill_confirmed (
    id, name
) VALUES
(1, 'Java'),
(2, 'Kotlin'),
(3, 'Swift'),
(4, 'HTML'),
(5, 'CSS'),
(6, 'jQuery'),
(7, 'JavaScript'),
(8, 'PHP'),
(9, 'Spring'),
(10, 'node.js'),
(11, 'Oracle'),
(12, 'MySQL'),
(13, 'SQLite'),
(14, 'C'),
(15, 'Python'),
(16, 'C++'),
(17, 'C#'),
(18, 'Visual Basic'),
(19, '.Net'),
(20, 'R'),
(21, 'Go'),
(22, 'Perl'),
(23, 'Assembly'),
(24, 'Ruby'),
(25, 'Groovy'),
(26, 'Objective-C'),
(27, 'Rust'),
(28, 'Sass'),
(29, 'Less'),
(30, 'Gulp.js'),
(31, 'AWS'),
(32, 'Firebase'),
(33, 'Azure'),
(34, 'PL/SQL'),
(35, 'Dart'),
(36, 'Flutter'),
(37, 'Ionic'),
(38, 'React Native'),
(39, 'React JS'),
(40, 'Angular JS'),
(41, 'Vue JS'),
(42, 'Cordova'),
(43, 'Xamarin'),
(44, 'Delphi'),
(45, 'COBOL'),
(46, 'Deno'),
(47, 'Scala'),
(48, 'Prolog'),
(49, 'Lisp'),
(50, 'Lua'),
(51, 'Fortran'),
(52, 'Haskell'),
(53, 'TypeScript'),
(54, 'Bash'),
(55, 'Shell'),
(56, 'Clojure'),
(57, 'OCaml'),
(58, 'Elixir'),
(59, 'Erlang'),
(60, 'OpenCL'),
(61, 'PostgreSQL'),
(62, 'SQL Server'),
(63, 'MongoDB'),
(64, 'Redis'),
(65, 'CouchDB'),
(66, 'Django'),
(67, 'Laravel'),
(68, 'CakePHP'),
(69, 'Symfony'),
(70, 'Composer'),
(71, 'Gradle'),
(72, 'CodeIgniter'),
(73, 'Scrum'),
(74, 'Kanban'),
(75, 'Git'),
(76, 'Android'),
(77, 'iOS');

/* VIEWS */
CREATE VIEW v_professional_user_dashboard (
	id, email, username, name, description, goal, phone, github, linkedin, site, picture, access_count, palette
) AS
SELECT P.user_id, U.email, P.username, P.name, P.description, P.goal, P.phone, P.github, P.linkedin, P.site, P.picture, P.access_count, PA.id
FROM `user` AS U
INNER JOIN professional AS P
ON U.id = P.user_id
INNER JOIN palette as PA
ON P.palette_id = PA.id;

CREATE VIEW v_project_link_type (
	id, project_id, type_id, base_url, url, type, image
) AS
SELECT L.id, L.project_id, T.id, T.base_url, L.url, T.name, T.image from project_link AS L
INNER JOIN project_type AS T
ON L.project_type_id = T.id;

CREATE VIEW v_skill (
    skill_id, professional_id, name, percentage, visible
) AS
SELECT SP.skill_id, SP.professional_id, S.name, SP.percentage, SP.visible
FROM skill AS S
INNER JOIN skill_professional AS SP
ON S.id = SP.skill_id
INNER JOIN professional AS P
ON SP.professional_id = P.user_id;

CREATE VIEW v_access_year (
    user_id, year, month, total
) AS
SELECT professional_user_id AS user_id, YEAR(access_date) AS year, MONTH(access_date) AS month, COUNT(*) AS total
FROM access_log
WHERE access_date > DATE(NOW()) - INTERVAL 1 YEAR
GROUP BY year, month, professional_user_id
ORDER BY year DESC, month DESC;

/* TRIGGERS */

DELIMITER $

CREATE TRIGGER updateUsername
BEFORE INSERT ON professional
FOR EACH ROW BEGIN
    DECLARE usrId BIGINT;
    DECLARE usrCount INT;
    DECLARE mail VARCHAR(100);
    DECLARE usrnm VARCHAR(32);

    SET usrId = NEW.user_id;

    SELECT email INTO mail
    FROM user
    WHERE id = usrId;

    SET usrnm = SUBSTRING_INDEX(mail, '@', 1);

    SELECT COUNT(*) INTO usrCount
    FROM professional
    WHERE `username` LIKE CONCAT(usrnm, '%');

    IF (usrCount <> 0) THEN
        SET usrnm = CONCAT(usrnm, '_', usrCount);
    END IF;

    SET NEW.username = usrnm;
END$

CREATE TRIGGER registerAccess
BEFORE UPDATE ON professional
FOR EACH ROW BEGIN
    DECLARE usrId BIGINT;

    IF (NEW.access_count IS NOT NULL AND OLD.access_count <> NEW.access_count) THEN
        SET usrId = OLD.user_id;

        INSERT INTO `access_log` (
            `professional_user_id`
        ) VALUES (
            usrId
        );
    END IF;
END$

CREATE TRIGGER persistentSkill
AFTER UPDATE ON skill
FOR EACH ROW BEGIN
    DECLARE skillCount INT;

    SELECT COUNT(*) INTO skillCount
    FROM skill_confirmed
    WHERE id = NEW.id;

    IF (NEW.entry_count >= 15 AND skillCount = 0) THEN
        INSERT INTO skill_confirmed(id, name) VALUES (NEW.id, NEW.name);
    END IF;
END$

DELIMITER ;
