-- =====================================================
-- MASTER SQL SCRIPT - All Dynamic Content Tables
-- =====================================================
-- Script ini menggabungkan semua tabel untuk fitur dinamis
-- Eksekusi file ini akan membuat semua tabel yang diperlukan
-- 
-- Catatan: Pastikan tabel 'berita' sudah dibuat terlebih dahulu
--          sebelum mengeksekusi script ini
-- =====================================================

-- =====================================================
-- 1. BERITA SETTINGS (Hero Banner Berita)
-- =====================================================
CREATE TABLE IF NOT EXISTS berita_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO berita_settings (setting_key, setting_value) VALUES
('hero_badge', 'News & Updates'),
('hero_title', 'Berita & Artikel Terkini'),
('hero_description', 'Berita terbaru, artikel teknis, dan wawasan seputar teknologi dari Laboratorium Software Engineering.'),
('hero_background_image', '../assets/img/lab1.jpg')
ON CONFLICT (setting_key) DO NOTHING;

-- =====================================================
-- 2. BERITA KOMENTAR (Comments)
-- =====================================================
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

CREATE INDEX IF NOT EXISTS idx_berita_komentar_berita_id ON berita_komentar(berita_id);
CREATE INDEX IF NOT EXISTS idx_berita_komentar_status ON berita_komentar(status);
CREATE INDEX IF NOT EXISTS idx_berita_komentar_created_at ON berita_komentar(created_at);

-- =====================================================
-- 3. BERITA VIEWS (View Counter)
-- =====================================================
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

CREATE INDEX IF NOT EXISTS idx_berita_views_berita_id ON berita_views(berita_id);
CREATE INDEX IF NOT EXISTS idx_berita_views_date ON berita_views(view_date);

-- =====================================================
-- 4. SOCIAL MEDIA SETTINGS (Social Media Sharing)
-- =====================================================
CREATE TABLE IF NOT EXISTS social_media_settings (
    id SERIAL PRIMARY KEY,
    platform VARCHAR(50) UNIQUE NOT NULL,
    enabled BOOLEAN DEFAULT false,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO social_media_settings (platform, enabled, display_order) VALUES
('facebook', true, 1),
('twitter', true, 2),
('whatsapp', true, 3),
('telegram', false, 4),
('linkedin', false, 5)
ON CONFLICT (platform) DO NOTHING;

-- =====================================================
-- 5. RELATED POSTS SETTINGS (Related Posts Configuration)
-- =====================================================
CREATE TABLE IF NOT EXISTS related_posts_settings (
    id SERIAL PRIMARY KEY,
    enabled BOOLEAN DEFAULT true,
    max_posts INTEGER DEFAULT 3,
    show_same_category BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO related_posts_settings (enabled, max_posts, show_same_category) VALUES
(true, 3, true)
ON CONFLICT DO NOTHING;

-- =====================================================
-- 6. FOOTER SETTINGS (Footer Configuration)
-- =====================================================
CREATE TABLE IF NOT EXISTS footer_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

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

INSERT INTO footer_settings (setting_key, setting_value) VALUES
('footer_about_title', 'About Us'),
('footer_about_description', 'Laboratorium Software Engineering adalah laboratorium yang fokus pada pengembangan perangkat lunak dan teknologi informasi.'),
('footer_links_title', 'Useful Links'),
('footer_social_title', 'Connect With Us'),
('footer_copyright', '© 2025 Laboratorium Software Engineering. All rights reserved.')
ON CONFLICT (setting_key) DO NOTHING;

INSERT INTO footer_available_pages (page_file, page_title, page_url, display_order, is_active) VALUES
('index.php', 'Beranda', '/Lab_SE_Website/index.php', 1, true),
('pages/berita.php', 'Berita', '/Lab_SE_Website/pages/berita.php', 2, true),
('pages/personil.php', 'Personil', '/Lab_SE_Website/pages/personil.php', 3, true),
('pages/mahasiswa_list.php', 'Daftar', '/Lab_SE_Website/pages/mahasiswa_list.php', 4, true),
('pages/statistik.php', 'Statistik', '/Lab_SE_Website/pages/statistik.php', 5, true)
ON CONFLICT DO NOTHING;

-- =====================================================
-- 7. PROFIL SECTIONS & HERO SETTINGS (Homepage & Profile)
-- =====================================================
CREATE TABLE IF NOT EXISTS hero_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS profil_sections (
    id SERIAL PRIMARY KEY,
    section_key VARCHAR(50) UNIQUE NOT NULL,
    section_title VARCHAR(255) NOT NULL,
    section_content JSONB,
    is_active BOOLEAN DEFAULT true,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO hero_settings (setting_key, setting_value) VALUES
('hero_title', 'Laboratorium Software Engineering'),
('hero_subtitle', 'Politeknik Negeri Malang'),
('hero_description', 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.'),
('hero_background_image', 'assets/img/bg_web.webp'),
('hero_button_text', 'Get Started'),
('hero_button_link', '#profil')
ON CONFLICT (setting_key) DO NOTHING;

INSERT INTO profil_sections (section_key, section_title, section_content, is_active, display_order) VALUES
('tentang', 'Tentang Kami', '{"title": "Tentang Kami", "description": "Laboratorium Software Engineering adalah laboratorium yang fokus pada pengembangan perangkat lunak dan teknologi informasi.", "images": []}', true, 1),
('visi_misi', 'Visi & Misi', '{"title": "Visi & Misi", "visi": "Menjadi laboratorium terdepan dalam pengembangan perangkat lunak dan teknologi informasi.", "misi": ["Mengembangkan skill mahasiswa dalam bidang software engineering", "Melakukan riset dan inovasi teknologi", "Berkolaborasi dengan industri"]}', true, 2),
('roadmap', 'Roadmap', '{"title": "Roadmap", "items": []}', true, 3),
('focus_scope', 'Focus & Scope', '{"title": "Focus & Scope", "fokus_riset": [], "lingkup_detail": []}', true, 4)
ON CONFLICT (section_key) DO NOTHING;

-- =====================================================
-- END OF MASTER SCRIPT
-- =====================================================

