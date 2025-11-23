CREATE DATABASE IF NOT EXISTS its_db;

USE its_db;


-- CREATE TABLE role (

--   role_name VARCHAR(50) PRIMARY KEY,

--   default_permission TEXT

-- ) ENGINE=InnoDB;



CREATE TABLE `user` (

  user_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  email VARCHAR(255) NOT NULL UNIQUE,

  password VARCHAR(255) NOT NULL,

  name VARCHAR(200),

  role ENUM('Student', 'Teacher', 'Admin'),

  is_active BOOLEAN DEFAULT 1,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP

) ENGINE=InnoDB;



CREATE TABLE student (

  user_id BIGINT PRIMARY KEY,

  enrollment_year SMALLINT,

  major VARCHAR(150),

  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE

) ENGINE=InnoDB;


CREATE TABLE teacher (

  user_id BIGINT PRIMARY KEY,

  honorific_title VARCHAR(50),


  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE



) ENGINE=InnoDB;



CREATE TABLE admin (

  user_id BIGINT PRIMARY KEY,

  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE

) ENGINE=InnoDB;



CREATE TABLE course (

  course_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  title VARCHAR(255) NOT NULL,

  description TEXT,

  password VARCHAR(255),

  created_by BIGINT NOT NULL,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_course_created_by FOREIGN KEY (created_by) REFERENCES teacher(user_id) ON DELETE RESTRICT

) ENGINE=InnoDB;



CREATE TABLE unit (

  unit_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  course_id BIGINT NOT NULL,

  title VARCHAR(255) NOT NULL,

  description TEXT,

  order_index INT DEFAULT 1,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (course_id) REFERENCES course(course_id) ON DELETE CASCADE,

  INDEX (course_id, order_index)

) ENGINE=InnoDB;



CREATE TABLE content_item (

  content_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  unit_id BIGINT NULL,

  title VARCHAR(255) NOT NULL,

  content_type VARCHAR(50),

  body MEDIUMTEXT,

  attachments TEXT,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (unit_id) REFERENCES unit(unit_id) ON DELETE SET NULL,

  INDEX (unit_id, content_type)

) ENGINE=InnoDB;



CREATE TABLE assessment (

  assessment_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  title VARCHAR(255) NOT NULL,

  description TEXT,

  max_score INT,

  time_limit_seconds INT,

  passing_score DECIMAL(5,2),

  unit_id BIGINT NULL,

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (unit_id) REFERENCES unit(unit_id) ON DELETE SET NULL

) ENGINE=InnoDB;



CREATE TABLE question_type (

  type_name VARCHAR(50) PRIMARY KEY,

  description TEXT

) ENGINE=InnoDB;



CREATE TABLE question (

  question_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  body TEXT NOT NULL,

  type VARCHAR(50),

  correct_answer TEXT,

  max_points DECIMAL(7,2),

  difficulty VARCHAR(50),

  assessment_id BIGINT NOT NULL,

  FOREIGN KEY (assessment_id) REFERENCES assessment(assessment_id) ON DELETE CASCADE,

FOREIGN KEY (type) REFERENCES question_type(type_name) ON DELETE CASCADE,

  INDEX (assessment_id)

) ENGINE=InnoDB;





CREATE TABLE enrollment (

  student_id BIGINT NOT NULL,

  course_id BIGINT NOT NULL,

  progress DECIMAL(5,2) DEFAULT 0,

  PRIMARY KEY (student_id, course_id),

  FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,

  FOREIGN KEY (course_id) REFERENCES course(course_id) ON DELETE CASCADE

) ENGINE=InnoDB;



CREATE TABLE attempt (

  attempt_id BIGINT NOT NULL PRIMARY KEY,

  student_id BIGINT NOT NULL,

  assessment_id BIGINT NOT NULL,

  started_at DATETIME,

  finished_at DATETIME,

  score DECIMAL(7,2),

  FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,

  FOREIGN KEY (assessment_id) REFERENCES assessment(assessment_id) ON DELETE CASCADE,

  INDEX (student_id, assessment_id)

) ENGINE=InnoDB;



