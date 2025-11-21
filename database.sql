-- creating database

CREATE DATABASE IF NOT EXISTS petmatcherDB;
USE petmatcherDB;

-- User & agency table
CREATE table IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    user_type ENUM('adopter', 'agency') NOT NULL,
    phone VARCHAR(20),
    city VARCHAR(100),
    state VARCHAR(100),
    preferred_animal_type VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pets table
CREATE table IF NOT EXISTS pets (
    pet_id INT AUTO_INCREMENT PRIMARY KEY,
    agency_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    animal_type VARCHAR(50) NOT NULL,  
    breed VARCHAR(100),
    age INT,
    status ENUM('available', 'pending', 'adopted') DEFAULT 'available',
    description TEXT,
    city VARCHAR(100),
    state VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (agency_id) REFERENCES users(user_id)
        ON DELETE CASCADE
);
-- inquiries table
CREATE TABLE IF NOT EXISTS inquiries (
    inquiry_id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- links to other tables
    pet_id INT NOT NULL,
    adopter_id INT NOT NULL,
    agency_id INT NOT NULL,
    
    -- contact info
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    address VARCHAR(255),
    phone_number VARCHAR(20),
    email VARCHAR(150),
    
    -- housing information
    home_type ENUM('house', 'apartment', 'rv-trailer'),
    rent_or_own ENUM('renter', 'homeowner'),
    landlord_permission ENUM('landlord-allowed', 'landlord-unallowed', 'landlord-inapplicable'),
    
    -- pet experience
    has_pet_experience BIT,
    owned_dog BIT,
    owned_cat BIT,
    owned_bird BIT,
    owned_reptile BIT,
    owned_rodent BIT,
    owned_other BIT,
    
    -- current pets
    has_current_pets BIT,
    current_pets_description TEXT,
    
    -- household info
    household_people INT,
    has_children BIT,
    -- maybe add later: children_count INT,
    
    -- adoption-specific questions
    adoption_reason TEXT,
    hours_pet_alone ENUM('alone-02', 'alone-35', 'alone-68', 'alone-9+'),
    
    -- admin/status info
    status ENUM('new', 'in_progress', 'closed') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    -- foreign keys
    FOREIGN KEY (pet_id) REFERENCES pets(pet_id) ON DELETE CASCADE,
    FOREIGN KEY (adopter_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (agency_id) REFERENCES users(user_id) ON DELETE CASCADE
);


INSERT INTO users (name, email, password_hash, user_type, phone, city, state, preferred_animal_type)
VALUES
('Happy Paws Shelter', 'contact@happypaws.org', 'hashed_pw_1', 'agency', '555-1111', 'Riverside', 'CA', NULL),
('Cozy Critters Rescue', 'info@cozycritters.org', 'hashed_pw_2', 'agency', '555-2222', 'Anaheim', 'CA', NULL),
('Alice Johnson', 'alice@example.com', 'hashed_pw_3', 'adopter', '555-3333', 'Fullerton', 'CA', 'dog'),
('Michael Lee', 'michael@example.com', 'hashed_pw_4', 'adopter', '555-4444', 'Irvine', 'CA', 'cat');


INSERT INTO pets (agency_id, name, animal_type, breed, age, status, description, city, state)
VALUES
(1, 'Buddy', 'dog', 'Labrador Mix', 3, 'available',
 'Friendly and energetic dog who loves walks.', 'Riverside', 'CA'),

(1, 'Mittens', 'cat', 'Tabby', 2, 'available',
 'Quiet and affectionate cat who enjoys sunny windowsills.', 'Riverside', 'CA'),

(2, 'Rocky', 'dog', 'German Shepherd', 5, 'pending',
 'Strong, loyal dog who does well with active families.', 'Anaheim', 'CA');

INSERT INTO inquiries (
    pet_id, adopter_id, agency_id,
    first_name, last_name, address, phone_number, email,
    home_type, rent_or_own, landlord_permission,
    has_pet_experience, owned_dog, owned_cat, owned_bird, owned_reptile, owned_rodent, owned_other,
    has_current_pets, current_pets_description,
    household_people, has_children,
    adoption_reason, hours_pet_alone, status
)
VALUES
(
    1, 3, 1,
    'Alice', 'Johnson', '123 Maple St, Fullerton, CA, 92831, USA', '555-3333', 'alice@example.com',
    'house', 'homeowner', 'landlord-inapplicable',
    1, 1, 0, 0, 0, 0, 0,
    0, NULL,
    2, 0,
    'I want to adopt Buddy because he matches my active lifestyle.',
    'alone-35',
    'new'
);

