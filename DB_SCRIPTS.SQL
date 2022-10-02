CREATE DATABASE test_project;

CREATE TABLE authors (author_id serial PRIMARY KEY, name VARCHAR(100) NOT NULL);
CREATE TABLE books (book_id serial PRIMARY KEY, name VARCHAR(100) NOT NULL, author_id INTEGER NOT NULL ,FOREIGN KEY (author_id) REFERENCES authors (author_id));