CREATE TABLE admin_feedback (

  feedback_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  message TEXT NOT NULL,

  admin_id BIGINT NOT NULL,

  source_type VARCHAR(50),

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (admin_id) REFERENCES `admin`(user_id) ON DELETE RESTRICT

) ENGINE=InnoDB;



CREATE TABLE teacher_feedback (

  feedback_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  message TEXT NOT NULL,

  teacher_id BIGINT NOT NULL,

  source_type VARCHAR(50),

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (teacher_id) REFERENCES `teacher`(user_id) ON DELETE RESTRICT

) ENGINE=InnoDB;



CREATE TABLE admin_feedback_recipient (

  feedback_id BIGINT NOT NULL,

  student_id BIGINT NOT NULL,

  PRIMARY KEY (feedback_id, student_id),

  FOREIGN KEY (feedback_id) REFERENCES admin_feedback(feedback_id) ON DELETE CASCADE,

  FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,

  INDEX (student_id)

) ENGINE=InnoDB;



CREATE TABLE teacher_feedback_recipient (

  feedback_id BIGINT NOT NULL,

  student_id BIGINT NOT NULL,

  PRIMARY KEY (feedback_id, student_id),

  FOREIGN KEY (feedback_id) REFERENCES teacher_feedback(feedback_id) ON DELETE CASCADE,

  FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,

  INDEX (student_id)

) ENGINE=InnoDB;



CREATE TABLE badge (

  badge_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  code VARCHAR(100) NOT NULL UNIQUE,

  title VARCHAR(255),

  description TEXT,

  criteria TEXT

) ENGINE=InnoDB;



CREATE TABLE student_badge (

  student_id BIGINT NOT NULL,

  badge_id BIGINT NOT NULL,

  awarded_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  reason VARCHAR(500),

  PRIMARY KEY (student_id, badge_id),

  FOREIGN KEY (student_id) REFERENCES student(user_id) ON DELETE CASCADE,

  FOREIGN KEY (badge_id) REFERENCES badge(badge_id) ON DELETE CASCADE

) ENGINE=InnoDB;



CREATE TABLE event_type (

  type_name VARCHAR(150) PRIMARY KEY,

  description TEXT

) ENGINE=InnoDB;



CREATE TABLE event_log (

  event_id BIGINT AUTO_INCREMENT PRIMARY KEY,

  user_id BIGINT NOT NULL,

  type VARCHAR(150),

  event_data TEXT,

  occurred_at DATETIME DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES `user`(user_id) ON DELETE CASCADE,

 FOREIGN KEY (type) REFERENCES `event_type`(type_name) ON DELETE CASCADE,

  INDEX (user_id, occurred_at)

) ENGINE=InnoDB;



INSERT INTO role (role_name) VALUES
('admin'),
('teacher'),
('student');


