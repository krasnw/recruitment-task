-- basic_data table
CREATE TABLE basic_data (
  id SERIAL PRIMARY KEY,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  birth_date DATE NOT NULL CHECK (birth_date < CURRENT_DATE),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- contact_data table
CREATE TABLE contact_data (
  id SERIAL PRIMARY KEY,
  basic_data_id INTEGER NOT NULL,
  phone VARCHAR(20) NOT NULL,
  email VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (basic_data_id) REFERENCES basic_data(id) ON DELETE CASCADE
);

-- work_experience table
CREATE TABLE work_experience (
  id SERIAL PRIMARY KEY,
  basic_data_id INTEGER NOT NULL,
  company_name VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  date_from DATE NOT NULL,
  date_to DATE NOT NULL CHECK (date_to >= date_from),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (basic_data_id) REFERENCES basic_data(id) ON DELETE CASCADE
);

-- indexes for better performance
CREATE INDEX idx_contact_data_basic_data_id ON contact_data(basic_data_id);
CREATE INDEX idx_work_experience_basic_data_id ON work_experience(basic_data_id);