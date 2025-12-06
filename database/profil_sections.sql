-- Profil Sections Table
CREATE TABLE IF NOT EXISTS profil_sections (
    id SERIAL PRIMARY KEY,
    section_key VARCHAR(50) UNIQUE NOT NULL,
    section_title VARCHAR(255),
    section_content TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    display_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default sections
INSERT INTO profil_sections (section_key, section_title, section_content, display_order) VALUES
('tentang', 'Tentang Kami', '{"title": "Tentang Kami", "description": "Laboratorium Rekayasa Perangkat Lunak merupakan fasilitas akademik di bawah naungan Jurusan Teknologi Informasi di Fakultas Teknik bidang rekayasa perangkat lunak yang mendukung Laboratorium ini dilengkapi tumbuh menjadi pusat aktivitas penelitian dan pengabdian masyarakat yang berfokus pada pengembangan teknologi perangkat lunak", "images": ["assets/img/bg_web.webp", "assets/img/background.jpeg", "assets/img/lab2.jpeg"]}', 1),
('visi_misi', 'Visi & Misi', '{"title": "Visi & Misi", "visi": "Menjadi laboratorium software engineering terdepan yang menghasilkan lulusan berkompeten, inovatif, dan profesional dalam bidang rekayasa perangkat lunak untuk berkontribusi pada kemajuan teknologi informasi di Indonesia.", "misi": ["Menyelenggarakan pendidikan dan pelatihan berkualitas dalam bidang software engineering", "Mengembangkan penelitian dan inovasi dalam rekayasa perangkat lunak", "Membangun kolaborasi dengan industri dan institusi lain", "Menghasilkan produk software yang bermanfaat bagi masyarakat", "Membentuk komunitas developer yang solid dan profesional"]}', 2),
('roadmap', 'Roadmap', '{"title": "Roadmap Pengembangan LAB Software Engineering", "items": [{"year": "2021", "description": "Inisiasi pembentukan LAB Software Engineering dan penyusunan struktur organisasi awal."}, {"year": "2022", "description": "Mulai kegiatan riset internal dan pembuatan website resmi LAB Software Engineering."}, {"year": "2023", "description": "Peluncuran sistem informasi internal serta kolaborasi pertama dengan pihak industri."}, {"year": "2024", "description": "Implementasi CI/CD, modernisasi website, dan penguatan kegiatan DevOps untuk anggota."}, {"year": "2025", "description": "Fokus pada riset AI, kolaborasi startup teknologi, dan ekspansi skala proyek nasional."}]}', 3),
('focus_scope', 'Focus & Scope', '{"title": "Focus & Scope", "subtitle": "Kami berdedikasi untuk mengeksplorasi batas-batas baru dalam rekayasa perangkat lunak.", "fokus_riset": ["Software Engineering Methodologies and Architecture", "Domain-Specific Software Engineering Applications", "Emerging Technologies in Software Engineering"], "lingkup_detail": [{"icon": "bi-diagram-3", "judul": "Methodologies", "desc": "Pengembangan metode Agile, Scrum, dan pendekatan modern dalam SDLC."}, {"icon": "bi-cpu", "judul": "Architecture", "desc": "Perancangan arsitektur Microservices, Monolithic, dan Serverless."}, {"icon": "bi-bug", "judul": "Testing & QA", "desc": "Otomatisasi pengujian perangkat lunak untuk menjamin kualitas sistem."}, {"icon": "bi-phone", "judul": "Mobile & Web", "desc": "Riset implementasi teknologi terbaru pada platform web & seluler."}]}', 4)
ON CONFLICT (section_key) DO NOTHING;

-- Hero Section Settings
CREATE TABLE IF NOT EXISTS hero_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO hero_settings (setting_key, setting_value) VALUES
('hero_title', 'Laboratorium Software Engineering'),
('hero_subtitle', 'Politeknik Negeri Malang'),
('hero_description', 'Mengembangkan inovasi teknologi untuk masa depan yang lebih cerdas.'),
('hero_background_image', 'assets/img/bg_web.webp')
ON CONFLICT (setting_key) DO NOTHING;

