CREATE TABLE residents(
    resident_code VARCHAR(255) NOT NULL PRIMARY KEY,
    family_name VARCHAR(50) NOT NULL,
    given_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50) NOT NULL,
    civil_status VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    avg_monthly_salary DECIMAL(19, 4) NOT NULL
);