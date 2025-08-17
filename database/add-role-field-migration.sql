-- Add role field migration for gadget_shop database
-- Adds role column to users table for admin/user role management

USE gadget_shop;

-- Add role column for user roles (admin/user)
ALTER TABLE users 
ADD COLUMN IF NOT EXISTS role ENUM('admin', 'user') DEFAULT 'user' AFTER is_active;

-- Create index on role for better query performance
ALTER TABLE users ADD INDEX IF NOT EXISTS idx_role (role);

-- Update table comment
ALTER TABLE users COMMENT = 'Users table with role-based access control and profile fields';

-- Set default role for existing users (if any don't have a role set)
UPDATE users SET role = 'user' WHERE role IS NULL;