INSERT INTO `user` (email, password, name, role, is_active, created_at) VALUES
('nguyen.ha01@gmail.com', 'NgH@2025#01', 'Nguyễn Hà My', 'teacher', 0, CURRENT_TIMESTAMP),
('tran.khoa02@gmail.com', 'TrK#2025!02', 'Trần Khoa Học', 'teacher', 0, CURRENT_TIMESTAMP),
('le.tuan03@gmail.com', 'LeT!2025#03', 'Lê Tuấn Kiệt', 'teacher', 0, CURRENT_TIMESTAMP),
('pham.hoang04@gmail.com', 'PhH@2025#04', 'Phạm Hoàng Nam', 'teacher', 0, CURRENT_TIMESTAMP),
('hoang.minh05@gmail.com', 'HoM#2025!05', 'Hoàng Minh Châu', 'teacher', 0, CURRENT_TIMESTAMP),
('vu.thao06@gmail.com', 'VuT!2025#06', 'Vũ Thị Thảo', 'teacher', 0, CURRENT_TIMESTAMP),
('dang.hieu07@gmail.com', 'DaH#2025!07', 'Đặng Hiếu Trung', 'teacher', 0, CURRENT_TIMESTAMP),
('bui.linh08@gmail.com', 'BuL!2025#08', 'Bùi Linh Đan', 'teacher', 0, CURRENT_TIMESTAMP),
('do.hung99@gmail.com', 'DoH@2025#09', 'Đỗ Hùng Cường', 'teacher', 0, CURRENT_TIMESTAMP),
('ngo.quynh10@gmail.com', 'NgQ#2025!10', 'Ngô Quỳnh Như', 'teacher', 0, CURRENT_TIMESTAMP),
('nguyen.an11@gmail.com', 'NgA!2025#11', 'Nguyễn An Nhiên', 'teacher', 0, CURRENT_TIMESTAMP),
('tran.viet12@gmail.com', 'TrV#2025!12', 'Trần Việt Hưng', 'teacher', 0, CURRENT_TIMESTAMP),
('le.hanh13@gmail.com', 'LeH!2025#13', 'Lê Hạnh Dung', 'teacher', 0, CURRENT_TIMESTAMP),
('pham.khanh84@gmail.com', 'PhK#2025!14', 'Phạm Khánh Linh', 'teacher', 0, CURRENT_TIMESTAMP),
('hoang.tam15@gmail.com', 'HoT!2025#15', 'Hoàng Tâm Đức', 'teacher', 0, CURRENT_TIMESTAMP),
('vu.trang86@gmail.com', 'VuT#2025!16', 'Vũ Thị Trang', 'teacher', 0, CURRENT_TIMESTAMP),
('dang.son67@gmail.com', 'DaS!2025#17', 'Đặng Sơn Tùng', 'teacher', 0, CURRENT_TIMESTAMP),
('bui.mai08@gmail.com', 'BuM#2025!18', 'Bùi Mai Phương', 'teacher', 0, CURRENT_TIMESTAMP),
('do.tien09@gmail.com', 'DoT!2025#19', 'Đỗ Tiến Đạt', 'teacher', 0, CURRENT_TIMESTAMP),
('ngo.hoa90@gmail.com', 'NgH#2025!20', 'Ngô Hoà Bình', 'teacher', 0, CURRENT_TIMESTAMP),
('nguyen.huy01@gmail.com','NgHuy!2501','Nguyễn Huy Hoàng','student', 0,CURRENT_TIMESTAMP),
('tran.minh02@gmail.com','TrMinh#2502','Trần Minh Tuấn','student', 0,CURRENT_TIMESTAMP),
('le.khoa03@gmail.com','LeKhoa$2503','Lê Khoa Đăng','student', 0,CURRENT_TIMESTAMP),
('pham.hanh04@gmail.com','PhHanh%2504','Phạm Hạnh Dung','student', 0,CURRENT_TIMESTAMP),
('hoang.tam05@gmail.com','HoTam&2505','Hoàng Tâm Anh','student', 0,CURRENT_TIMESTAMP),
('vu.phuc06@gmail.com','VuPhuc*2506','Vũ Phúc Hưng','student', 0,CURRENT_TIMESTAMP),
('dang.quan07@gmail.com','DaQuan!2507','Đặng Quân Minh','student', 0,CURRENT_TIMESTAMP),
('bui.linh88@gmail.com','BuLinh#2508','Bùi Linh Chi','student', 0,CURRENT_TIMESTAMP),
('do.hung09@gmail.com','DoHung$2509','Đỗ Hùng Sơn','student', 0,CURRENT_TIMESTAMP),
('ngo.bich10@gmail.com','NgBich%2510','Ngô Bích Ngọc','student', 0,CURRENT_TIMESTAMP),
('nguyen.hoa11@gmail.com','NgHoa&2511','Nguyễn Hoà Bình','student', 0,CURRENT_TIMESTAMP),
('tran.hieu12@gmail.com','TrHieu*2512','Trần Hiếu Trung','student', 0,CURRENT_TIMESTAMP),
('le.thao13@gmail.com','LeThao!2513','Lê Thảo Vy','student', 0,CURRENT_TIMESTAMP),
('pham.khanh14@gmail.com','PhKhanh#2514','Phạm Khánh Linh','student', 0,CURRENT_TIMESTAMP),
('hoang.anh15@gmail.com','HoAnh$2515','Hoàng Anh Tuấn','student', 0,CURRENT_TIMESTAMP),
('vu.trang16@gmail.com','VuTrang%2516','Vũ Thị Trang','student', 0,CURRENT_TIMESTAMP),
('dang.son17@gmail.com','DaSon&2517','Đặng Sơn Tùng','student', 0,CURRENT_TIMESTAMP),
('bui.mai18@gmail.com','BuMai*2518','Bùi Mai Phương','student', 0,CURRENT_TIMESTAMP),
('do.tien19@gmail.com','DoTien!2519','Đỗ Tiến Đạt','student', 0,CURRENT_TIMESTAMP),
('ngo.hoa20@gmail.com','NgHoa#2520','Ngô Hoà Bình','student', 0,CURRENT_TIMESTAMP),
('nguyen.khanh21@gmail.com','NgKhanh$2521','Nguyễn Khánh Vũ','student', 0,CURRENT_TIMESTAMP),
('tran.minh22@gmail.com','TrMinh%2522','Trần Minh Khang','student', 0,CURRENT_TIMESTAMP),
('le.hoang23@gmail.com','LeHoang&2523','Lê Hoàng Nam','student', 0,CURRENT_TIMESTAMP),
('pham.thi24@gmail.com','PhThi*2524','Phạm Thị Lan','student', 0,CURRENT_TIMESTAMP),
('hoang.quy25@gmail.com','HoQuy!2525','Hoàng Quý An','student', 0,CURRENT_TIMESTAMP),
('vu.ngoc26@gmail.com','VuNgoc#2526','Vũ Ngọc Bảo','student', 0,CURRENT_TIMESTAMP),
('dang.lan27@gmail.com','DaLan$2527','Đặng Lan Phương','student', 0,CURRENT_TIMESTAMP),
('bui.hung28@gmail.com','BuHung%2528','Bùi Hùng Cường','student', 0,CURRENT_TIMESTAMP),
('do.nhi29@gmail.com','DoNhi&2529','Đỗ Như Ý','student', 0,CURRENT_TIMESTAMP),
('ngo.quoc30@gmail.com','NgQuoc*2530','Ngô Quốc Huy','student', 0,CURRENT_TIMESTAMP),
('nguyen.tuan31@gmail.com','NgTuan!2531','Nguyễn Tuấn Kiệt','student', 0,CURRENT_TIMESTAMP),
('tran.thuy32@gmail.com','TrThuy#2532','Trần Thùy Dương','student', 0,CURRENT_TIMESTAMP),
('le.thanh33@gmail.com','LeThanh$2533','Lê Thanh Tùng','student', 0,CURRENT_TIMESTAMP),
('pham.diep34@gmail.com','PhDiep%2534','Phạm Diệp My','student', 0,CURRENT_TIMESTAMP),
('hoang.hieu35@gmail.com','HoHieu&2535','Hoàng Hiếu Trung','student', 0,CURRENT_TIMESTAMP),
('vu.hang36@gmail.com','VuHang*2536','Vũ Hằng Nga','student', 0,CURRENT_TIMESTAMP),
('dang.ha37@gmail.com','DaHa!2537','Đặng Hà My','student', 0,CURRENT_TIMESTAMP),
('bui.kien38@gmail.com','BuKien#2538','Bùi Kiến Long','student', 0,CURRENT_TIMESTAMP),
('do.phuc39@gmail.com','DoPhuc$2539','Đỗ Phúc Lâm','student', 0,CURRENT_TIMESTAMP),
('ngo.hanh40@gmail.com','NgHanh%2540','Ngô Hạnh Thảo','student', 0,CURRENT_TIMESTAMP),
('nguyen.ha41@gmail.com','NgHa&2541','Nguyễn Hà My','student', 0,CURRENT_TIMESTAMP),
('tran.dang42@gmail.com','TrDang*2542','Trần Đăng Khoa','student', 0,CURRENT_TIMESTAMP),
('le.minh43@gmail.com','LeMinh!2543','Lê Minh Quân','student', 0,CURRENT_TIMESTAMP),
('pham.ngoc44@gmail.com','PhNgoc#2544','Phạm Ngọc Trân','student', 0,CURRENT_TIMESTAMP),
('hoang.nam45@gmail.com','HoNam$2545','Hoàng Nam Sơn','student', 0,CURRENT_TIMESTAMP),
('vu.tuan46@gmail.com','VuTuan%2546','Vũ Tuấn Anh','student', 0,CURRENT_TIMESTAMP),
('dang.nga47@gmail.com','DaNga&2547','Đặng Nga Phương','student', 0,CURRENT_TIMESTAMP),
('bui.phuc48@gmail.com','BuPhuc*2548','Bùi Phúc Hòa','student', 0,CURRENT_TIMESTAMP),
('do.hoa49@gmail.com','DoHoa!2549','Đỗ Hoa Khánh','student', 0,CURRENT_TIMESTAMP),
('ngo.lan50@gmail.com','NgLan#2550','Ngô Lan Anh','student', 0,CURRENT_TIMESTAMP),
('nguyen.bach51@gmail.com','NgBach$2551','Nguyễn Bách Khoa','student', 0,CURRENT_TIMESTAMP),
('tran.hoan52@gmail.com','TrHoan%2552','Trần Hoàn Phúc','student', 0,CURRENT_TIMESTAMP),
('le.trang53@gmail.com','LeTrang&2553','Lê Thị Trang','student', 0,CURRENT_TIMESTAMP),
('pham.anh54@gmail.com','PhAnh*2554','Phạm Anh Hải','student', 0,CURRENT_TIMESTAMP),
('hoang.quyen55@gmail.com','HoQuyen!2555','Hoàng Quyên Nhi','student', 0,CURRENT_TIMESTAMP),
('vu.hoang56@gmail.com','VuHoang#2556','Vũ Hoàng Gia','student', 0,CURRENT_TIMESTAMP),
('dang.hung57@gmail.com','DaHung$2557','Đặng Hùng Duy','student', 0,CURRENT_TIMESTAMP),
('bui.thi58@gmail.com','BuThi%2558','Bùi Thị Hồng','student', 0,CURRENT_TIMESTAMP),
('do.tu59@gmail.com','DoTu&2559','Đỗ Tú Anh','student', 0,CURRENT_TIMESTAMP),
('ngo.phuc60@gmail.com','NgPhuc*2560','Ngô Phúc Lợi','student', 0,CURRENT_TIMESTAMP),
('nguyen.loc61@gmail.com','NgLoc!2561','Nguyễn Lộc Vinh','student', 0,CURRENT_TIMESTAMP),
('tran.hieu62@gmail.com','TrHieu#2562','Trần Hiếu Bảo','student', 0,CURRENT_TIMESTAMP),
('le.quan63@gmail.com','LeQuan$2563','Lê Quang Hải','student', 0,CURRENT_TIMESTAMP),
('pham.tu64@gmail.com','PhTu%2564','Phạm Tú Anh','student', 0,CURRENT_TIMESTAMP),
('hoang.ha65@gmail.com','HoHa&2565','Hoàng Hà An','student', 0,CURRENT_TIMESTAMP),
('vu.khanh66@gmail.com','VuKhanh*2566','Vũ Khánh Duy','student', 0,CURRENT_TIMESTAMP),
('dang.nam67@gmail.com','DaNam!2567','Đặng Nam Phong','student', 0,CURRENT_TIMESTAMP),
('bui.truc68@gmail.com','BuTruc#2568','Bùi Trúc Vy','student', 0,CURRENT_TIMESTAMP),
('do.linh69@gmail.com','DoLinh$2569','Đỗ Linh Chi','student', 0,CURRENT_TIMESTAMP),
('ngo.duc70@gmail.com','NgDuc%2570','Ngô Đức Minh','student', 0,CURRENT_TIMESTAMP),
('nguyen.nhi71@gmail.com','NgNhi&2571','Nguyễn Như Quỳnh','student', 0,CURRENT_TIMESTAMP),
('tran.vinh72@gmail.com','TrVinh*2572','Trần Vĩnh Khang','student', 0,CURRENT_TIMESTAMP),
('le.huy73@gmail.com','LeHuy!2573','Lê Huy Đức','student', 0,CURRENT_TIMESTAMP),
('pham.ngan74@gmail.com','PhNgan#2574','Phạm Ngân Hà','student', 0,CURRENT_TIMESTAMP),
('hoang.tuyen75@gmail.com','HoTuyen$2575','Hoàng Tuyền','student', 0,CURRENT_TIMESTAMP),
('vu.trieu76@gmail.com','VuTrieu%2576','Vũ Triều An','student', 0,CURRENT_TIMESTAMP),
('dang.phu77@gmail.com','DaPhu&2577','Đặng Phú Quang','student', 0,CURRENT_TIMESTAMP),
('bui.hoai78@gmail.com','BuHoai*2578','Bùi Hoài Nam','student', 0,CURRENT_TIMESTAMP),
('do.anh79@gmail.com','DoAnh!2579','Đỗ Anh Minh','student', 0,CURRENT_TIMESTAMP),
('ngo.kieu80@gmail.com','NgKieu#2580','Ngô Kiều Oanh','student', 0,CURRENT_TIMESTAMP),
('nguyen.dung81@gmail.com','NgDung$2581','Nguyễn Dũng Huy','student', 0,CURRENT_TIMESTAMP),
('tran.tam82@gmail.com','TrTam%2582','Trần Tâm Đan','student', 0,CURRENT_TIMESTAMP),
('le.phuong83@gmail.com','LePhuong&2583','Lê Phương Thảo','student', 0,CURRENT_TIMESTAMP),
('pham.viet84@gmail.com','PhViet*2584','Phạm Việt Hùng','student', 0,CURRENT_TIMESTAMP),
('hoang.quynh85@gmail.com','HoQuynh!2585','Hoàng Quỳnh Anh','student', 0,CURRENT_TIMESTAMP),
('vu.long86@gmail.com','VuLong#2586','Vũ Long Thành','student', 0,CURRENT_TIMESTAMP),
('dang.nga87@gmail.com','DaNga$2587','Đặng Ngọc Ánh','student', 0,CURRENT_TIMESTAMP),
('bui.hien88@gmail.com','BuHien%2588','Bùi Hiền My','student', 0,CURRENT_TIMESTAMP),
('do.khanh89@gmail.com','DoKhanh&2589','Đỗ Khánh Toàn','student', 0,CURRENT_TIMESTAMP),
('ngo.thao90@gmail.com','NgThao*2590','Ngô Thảo Ly','student', 0,CURRENT_TIMESTAMP),
('nguyen.phat91@gmail.com','NgPhat!2591','Nguyễn Phát Đạt','student', 0,CURRENT_TIMESTAMP),
('tran.tro92@gmail.com','TrTro#2592','Trần Trọng Nghĩa','student', 0,CURRENT_TIMESTAMP),
('le.dang93@gmail.com','LeDang$2593','Lê Đăng Khoa','student', 0,CURRENT_TIMESTAMP),
('pham.thanh94@gmail.com','PhThanh%2594','Phạm Thanh Bình','student', 0,CURRENT_TIMESTAMP),
('hoang.ho95@gmail.com','HoHo&2595','Hoàng Hồ Nam','student', 0,CURRENT_TIMESTAMP),
('vu.nhung96@gmail.com','VuNhung*2596','Vũ Nhung Vy','student', 0,CURRENT_TIMESTAMP),
('dang.hoang97@gmail.com','DaHoang!2597','Đặng Hoàng Phúc','student', 0,CURRENT_TIMESTAMP),
('bui.anh98@gmail.com','BuAnh#2598','Bùi Anh Khoa','student', 0,CURRENT_TIMESTAMP),
('do.quynh99@gmail.com','DoQuynh$2599','Đỗ Quỳnh Hương','student', 0,CURRENT_TIMESTAMP),
('ngo.son100@gmail.com','NgSon%26100','Ngô Sơn Tùng','student', 0,CURRENT_TIMESTAMP),
('nguyen.hieu01@gmail.com', 'NgHieu!2501', 'Nguyễn Hiếu Phúc', 'admin', 0, CURRENT_TIMESTAMP),
('tran.thang02@gmail.com', 'TrThang#2502', 'Trần Thắng Duy', 'admin', 0, CURRENT_TIMESTAMP),
('le.anh03@gmail.com',     'LeAnh$2503',  'Lê Anh Khoa',       'admin', 0, CURRENT_TIMESTAMP),
('pham.hai04@gmail.com',    'PhHai%2504',  'Phạm Hải Đăng',     'admin', 0, CURRENT_TIMESTAMP),
('hoang.nam05@gmail.com',   'HoNam&2505',  'Hoàng Nam Phúc',    'admin', 0, CURRENT_TIMESTAMP);

