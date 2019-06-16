//-----------------------
//CREATE TABLE ASSIGNMENT
//-----------------------

CREATE TABLE Assignment (
assigID SERIAL PRIMARY KEY, 
userID INT REFERENCES App_user(userID), 
courseID INT REFERENCES Course(courseID),
week SMALLINT NOT NULL,
points SMALLINT NOT NULL,
description VARCHAR(1000) NOT NULL,
personal_notes TEXT,
instructor_agreement VARCHAR(1000),
due_date date NOT NULL,
done CHAR(1) NOT NULL,
alive CHAR(1) NOT NULL
);

//--------------------
//CREATE TABLE COURSE
//--------------------

CREATE TABLE Course (
courseID SERIAL PRIMARY KEY,
course_name VARCHAR(32) UNIQUE NOT NULL,
topics VARCHAR(1000) NOT NULL,
instructor VARCHAR(32) NOT NULL,
semester SEMESTER NOT NULL 
);

//---------------------
//CREATE TABLE APP_USER
//---------------------

CREATE TABLE App_user (
userID SERIAL PRIMARY KEY,
user_name VARCHAR(32) UNIQUE NOT NULL,
Password VARCHAR(32) NOT NULL
);

//---------------------
//CREATE TABLE SEMESTER
//---------------------

CREATE TYPE Semester AS ENUM ('Fall', 'Winter', 'Spring', 'Summer');