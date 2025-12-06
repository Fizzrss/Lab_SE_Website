-- Table structure for berita_komentar (news comments)
CREATE TABLE IF NOT EXISTS berita_komentar (
    id SERIAL PRIMARY KEY,
    berita_id INTEGER NOT NULL,
    commenter_name VARCHAR(255) NOT NULL,
    commenter_email VARCHAR(255) NOT NULL,
    comment_content TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'approved' CHECK (status IN ('pending', 'approved', 'rejected')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_berita FOREIGN KEY (berita_id) REFERENCES berita(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_berita_komentar_berita_id ON berita_komentar(berita_id);
CREATE INDEX idx_berita_komentar_status ON berita_komentar(status);
CREATE INDEX idx_berita_komentar_created_at ON berita_komentar(created_at);

