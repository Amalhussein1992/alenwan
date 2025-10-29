-- ============================================
-- Alenwan Demo Content - Full Database Setup
-- ============================================
-- Run this in phpMyAdmin to populate your database
-- ============================================

-- 1. Categories (التصنيفات)
-- ============================================
INSERT INTO categories (name, slug, created_at, updated_at) VALUES
('{"en":"Action","ar":"أكشن"}', 'action', NOW(), NOW()),
('{"en":"Drama","ar":"دراما"}', 'drama', NOW(), NOW()),
('{"en":"Comedy","ar":"كوميديا"}', 'comedy', NOW(), NOW()),
('{"en":"Horror","ar":"رعب"}', 'horror', NOW(), NOW()),
('{"en":"Romance","ar":"رومانسي"}', 'romance', NOW(), NOW()),
('{"en":"Documentary","ar":"وثائقي"}', 'documentary', NOW(), NOW()),
('{"en":"Sports","ar":"رياضة"}', 'sports', NOW(), NOW()),
('{"en":"Animation","ar":"رسوم متحركة"}', 'animation', NOW(), NOW()),
('{"en":"Thriller","ar":"إثارة"}', 'thriller', NOW(), NOW()),
('{"en":"Sci-Fi","ar":"خيال علمي"}', 'sci-fi', NOW(), NOW());

-- 2. Languages (اللغات)
-- ============================================
INSERT INTO languages (code, name, created_at, updated_at) VALUES
('ar', '{"en":"Arabic","ar":"العربية"}', NOW(), NOW()),
('en', '{"en":"English","ar":"الإنجليزية"}', NOW(), NOW()),
('fr', '{"en":"French","ar":"الفرنسية"}', NOW(), NOW()),
('es', '{"en":"Spanish","ar":"الإسبانية"}', NOW(), NOW()),
('de', '{"en":"German","ar":"الألمانية"}', NOW(), NOW());

