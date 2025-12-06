-- Table structure for berita_settings (hero banner settings)
CREATE TABLE IF NOT EXISTS berita_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO berita_settings (setting_key, setting_value) VALUES
('hero_badge', 'News & Updates'),
('hero_title', 'Berita & Artikel Terkini'),
('hero_description', 'Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.'),
('hero_background_image', '../assets/img/lab1.jpg')
ON CONFLICT (setting_key) DO NOTHING;

