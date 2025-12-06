-- Table structure for footer_settings (footer configuration)
CREATE TABLE IF NOT EXISTS footer_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for footer_available_pages (available pages for footer links)
CREATE TABLE IF NOT EXISTS footer_available_pages (
    id SERIAL PRIMARY KEY,
    page_file VARCHAR(255) NOT NULL,
    page_title VARCHAR(255) NOT NULL,
    page_url VARCHAR(255) NOT NULL,
    display_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default footer settings
INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_about_title', 'About Us'),
('footer_about_description', 'Laboratorium Software Engineering adalah laboratorium yang fokus pada pengembangan perangkat lunak dan teknologi informasi.'),
('footer_links_title', 'Useful Links'),
('footer_social_title', 'Connect With Us'),
('footer_copyright', '© 2025 Laboratorium Software Engineering. All rights reserved.')
ON CONFLICT (setting_key) DO NOTHING;

-- Insert default available pages (sesuaikan dengan halaman yang ada)
INSERT INTO footer_available_pages (page_file, page_title, page_url, display_order, is_active) VALUES
('index.php', 'Beranda', '/Lab_SE_Website/index.php', 1, true),
('pages/berita.php', 'Berita', '/Lab_SE_Website/pages/berita.php', 2, true),
('pages/personil.php', 'Personil', '/Lab_SE_Website/pages/personil.php', 3, true),
('pages/mahasiswa_list.php', 'Daftar', '/Lab_SE_Website/pages/mahasiswa_list.php', 4, true),
('pages/statistik.php', 'Statistik', '/Lab_SE_Website/pages/statistik.php', 5, true)
ON CONFLICT DO NOTHING;

