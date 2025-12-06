-- Table structure for berita (news)
CREATE TABLE IF NOT EXISTS berita (
    id SERIAL PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    tanggal_publikasi DATE NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    gambar VARCHAR(255),
    isi_singkat TEXT NOT NULL,
    isi_lengkap TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'draft' CHECK (status IN ('draft', 'published')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create index for better performance
CREATE INDEX idx_berita_status ON berita(status);
CREATE INDEX idx_berita_kategori ON berita(kategori);
CREATE INDEX idx_berita_tanggal ON berita(tanggal_publikasi);
CREATE INDEX idx_berita_slug ON berita(slug);

-- Insert sample data
INSERT INTO berita (judul, slug, kategori, tanggal_publikasi, penulis, gambar, isi_singkat, isi_lengkap, status) VALUES
('Workshop Pengenalan Framework Laravel 10', 'workshop-pengenalan-framework-laravel-10', 'Workshop', '2025-11-12', 'Admin Lab', 'https://placehold.co/800x600/png?text=Laravel+Workshop', 'Mahasiswa diajak menyelami fitur-fitur terbaru dari Laravel 10 dalam workshop intensif...', '<p>Laboratorium Software Engineering mengadakan workshop intensif mengenai Laravel 10, framework PHP terpopuler saat ini. Workshop ini diikuti oleh lebih dari 50 mahasiswa yang antusias untuk mempelajari fitur-fitur terbaru.</p><p>Materi yang dibahas meliputi routing, middleware, eloquent ORM, dan fitur-fitur baru di Laravel 10. Peserta juga mendapatkan kesempatan untuk praktik langsung membuat aplikasi web sederhana.</p>', 'published'),

('Pentingnya Software Testing dalam Siklus DevOps', 'pentingnya-software-testing-dalam-siklus-devops', 'Artikel Teknis', '2025-11-10', 'Dr. Rahmat Hidayat', 'https://placehold.co/800x600/png?text=Software+Testing', 'Mengapa pengujian otomatis menjadi kunci keberhasilan implementasi DevOps...', '<p>Software testing merupakan komponen krusial dalam siklus DevOps. Artikel ini membahas berbagai jenis testing yang perlu diterapkan dalam pipeline CI/CD.</p><p>Dari unit testing, integration testing, hingga end-to-end testing, semuanya memiliki peran penting dalam memastikan kualitas software yang dikembangkan. Pengujian otomatis juga membantu mendeteksi bug lebih awal dalam proses development.</p>', 'published'),

('Lab SE Membuka Pendaftaran Asisten Baru 2026', 'lab-se-membuka-pendaftaran-asisten-baru-2026', 'Pengumuman', '2025-11-05', 'Koordinator Lab', 'https://placehold.co/800x600/png?text=Open+Recruitment', 'Kesempatan emas bagi mahasiswa tingkat 2 dan 3 untuk bergabung menjadi bagian dari keluarga...', '<p>Laboratorium Software Engineering membuka kesempatan bagi mahasiswa tingkat 2 dan 3 untuk bergabung sebagai asisten laboratorium periode 2026.</p><p>Persyaratan meliputi IPK minimal 3.0, memiliki kemampuan programming yang baik, dan bersedia mengikuti pelatihan intensif. Pendaftaran dibuka hingga akhir bulan ini.</p><p>Manfaat menjadi asisten lab termasuk pengembangan skill teknis, networking, dan tentunya honorarium bulanan.</p>', 'published'),

('Tren UI/UX Design di Tahun 2025', 'tren-ui-ux-design-di-tahun-2025', 'Wawasan', '2025-11-01', 'Maya Sari, MT', 'https://placehold.co/800x600/png?text=UI+UX+Design', 'Membahas pergeseran tren dari minimalisme menuju desain yang lebih ekspresif...', '<p>Tahun 2025 menandai pergeseran signifikan dalam dunia UI/UX design. Tren minimalis yang mendominasi beberapa tahun terakhir mulai bergeser ke arah desain yang lebih ekspresif dan berani.</p><p>Penggunaan warna-warna bold, animasi micro-interaction yang lebih kompleks, dan typography yang lebih kreatif menjadi ciri khas desain modern. Namun, prinsip usability tetap menjadi prioritas utama.</p><p>Artikel ini juga membahas pentingnya accessibility dalam design, memastikan produk digital dapat digunakan oleh semua orang termasuk penyandang disabilitas.</p>', 'published');

