-- Table structure for related_posts_settings (related posts configuration)
CREATE TABLE IF NOT EXISTS related_posts_settings (
    id SERIAL PRIMARY KEY,
    enabled BOOLEAN DEFAULT true,
    max_posts INTEGER DEFAULT 3,
    show_same_category BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default settings
INSERT INTO related_posts_settings (enabled, max_posts, show_same_category) VALUES
(true, 3, true)
ON CONFLICT DO NOTHING;

