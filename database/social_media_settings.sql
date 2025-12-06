-- Table structure for social_media_settings (social media sharing settings)
CREATE TABLE IF NOT EXISTS social_media_settings (
    id SERIAL PRIMARY KEY,
    platform VARCHAR(50) UNIQUE NOT NULL,
    enabled BOOLEAN DEFAULT false,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default social media platforms
INSERT INTO social_media_settings (platform, enabled, display_order) VALUES
('facebook', true, 1),
('twitter', true, 2),
('whatsapp', true, 3),
('telegram', false, 4),
('linkedin', false, 5)
ON CONFLICT (platform) DO NOTHING;