START TRANSACTION;
-- Admins
INSERT INTO `admin` (user_id)
SELECT u.user_id
FROM `user` u
LEFT JOIN `admin` a ON a.user_id = u.user_id
WHERE u.role = 'admin' AND a.user_id IS NULL;
COMMIT;

SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO student (user_id, enrollment_year, major) VALUES
(1021, 2020, 'Computer Science and Engineering'),
(1022, 2021, 'Electrical and Electronics Engineering'),
(1023, 2022, 'Mechanical Engineering'),
(1024, 2023, 'Chemical Engineering'),
(1025, 2024, 'Civil Engineering'),
(1026, 2025, 'Materials Technology'),
(1027, 2020, 'Applied Science'),
(1028, 2021, 'Environmental and Natural Resources'),
(1029, 2022, 'Transportation Engineering'),
(1030, 2023, 'Geology and Petroleum Engineering'),
(1031, 2024, 'Industrial Management'),
(1032, 2025, 'Information Technology'),
(1033, 2020, 'Biomedical Engineering'),
(1034, 2021, 'Automation and Control Engineering'),
(1035, 2022, 'Energy Engineering'),
(1036, 2023, 'Software Engineering'),
(1037, 2024, 'Telecommunications Engineering'),
(1038, 2025, 'Robotics and Mechatronics'),
(1039, 2020, 'Agricultural Engineering'),
(1040, 2021, 'Ocean Engineering'),
(1041, 2022, 'Nanotechnology'),
(1042, 2023, 'Architecture and Urban Planning'),
(1043, 2024, 'Materials Science'),
(1044, 2025, 'Systems Engineering'),
(1045, 2020, 'Computer Science and Engineering'),
(1046, 2021, 'Electrical and Electronics Engineering'),
(1047, 2022, 'Mechanical Engineering'),
(1048, 2023, 'Chemical Engineering'),
(1049, 2024, 'Civil Engineering'),
(1050, 2025, 'Materials Technology'),
(1051, 2020, 'Applied Science'),
(1052, 2021, 'Environmental and Natural Resources'),
(1053, 2022, 'Transportation Engineering'),
(1054, 2023, 'Geology and Petroleum Engineering'),
(1055, 2024, 'Industrial Management'),
(1056, 2025, 'Information Technology'),
(1057, 2020, 'Biomedical Engineering'),
(1058, 2021, 'Automation and Control Engineering'),
(1059, 2022, 'Energy Engineering'),
(1060, 2023, 'Software Engineering'),
(1061, 2024, 'Telecommunications Engineering'),
(1062, 2025, 'Robotics and Mechatronics'),
(1063, 2020, 'Agricultural Engineering'),
(1064, 2021, 'Ocean Engineering'),
(1065, 2022, 'Nanotechnology'),
(1066, 2023, 'Architecture and Urban Planning'),
(1067, 2024, 'Materials Science'),
(1068, 2025, 'Systems Engineering'),
(1069, 2020, 'Computer Science and Engineering'),
(1070, 2021, 'Electrical and Electronics Engineering'),
(1071, 2022, 'Mechanical Engineering'),
(1072, 2023, 'Chemical Engineering'),
(1073, 2024, 'Civil Engineering'),
(1074, 2025, 'Materials Technology'),
(1075, 2020, 'Applied Science'),
(1076, 2021, 'Environmental and Natural Resources'),
(1077, 2022, 'Transportation Engineering'),
(1078, 2023, 'Geology and Petroleum Engineering'),
(1079, 2024, 'Industrial Management'),
(1080, 2025, 'Information Technology'),
(1081, 2020, 'Biomedical Engineering'),
(1082, 2021, 'Automation and Control Engineering'),
(1083, 2022, 'Energy Engineering'),
(1084, 2023, 'Software Engineering'),
(1085, 2024, 'Telecommunications Engineering'),
(1086, 2025, 'Robotics and Mechatronics'),
(1087, 2020, 'Agricultural Engineering'),
(1088, 2021, 'Ocean Engineering'),
(1089, 2022, 'Nanotechnology'),
(1090, 2023, 'Architecture and Urban Planning'),
(1091, 2024, 'Materials Science'),
(1092, 2025, 'Systems Engineering'),
(1093, 2020, 'Computer Science and Engineering'),
(1094, 2021, 'Electrical and Electronics Engineering'),
(1095, 2022, 'Mechanical Engineering'),
(1096, 2023, 'Chemical Engineering'),
(1097, 2024, 'Civil Engineering'),
(1098, 2025, 'Materials Technology'),
(1099, 2020, 'Applied Science'),
(1100, 2021, 'Environmental and Natural Resources'),
(1101, 2022, 'Transportation Engineering'),
(1102, 2023, 'Geology and Petroleum Engineering'),
(1103, 2024, 'Industrial Management'),
(1104, 2025, 'Information Technology'),
(1105, 2020, 'Biomedical Engineering'),
(1106, 2021, 'Automation and Control Engineering'),
(1107, 2022, 'Energy Engineering'),
(1108, 2023, 'Software Engineering'),
(1109, 2024, 'Telecommunications Engineering'),
(1110, 2025, 'Robotics and Mechatronics'),
(1111, 2020, 'Agricultural Engineering'),
(1112, 2021, 'Ocean Engineering'),
(1113, 2022, 'Nanotechnology'),
(1114, 2023, 'Architecture and Urban Planning'),
(1115, 2024, 'Materials Science'),
(1116, 2025, 'Systems Engineering'),
(1117, 2020, 'Computer Science and Engineering'),
(1118, 2021, 'Electrical and Electronics Engineering'),
(1119, 2022, 'Mechanical Engineering'),
(1120, 2023, 'Chemical Engineering');



INSERT INTO teacher (user_id, honorific_title) VALUES
(1001, 'Doctor'),
(1002, 'Master'),
(1003, 'Lecturer'),
(1004, 'Doctor'),
(1005, 'Master'),
(1006, 'Doctor'),
(1007, 'Lecturer'),
(1008, 'Master'),
(1009, 'Doctor'),
(1010, 'Lecturer'),
(1011, 'Doctor'),
(1012, 'Master'),
(1013, 'Doctor'),
(1014, 'Lecturer'),
(1015, 'Master'),
(1016, 'Doctor'),
(1017, 'Master'),
(1018, 'Lecturer'),
(1019, 'Doctor'),
(1020, 'Master');

SET FOREIGN_KEY_CHECKS = 1;
