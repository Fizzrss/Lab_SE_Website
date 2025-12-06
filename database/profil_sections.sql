-- Table structure for hero_settings (homepage hero section settings)
CREATE TABLE IF NOT EXISTS hero_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for profil_sections (profile sections: Tentang, Visi & Misi, Roadmap, Focus & Scope)
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

-- Insert default hero settings
INSERT INTO hero_settings (setting_key, setting_value) VALUES
('hero_title', 'Laboratorium Software Engineering'),
('hero_subtitle', 'Politeknik Negeri Malang'),
('hero_description', 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.'),
('hero_background_image', 'assets/img/bg_web.webp'),
('hero_button_text', 'Get Started'),
('hero_button_link', '#profil')
ON CONFLICT (setting_key) DO NOTHING;

-- Insert default profil sections
INSERT INTO profil_sections (section_key, section_title, section_content, is_active, display_order) VALUES
('tentang', 'Tentang Kami', '{"title": "Tentang Kami", "description": "Laboratorium Software Engineering adalah laboratorium yang fokus pada pengembangan perangkat lunak dan teknologi informasi.", "images": []}', true, 1),
('visi_misi', 'Visi & Misi', '{"title": "Visi & Misi", "visi": "Menjadi laboratorium terdepan dalam pengembangan perangkat lunak dan teknologi informasi.", "misi": ["Mengembangkan skill mahasiswa dalam bidang software engineering", "Melakukan riset dan inovasi teknologi", "Berkolaborasi dengan industri"]}', true, 2),
('roadmap', 'Roadmap', '{"title": "Roadmap", "items": []}', true, 3),
('focus_scope', 'Focus & Scope', '{"title": "Focus & Scope", "fokus_riset": [], "lingkup_detail": []}', true, 4)
ON CONFLICT (section_key) DO NOTHING;

