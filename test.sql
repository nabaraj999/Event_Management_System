
-- Company Information (Site settings, managed by Admin)
CREATE TABLE company_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_name VARCHAR(255) NOT NULL,
    logo VARCHAR(255),  -- Path to logo file
    background_image VARCHAR(255),  -- Path to background image
    address TEXT,
    phone VARCHAR(50),
    email VARCHAR(255),
    about_us TEXT,
    about_us_image VARCHAR(255),  -- Path to about us image
    favicons VARCHAR(255),  -- Path to favicon file
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Users Table (Common for Admin, Adopter, Shelter)
CREATE TABLE adopters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,  -- Store hashed password
    full_name VARCHAR(255),
    phone VARCHAR(50),
    address TEXT,
    profile_picture VARCHAR(255),  -- Path to image
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
);

-- Shelters Table (Additional info for Shelter role)
CREATE TABLE shelters (
    id INT PRIMARY KEY,
    shelter_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    password VARCHAR(255) NOT NULL,  -- Store hashed password
    document VARCHAR(255),  -- Path to verification document
    description TEXT,
    location TEXT,
    website VARCHAR(255),
    verification_status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
);

-- Pet Categories (e.g., Dog, Cat, Bird, etc.)
CREATE TABLE pet_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    icons VARCHAR(255),  -- Path to icon image
    category_name VARCHAR(100) NOT NULL UNIQUE
);

-- Breeds (Linked to category)
CREATE TABLE breeds (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    breed_name VARCHAR(100) NOT NULL,
    UNIQUE KEY unique_breed_per_category (category_id, breed_name),
    FOREIGN KEY (category_id) REFERENCES pet_categories(id) ON DELETE CASCADE
);

-- Pets Table (Listed by Shelters)
CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    shelter_id INT NOT NULL,
    category_id INT NOT NULL,
    breed_id INT,
    name VARCHAR(255) NOT NULL,
    age INT,  -- In months or years (can add unit field if needed)
    gender ENUM('male', 'female', 'unknown') NOT NULL,
    size ENUM('small', 'medium', 'large', 'extra_large'),
    color VARCHAR(100),
    image VARCHAR(255),  -- Path to main image
    description TEXT,
    health_status TEXT,  -- Vaccinated, neutered, etc.
    adoption_fee DECIMAL(10,2) DEFAULT 0.00,
    status ENUM('available', 'pending', 'adopted') DEFAULT 'available',
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (shelter_id) REFERENCES shelters(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES pet_categories(id) ON DELETE RESTRICT,
    FOREIGN KEY (breed_id) REFERENCES breeds(id) ON DELETE SET NULL
);


-- Adoption Applications (Requests from Adopters to Shelters)
CREATE TABLE booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pet_id INT NOT NULL,
    adopter_id INT NOT NULL,
    shelter_id INT NOT NULL,
    message TEXT,
    status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    responded_at TIMESTAMP NULL,
    FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE,
    FOREIGN KEY (adopter_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (shelter_id) REFERENCES shelters(id) ON DELETE CASCADE
);



-- Recommendations (Optional: For recommendation system - user preferences or matches)
CREATE TABLE user_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    category_id INT,
    breed_id INT,
    preferred_gender ENUM('male', 'female', 'any'),
    preferred_size ENUM('small', 'medium', 'la100rge', 'extra_large', 'any'),
    preferred_color ENUM('any', 'black', 'white', 'brown', 'golden', 'mixed', 'other'),
    max_age INT,
    UNIQUE KEY unique_user_prefs (user_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES pet_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (breed_id) REFERENCES breeds(id) ON DELETE SET NULL
);