-- 3. Movies (10 أفلام تجريبية)
-- ============================================
INSERT INTO movies (title, slug, description, category_id, language_id, duration, release_year, rating, video_url, thumbnail, poster, is_featured, is_published, created_at, updated_at) VALUES
-- Movie 1
('{"en":"Desert Storm","ar":"عاصفة الصحراء"}', 'desert-storm', '{"en":"An epic action movie set in the Arabian desert","ar":"فيلم أكشن ملحمي يدور في الصحراء العربية"}', 1, 1, 135, 2024, 4.7, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Desert+Storm', 'https://via.placeholder.com/1920x1080.png?text=Desert+Storm', 1, 1, NOW(), NOW()),

-- Movie 2
('{"en":"The Last Stand","ar":"الموقف الأخير"}', 'the-last-stand', '{"en":"A thrilling drama about courage and sacrifice","ar":"دراما مشوقة عن الشجاعة والتضحية"}', 2, 1, 145, 2024, 4.5, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Last+Stand', 'https://via.placeholder.com/1920x1080.png?text=Last+Stand', 1, 1, NOW(), NOW()),

-- Movie 3
('{"en":"Laugh Out Loud","ar":"اضحك بصوت عالي"}', 'laugh-out-loud', '{"en":"The funniest comedy of the year","ar":"أفضل كوميديا لهذا العام"}', 3, 2, 95, 2024, 4.2, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Comedy', 'https://via.placeholder.com/1920x1080.png?text=Comedy', 1, 1, NOW(), NOW()),

-- Movie 4
('{"en":"Midnight Terror","ar":"رعب منتصف الليل"}', 'midnight-terror', '{"en":"A terrifying horror experience","ar":"تجربة رعب مرعبة"}', 4, 2, 110, 2023, 4.3, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Horror', 'https://via.placeholder.com/1920x1080.png?text=Horror', 0, 1, NOW(), NOW()),

-- Movie 5
('{"en":"Eternal Love","ar":"حب أبدي"}', 'eternal-love', '{"en":"A beautiful romantic story","ar":"قصة رومانسية جميلة"}', 5, 1, 125, 2024, 4.6, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Romance', 'https://via.placeholder.com/1920x1080.png?text=Romance', 1, 1, NOW(), NOW()),

-- Movie 6
('{"en":"Ocean Depths","ar":"أعماق المحيط"}', 'ocean-depths', '{"en":"Explore the mysteries of the deep sea","ar":"استكشف أسرار أعماق البحار"}', 6, 2, 90, 2024, 4.8, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Documentary', 'https://via.placeholder.com/1920x1080.png?text=Documentary', 1, 1, NOW(), NOW()),

-- Movie 7
('{"en":"Championship Glory","ar":"مجد البطولة"}', 'championship-glory', '{"en":"The journey to victory","ar":"رحلة نحو النصر"}', 7, 1, 115, 2023, 4.4, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Sports', 'https://via.placeholder.com/1920x1080.png?text=Sports', 0, 1, NOW(), NOW()),

-- Movie 8
('{"en":"Magic Kingdom","ar":"المملكة السحرية"}', 'magic-kingdom', '{"en":"An animated adventure for the whole family","ar":"مغامرة رسوم متحركة للعائلة"}', 8, 2, 100, 2024, 4.9, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Animation', 'https://via.placeholder.com/1920x1080.png?text=Animation', 1, 1, NOW(), NOW()),

-- Movie 9
('{"en":"Edge of Tomorrow","ar":"حافة الغد"}', 'edge-of-tomorrow', '{"en":"A mind-bending sci-fi thriller","ar":"إثارة خيال علمي مذهلة"}', 10, 2, 130, 2023, 4.5, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=SciFi', 'https://via.placeholder.com/1920x1080.png?text=SciFi', 0, 1, NOW(), NOW()),

-- Movie 10
('{"en":"Silent Witness","ar":"الشاهد الصامت"}', 'silent-witness', '{"en":"A gripping thriller that will keep you on edge","ar":"إثارة مشوقة ستبقيك متوتراً"}', 9, 1, 120, 2024, 4.4, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x450.png?text=Thriller', 'https://via.placeholder.com/1920x1080.png?text=Thriller', 1, 1, NOW(), NOW());

-- 4. Series (5 مسلسلات)
-- ============================================
INSERT INTO series (title, slug, description, category_id, language_id, release_year, rating, thumbnail, poster, is_featured, is_published, created_at, updated_at) VALUES
-- Series 1
('{"en":"City Lights","ar":"أضواء المدينة"}', 'city-lights', '{"en":"A drama series about life in the big city","ar":"مسلسل درامي عن الحياة في المدينة الكبيرة"}', 2, 1, 2024, 4.6, 'https://via.placeholder.com/300x450.png?text=City+Lights', 'https://via.placeholder.com/1920x1080.png?text=City+Lights', 1, 1, NOW(), NOW()),

-- Series 2
('{"en":"Desert Nomads","ar":"بدو الصحراء"}', 'desert-nomads', '{"en":"Follow the adventures of desert tribes","ar":"تابع مغامرات قبائل الصحراء"}', 1, 1, 2024, 4.7, 'https://via.placeholder.com/300x450.png?text=Desert+Nomads', 'https://via.placeholder.com/1920x1080.png?text=Desert+Nomads', 1, 1, NOW(), NOW()),

-- Series 3
('{"en":"Family Matters","ar":"شؤون العائلة"}', 'family-matters', '{"en":"A heartwarming comedy series","ar":"مسلسل كوميدي دافئ"}', 3, 2, 2023, 4.5, 'https://via.placeholder.com/300x450.png?text=Family+Matters', 'https://via.placeholder.com/1920x1080.png?text=Family+Matters', 1, 1, NOW(), NOW()),

-- Series 4
('{"en":"Mystery Files","ar":"ملفات غامضة"}', 'mystery-files', '{"en":"Uncover the truth behind mysterious cases","ar":"اكتشف الحقيقة وراء القضايا الغامضة"}', 9, 2, 2024, 4.8, 'https://via.placeholder.com/300x450.png?text=Mystery+Files', 'https://via.placeholder.com/1920x1080.png?text=Mystery+Files', 1, 1, NOW(), NOW()),

-- Series 5
('{"en":"Future World","ar":"عالم المستقبل"}', 'future-world', '{"en":"Explore the possibilities of tomorrow","ar":"استكشف إمكانيات المستقبل"}', 10, 1, 2024, 4.9, 'https://via.placeholder.com/300x450.png?text=Future+World', 'https://via.placeholder.com/1920x1080.png?text=Future+World', 1, 1, NOW(), NOW());

-- 5. Episodes (25 حلقة - 5 حلقات لكل مسلسل)
-- ============================================
-- Episodes for Series 1 (City Lights)
INSERT INTO episodes (series_id, title, slug, description, season_number, episode_number, duration, video_url, thumbnail, is_published, created_at, updated_at) VALUES
(1, '{"en":"Episode 1: New Beginnings","ar":"الحلقة 1: بدايات جديدة"}', 'city-lights-s1e1', '{"en":"The journey begins","ar":"تبدأ الرحلة"}', 1, 1, 45, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=E1', 1, NOW(), NOW()),
(1, '{"en":"Episode 2: The Challenge","ar":"الحلقة 2: التحدي"}', 'city-lights-s1e2', '{"en":"Facing new obstacles","ar":"مواجهة عقبات جديدة"}', 1, 2, 45, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=E2', 1, NOW(), NOW()),
(1, '{"en":"Episode 3: Turning Point","ar":"الحلقة 3: نقطة التحول"}', 'city-lights-s1e3', '{"en":"Everything changes","ar":"كل شيء يتغير"}', 1, 3, 45, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=E3', 1, NOW(), NOW()),
(1, '{"en":"Episode 4: The Truth","ar":"الحلقة 4: الحقيقة"}', 'city-lights-s1e4', '{"en":"Secrets revealed","ar":"أسرار تُكشف"}', 1, 4, 45, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=E4', 1, NOW(), NOW()),
(1, '{"en":"Episode 5: Resolution","ar":"الحلقة 5: الحل"}', 'city-lights-s1e5', '{"en":"The season finale","ar":"نهاية الموسم"}', 1, 5, 50, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=E5', 1, NOW(), NOW()),

-- Episodes for Series 2 (Desert Nomads)
(2, '{"en":"Episode 1: The Desert Awakens","ar":"الحلقة 1: الصحراء تستيقظ"}', 'desert-nomads-s1e1', '{"en":"A new adventure begins","ar":"مغامرة جديدة تبدأ"}', 1, 1, 42, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=DN+E1', 1, NOW(), NOW()),
(2, '{"en":"Episode 2: Ancient Secrets","ar":"الحلقة 2: أسرار قديمة"}', 'desert-nomads-s1e2', '{"en":"Discovering the past","ar":"اكتشاف الماضي"}', 1, 2, 42, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=DN+E2', 1, NOW(), NOW()),
(2, '{"en":"Episode 3: The Storm","ar":"الحلقة 3: العاصفة"}', 'desert-nomads-s1e3', '{"en":"Nature strikes back","ar":"الطبيعة ترد"}', 1, 3, 42, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=DN+E3', 1, NOW(), NOW()),
(2, '{"en":"Episode 4: Unity","ar":"الحلقة 4: الوحدة"}', 'desert-nomads-s1e4', '{"en":"Together we stand","ar":"معاً نقف"}', 1, 4, 42, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=DN+E4', 1, NOW(), NOW()),
(2, '{"en":"Episode 5: New Horizons","ar":"الحلقة 5: آفاق جديدة"}', 'desert-nomads-s1e5', '{"en":"Looking to the future","ar":"النظر إلى المستقبل"}', 1, 5, 45, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=DN+E5', 1, NOW(), NOW()),

-- Episodes for Series 3 (Family Matters)
(3, '{"en":"Episode 1: Home Sweet Home","ar":"الحلقة 1: البيت الحلو"}', 'family-matters-s1e1', '{"en":"Family reunites","ar":"العائلة تجتمع"}', 1, 1, 25, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FM+E1', 1, NOW(), NOW()),
(3, '{"en":"Episode 2: The Surprise","ar":"الحلقة 2: المفاجأة"}', 'family-matters-s1e2', '{"en":"Unexpected guests","ar":"ضيوف غير متوقعين"}', 1, 2, 25, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FM+E2', 1, NOW(), NOW()),
(3, '{"en":"Episode 3: The Mix-Up","ar":"الحلقة 3: الخلط"}', 'family-matters-s1e3', '{"en":"Hilarious confusion","ar":"لبس مضحك"}', 1, 3, 25, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FM+E3', 1, NOW(), NOW()),
(3, '{"en":"Episode 4: The Celebration","ar":"الحلقة 4: الاحتفال"}', 'family-matters-s1e4', '{"en":"A special occasion","ar":"مناسبة خاصة"}', 1, 4, 25, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FM+E4', 1, NOW(), NOW()),
(3, '{"en":"Episode 5: Lessons Learned","ar":"الحلقة 5: دروس مستفادة"}', 'family-matters-s1e5', '{"en":"Growing together","ar":"النمو معاً"}', 1, 5, 25, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FM+E5', 1, NOW(), NOW()),

-- Episodes for Series 4 (Mystery Files)
(4, '{"en":"Episode 1: Case #001","ar":"الحلقة 1: قضية #001"}', 'mystery-files-s1e1', '{"en":"The first investigation","ar":"التحقيق الأول"}', 1, 1, 50, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=MF+E1', 1, NOW(), NOW()),
(4, '{"en":"Episode 2: Hidden Clues","ar":"الحلقة 2: أدلة مخفية"}', 'mystery-files-s1e2', '{"en":"Following the trail","ar":"تتبع الأثر"}', 1, 2, 50, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=MF+E2', 1, NOW(), NOW()),
(4, '{"en":"Episode 3: The Witness","ar":"الحلقة 3: الشاهد"}', 'mystery-files-s1e3', '{"en":"A key testimony","ar":"شهادة رئيسية"}', 1, 3, 50, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=MF+E3', 1, NOW(), NOW()),
(4, '{"en":"Episode 4: Breakthrough","ar":"الحلقة 4: اختراق"}', 'mystery-files-s1e4', '{"en":"The case breaks open","ar":"القضية تنفتح"}', 1, 4, 50, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=MF+E4', 1, NOW(), NOW()),
(4, '{"en":"Episode 5: Justice Served","ar":"الحلقة 5: تحقيق العدالة"}', 'mystery-files-s1e5', '{"en":"The final reveal","ar":"الكشف النهائي"}', 1, 5, 55, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=MF+E5', 1, NOW(), NOW()),

-- Episodes for Series 5 (Future World)
(5, '{"en":"Episode 1: 2084","ar":"الحلقة 1: 2084"}', 'future-world-s1e1', '{"en":"Welcome to the future","ar":"مرحباً بك في المستقبل"}', 1, 1, 48, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FW+E1', 1, NOW(), NOW()),
(5, '{"en":"Episode 2: The Awakening","ar":"الحلقة 2: الصحوة"}', 'future-world-s1e2', '{"en":"AI becomes aware","ar":"الذكاء الاصطناعي يصبح واعياً"}', 1, 2, 48, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FW+E2', 1, NOW(), NOW()),
(5, '{"en":"Episode 3: Rebellion","ar":"الحلقة 3: التمرد"}', 'future-world-s1e3', '{"en":"Fighting for freedom","ar":"القتال من أجل الحرية"}', 1, 3, 48, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FW+E3', 1, NOW(), NOW()),
(5, '{"en":"Episode 4: Alliance","ar":"الحلقة 4: التحالف"}', 'future-world-s1e4', '{"en":"Unexpected partnerships","ar":"شراكات غير متوقعة"}', 1, 4, 48, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FW+E4', 1, NOW(), NOW()),
(5, '{"en":"Episode 5: New Dawn","ar":"الحلقة 5: فجر جديد"}', 'future-world-s1e5', '{"en":"Hope for tomorrow","ar":"أمل للغد"}', 1, 5, 52, 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'https://via.placeholder.com/300x200.png?text=FW+E5', 1, NOW(), NOW());

-- 6. Pages (الصفحات الثابتة)
-- ============================================
INSERT INTO pages (slug, title, content, is_published, created_at, updated_at) VALUES
('about-us', '{"en":"About Us","ar":"من نحن"}', '{"en":"<h1>About Alenwan</h1><p>Alenwan is the premier Arabic streaming platform.</p>","ar":"<h1>عن Alenwan</h1><p>Alenwan هي منصة البث العربية الرائدة.</p>"}', 1, NOW(), NOW()),
('privacy-policy', '{"en":"Privacy Policy","ar":"سياسة الخصوصية"}', '{"en":"<h1>Privacy Policy</h1><p>We respect your privacy.</p>","ar":"<h1>سياسة الخصوصية</h1><p>نحن نحترم خصوصيتك.</p>"}', 1, NOW(), NOW()),
('terms-conditions', '{"en":"Terms & Conditions","ar":"الشروط والأحكام"}', '{"en":"<h1>Terms & Conditions</h1><p>By using our service, you agree to these terms.</p>","ar":"<h1>الشروط والأحكام</h1><p>باستخدام خدمتنا، فإنك توافق على هذه الشروط.</p>"}', 1, NOW(), NOW()),
('support', '{"en":"Support","ar":"الدعم"}', '{"en":"<h1>Support Center</h1><p>Need help? Contact us.</p>","ar":"<h1>مركز الدعم</h1><p>تحتاج مساعدة؟ اتصل بنا.</p>"}', 1, NOW(), NOW()),
('faq', '{"en":"FAQ","ar":"الأسئلة الشائعة"}', '{"en":"<h1>Frequently Asked Questions</h1><p>Find answers here.</p>","ar":"<h1>الأسئلة الشائعة</h1><p>ابحث عن الإجابات هنا.</p>"}', 1, NOW(), NOW()),
('contact-us', '{"en":"Contact Us","ar":"اتصل بنا"}', '{"en":"<h1>Contact Us</h1><p>Get in touch.</p>","ar":"<h1>اتصل بنا</h1><p>تواصل معنا.</p>"}', 1, NOW(), NOW()),
('features', '{"en":"Features","ar":"الميزات"}', '{"en":"<h1>Features</h1><p>Discover our amazing features.</p>","ar":"<h1>الميزات</h1><p>اكتشف ميزاتنا الرائعة.</p>"}', 1, NOW(), NOW()),
('pricing', '{"en":"Pricing","ar":"الأسعار"}', '{"en":"<h1>Pricing Plans</h1><p>Choose the perfect plan.</p>","ar":"<h1>خطط الأسعار</h1><p>اختر الخطة المثالية.</p>"}', 1, NOW(), NOW());

-- 7. Subscription Plans (خطط الاشتراك)
-- ============================================
INSERT INTO subscription_plans (name, description, price, currency, duration_days, features, is_active, created_at, updated_at) VALUES
('{"en":"Monthly Plan","ar":"الخطة الشهرية"}', '{"en":"Perfect for trying out our service","ar":"مثالية لتجربة خدمتنا"}', 9.99, 'USD', 30, '{"en":["HD Quality","Unlimited Streaming","3 Devices","No Ads"],"ar":["جودة عالية","بث غير محدود","3 أجهزة","بدون إعلانات"]}', 1, NOW(), NOW()),
('{"en":"Quarterly Plan","ar":"الخطة الربع سنوية"}', '{"en":"3 months - Save 10%","ar":"3 أشهر - وفر 10%"}', 26.99, 'USD', 90, '{"en":["HD Quality","Unlimited Streaming","5 Devices","No Ads","Offline Downloads"],"ar":["جودة عالية","بث غير محدود","5 أجهزة","بدون إعلانات","تحميل للمشاهدة بدون إنترنت"]}', 1, NOW(), NOW()),
('{"en":"Yearly Plan","ar":"الخطة السنوية"}', '{"en":"12 months - Save 25%","ar":"12 شهر - وفر 25%"}', 89.99, 'USD', 365, '{"en":["4K Ultra HD","Unlimited Streaming","10 Devices","No Ads","Offline Downloads","Early Access"],"ar":["4K جودة فائقة","بث غير محدود","10 أجهزة","بدون إعلانات","تحميل للمشاهدة بدون إنترنت","وصول مبكر"]}', 1, NOW(), NOW());

-- ============================================
-- Setup Complete!
-- ============================================
-- Total Content Added:
-- - 10 Categories
-- - 5 Languages
-- - 10 Movies
-- - 5 Series with 25 Episodes
-- - 8 Pages
-- - 3 Subscription Plans
-- ============================================
