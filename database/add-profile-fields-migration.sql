-- Add profile fields migration for gadget_shop database
-- Adds bio, phone, address, and profile_picture columns to users table

USE gadget_shop;

-- Add bio column for user biography/description
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS bio TEXT NULL AFTER email;

-- Add phone column for contact number
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS phone VARCHAR(20) NULL AFTER bio;

-- Add address column for user address
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS address TEXT NULL AFTER phone;

-- Add profile_picture column for user avatar
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS profile_picture VARCHAR(255) NULL AFTER address;

-- Update table comment
ALTER TABLE users COMMENT = 'Users table with profile fields (bio, phone, address, profile_picture) and Google OAuth support';
