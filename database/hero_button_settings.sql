-- Add button settings to hero_settings table
-- This will insert default values for hero button text and link if they don't exist

INSERT INTO hero_settings (setting_key, setting_value)
VALUES 
    ('hero_button_text', 'Get Started'),
    ('hero_button_link', '#profil')
ON CONFLICT (setting_key) DO NOTHING;

