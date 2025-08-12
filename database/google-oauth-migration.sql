-- Google OAuth Migration for gadget_shop database
-- Add google_id column to users table and make password nullable

USE gadget_shop;

-- Add google_id column if it doesn't exist
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS google_id VARCHAR(255) NULL UNIQUE,
ADD INDEX idx_google_id (google_id);

-- Make password nullable for Google OAuth users
ALTER TABLE users 
MODIFY COLUMN password VARCHAR(255) NULL;

-- Update table comment
ALTER TABLE users COMMENT = 'Users table with Google OAuth support';
