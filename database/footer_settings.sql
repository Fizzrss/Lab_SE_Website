-- Footer Settings Table
CREATE TABLE IF NOT EXISTS footer_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Footer About Section
INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_about_title', 'Laboratorium Software Engineering'),
('footer_about_address', 'Gedung Teknik Sipil dan Teknologi Informasi\nPoliteknik Negeri Malang, Malang'),
('footer_about_phone', '+62 341 123456'),
('footer_about_email', 'lab.se@polinema.ac.id')
ON CONFLICT (setting_key) DO NOTHING;

-- Footer Links Section
INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_links_title', 'Useful Links'),
('footer_links', '[]') -- JSON array of selected pages
ON CONFLICT (setting_key) DO NOTHING;

-- Footer Social Media Section
INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_social_title', 'Connect With Us'),
('footer_social_description', 'Ikuti sosial media kami untuk update terbaru seputar kegiatan lab dan teknologi.'),
('footer_social_media', '[]') -- JSON array of social media platforms
ON CONFLICT (setting_key) DO NOTHING;

-- Footer Copyright
INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_copyright', '© Copyright Lab Software Engineering. All Rights Reserved')
ON CONFLICT (setting_key) DO NOTHING;

-- Available Pages Table (for dropdown selection)
CREATE TABLE IF NOT EXISTS footer_available_pages (
    id SERIAL PRIMARY KEY,
    page_file VARCHAR(255) NOT NULL,
    page_title VARCHAR(255) NOT NULL,
    page_url VARCHAR(500) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default pages
INSERT INTO footer_available_pages (page_file, page_title, page_url, display_order) VALUES
('index.php', 'Beranda', 'index.php', 1),
('pages/tentang.php', 'Tentang Kami', 'pages/tentang.php', 2),
('pages/berita.php', 'Berita & Artikel', 'pages/berita.php', 3),
('pages/personil.php', 'Personil', 'pages/personil.php', 4),
('pages/mahasiswa_list.php', 'Daftar Mahasiswa', 'pages/mahasiswa_list.php', 5),
('pages/recruitment_form.php', 'Form Pendaftaran', 'pages/recruitment_form.php', 6),
('pages/statistik.php', 'Statistik', 'pages/statistik.php', 7),
('pages/recruitment.php', 'Recruitment', 'pages/recruitment.php', 8)
ON CONFLICT DO NOTHING;

