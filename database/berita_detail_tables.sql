-- Table for comments
CREATE TABLE IF NOT EXISTS berita_komentar (
    id SERIAL PRIMARY KEY,
    berita_id INTEGER NOT NULL REFERENCES berita(id) ON DELETE CASCADE,
    commenter_name VARCHAR(100) NOT NULL,
    commenter_email VARCHAR(100) NOT NULL,
    comment_content TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'approved' CHECK (status IN ('pending', 'approved', 'rejected')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_komentar_berita ON berita_komentar(berita_id);
CREATE INDEX idx_komentar_status ON berita_komentar(status);

-- Table for view counter
CREATE TABLE IF NOT EXISTS berita_views (
    id SERIAL PRIMARY KEY,
    berita_id INTEGER NOT NULL REFERENCES berita(id) ON DELETE CASCADE,
    view_date DATE DEFAULT CURRENT_DATE,
    view_count INTEGER DEFAULT 1,
    UNIQUE(berita_id, view_date)
);

CREATE INDEX idx_views_berita ON berita_views(berita_id);
CREATE INDEX idx_views_date ON berita_views(view_date);

-- Table for social media settings
CREATE TABLE IF NOT EXISTS social_media_settings (
    id SERIAL PRIMARY KEY,
    platform VARCHAR(50) UNIQUE NOT NULL,
    enabled BOOLEAN DEFAULT true,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default social media platforms
INSERT INTO social_media_settings (platform, enabled, display_order) VALUES
('facebook', true, 1),
('twitter', true, 2),
('whatsapp', true, 3),
('telegram', true, 4),
('linkedin', true, 5),
('copy', true, 6)
ON CONFLICT (platform) DO NOTHING;

-- Table for related posts settings
CREATE TABLE IF NOT EXISTS related_posts_settings (
    id SERIAL PRIMARY KEY,
    enabled BOOLEAN DEFAULT true,
    max_posts INTEGER DEFAULT 3,
    show_same_category BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO related_posts_settings (enabled, max_posts, show_same_category) 
VALUES (true, 3, true);

