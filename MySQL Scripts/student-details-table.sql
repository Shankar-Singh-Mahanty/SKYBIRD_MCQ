-- Table Creation

CREATE TABLE studentdetails (
    roll_number VARCHAR(20) PRIMARY KEY,
    studname VARCHAR(100) NOT NULL,
    course VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    contact VARCHAR(10) NOT NULL CHECK (LENGTH(contact) = 10 AND contact REGEXP '^[0-9]{10}$'),
    address VARCHAR(100) NOT NULL,
    status CHAR(6) DEFAULT 'Active' CHECK (status = 'Active'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Insert Data

INSERT INTO studentdetails (student_number, emp_number, empname, designation, unit, department, bill_unit_no, allocation, operator, plan, status)
VALUES
(1014785798, 365166527088, 'DALLAP KUMDR SDMDL', 'AA', 'CON', 'S & T', '3106854', 873106, 'JIO', 'C', 'Active'),
(9677141709, 339555256153, 'SPDSPA KDNT MASPRD', 'FAnCAO', 'CON', 'ENGG', '06287', 873106, 'JIO', 'C', 'Active'),
(9677137458, 362276237069, 'SUMDND MBPDNTY', 'FAnCAO/TRAFFIC', 'CON', 'ENGG', '06025', 873106, 'JIO', 'C', 'Active'),
(9677141905, 363155739851, 'Y.DNDND', 'FAnCAO/WnS', 'CON', 'S & T', '06853', 873106, 'JIO', 'C', 'Active'),
(9677145886, 365154987804, 'NARMDL CPDNDRD SDRDNGA', 'AFA', 'CON', 'ENGG', '06287', 873106, 'JIO', 'C', 'Active');

-- Describe table
DESC studentdetails;

-- View all the records of the table
SELECT * FROM studentdetails;
