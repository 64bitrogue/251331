CREATE TABLE residents(
    resident_code VARCHAR(255) NOT NULL PRIMARY KEY,
    resident_name VARCHAR(128) NOT NULL,
    date_of_birth DATE NOT NULL,
    avg_monthly_salary DECIMAL(19, 4) NOT NULL
);