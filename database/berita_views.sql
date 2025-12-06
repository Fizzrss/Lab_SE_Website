-- Table structure for berita_views (news view counter)
CREATE TABLE IF NOT EXISTS berita_views (
    id SERIAL PRIMARY KEY,
    berita_id INTEGER NOT NULL,
    view_date DATE NOT NULL,
    view_count INTEGER DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_berita_views FOREIGN KEY (berita_id) REFERENCES berita(id) ON DELETE CASCADE,
    CONSTRAINT unique_berita_date UNIQUE (berita_id, view_date)
);

-- Create indexes for better performance
CREATE INDEX idx_berita_views_berita_id ON berita_views(berita_id);
CREATE INDEX idx_berita_views_date ON berita_views(view_date);

