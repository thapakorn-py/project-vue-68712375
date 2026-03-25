-- Add email column to customers table if it doesn't exist
ALTER TABLE customers ADD COLUMN email VARCHAR(100) NOT NULL DEFAULT '' UNIQUE;

-- If you want to set email for existing records, uncomment and modify:
-- UPDATE customers SET email = CONCAT(username, '@example.com') WHERE email = '';
