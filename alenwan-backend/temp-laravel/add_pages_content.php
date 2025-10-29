<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Page;

echo "📄 إضافة الصفحات الثابتة...

";

$pages = [
    [
        'title' => ['ar' => 'من نحن', 'en' => 'About Us'],
        'slug' => 'about-us',
        'type' => 'about',
        'content' => [
            'ar' => '<h2>عن منصة ألوان</h2>
<p>ألوان هي منصة رائدة لبث المحتوى المرئي والمسموع في الوطن العربي. نقدم مجموعة متنوعة من الأفلام والمسلسلات والبودكاست والبثوث المباشرة.</p>
<h3>رؤيتنا</h3>
<p>أن نكون المنصة الأولى للمحتوى العربي الأصيل والمميز في المنطقة العربية والعالم.</p>
<h3>رسالتنا</h3>
<p>توفير تجربة مشاهدة استثنائية مع محتوى عالي الجودة يناسب جميع أفراد العائلة.</p>',
            'en' => '<h2>About Alenwan Platform</h2>
<p>Alenwan is a leading platform for streaming audio and visual content in the Arab world. We offer a diverse range of movies, series, podcasts, and live broadcasts.</p>
<h3>Our Vision</h3>
<p>To be the leading platform for authentic and distinguished Arabic content in the Arab region and the world.</p>
<h3>Our Mission</h3>
<p>To provide an exceptional viewing experience with high-quality content suitable for all family members.</p>'
        ],
        'meta_title' => ['ar' => 'من نحن - منصة ألوان', 'en' => 'About Us - Alenwan Platform'],
        'meta_description' => ['ar' => 'تعرف على منصة ألوان، المنصة الرائدة لبث المحتوى المرئي والمسموع في الوطن العربي', 'en' => 'Learn about Alenwan, the leading platform for streaming audio and visual content in the Arab world'],
        'icon' => 'information-circle',
        'order' => 1,
        'is_published' => true,
        'show_in_menu' => true,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الميزات', 'en' => 'Features'],
        'slug' => 'features',
        'type' => 'features',
        'content' => [
            'ar' => '<h2>ميزات منصة ألوان</h2>
<h3>📱 تطبيقات لجميع الأجهزة</h3>
<p>استمتع بالمشاهدة على جميع أجهزتك المفضلة - الهواتف الذكية والأجهزة اللوحية والتلفزيون الذكي.</p>
<h3>🎬 محتوى حصري</h3>
<p>أفلام ومسلسلات حصرية لا تجدها في أي مكان آخر.</p>
<h3>🌐 متعدد اللغات</h3>
<p>محتوى بلغات متعددة مع ترجمة صوتية فورية.</p>
<h3>📺 بث مباشر</h3>
<p>شاهد البثوث المباشرة من قنواتك المفضلة.</p>
<h3>⬇️ تحميل للمشاهدة دون إنترنت</h3>
<p>حمل المحتوى المفضل لديك واستمتع بالمشاهدة في أي مكان.</p>',
            'en' => '<h2>Alenwan Platform Features</h2>
<h3>📱 Apps for All Devices</h3>
<p>Enjoy watching on all your favorite devices - smartphones, tablets, and smart TVs.</p>
<h3>🎬 Exclusive Content</h3>
<p>Exclusive movies and series that you won\'t find anywhere else.</p>
<h3>🌐 Multi-Language</h3>
<p>Multilingual content with instant audio translation.</p>
<h3>📺 Live Streaming</h3>
<p>Watch live broadcasts from your favorite channels.</p>
<h3>⬇️ Download for Offline Viewing</h3>
<p>Download your favorite content and enjoy watching anywhere.</p>'
        ],
        'meta_title' => ['ar' => 'الميزات - منصة ألوان', 'en' => 'Features - Alenwan Platform'],
        'meta_description' => ['ar' => 'اكتشف ميزات منصة ألوان المتقدمة للمشاهدة والبث المباشر', 'en' => 'Discover the advanced features of Alenwan platform for watching and live streaming'],
        'icon' => 'sparkles',
        'order' => 2,
        'is_published' => true,
        'show_in_menu' => true,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الأسعار', 'en' => 'Pricing'],
        'slug' => 'pricing',
        'type' => 'pricing',
        'content' => [
            'ar' => '<h2>خطط الاشتراك في ألوان</h2>
<p>اختر الخطة المناسبة لك واستمتع بمشاهدة غير محدودة.</p>
<h3>الخطة الأساسية - 29 ريال/شهر</h3>
<ul>
<li>مشاهدة على جهاز واحد</li>
<li>جودة SD</li>
<li>مكتبة أفلام ومسلسلات محدودة</li>
</ul>
<h3>الخطة المميزة - 49 ريال/شهر</h3>
<ul>
<li>مشاهدة على 3 أجهزة</li>
<li>جودة HD</li>
<li>مكتبة كاملة</li>
<li>تحميل دون إنترنت</li>
</ul>
<h3>الخطة الذهبية - 79 ريال/شهر</h3>
<ul>
<li>مشاهدة على 5 أجهزة</li>
<li>جودة 4K Ultra HD</li>
<li>مكتبة كاملة + محتوى حصري</li>
<li>تحميل دون إنترنت</li>
<li>بث مباشر للقنوات الرياضية</li>
</ul>',
            'en' => '<h2>Alenwan Subscription Plans</h2>
<p>Choose the plan that suits you and enjoy unlimited viewing.</p>
<h3>Basic Plan - 29 SAR/month</h3>
<ul>
<li>Watch on 1 device</li>
<li>SD quality</li>
<li>Limited library of movies and series</li>
</ul>
<h3>Premium Plan - 49 SAR/month</h3>
<ul>
<li>Watch on 3 devices</li>
<li>HD quality</li>
<li>Full library</li>
<li>Offline download</li>
</ul>
<h3>Gold Plan - 79 SAR/month</h3>
<ul>
<li>Watch on 5 devices</li>
<li>4K Ultra HD quality</li>
<li>Full library + exclusive content</li>
<li>Offline download</li>
<li>Live sports channels</li>
</ul>'
        ],
        'meta_title' => ['ar' => 'الأسعار - منصة ألوان', 'en' => 'Pricing - Alenwan Platform'],
        'meta_description' => ['ar' => 'اطلع على خطط وأسعار الاشتراك في منصة ألوان', 'en' => 'View subscription plans and prices for Alenwan platform'],
        'icon' => 'currency-dollar',
        'order' => 3,
        'is_published' => true,
        'show_in_menu' => true,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الأسئلة الشائعة', 'en' => 'FAQ'],
        'slug' => 'faq',
        'type' => 'faq',
        'content' => [
            'ar' => '<h2>الأسئلة الشائعة</h2>
<h3>كيف أبدأ الاشتراك؟</h3>
<p>قم بتحميل التطبيق واختر الخطة المناسبة لك، ثم أدخل بيانات الدفع لبدء الاشتراك.</p>
<h3>هل يمكنني إلغاء الاشتراك في أي وقت؟</h3>
<p>نعم، يمكنك إلغاء الاشتراك في أي وقت دون أي رسوم إضافية.</p>
<h3>على كم جهاز يمكنني المشاهدة؟</h3>
<p>يعتمد ذلك على خطة الاشتراك الخاصة بك. تتراوح من جهاز واحد إلى 5 أجهزة.</p>
<h3>هل يمكنني تحميل المحتوى؟</h3>
<p>نعم، الخطط المميزة والذهبية تتيح لك تحميل المحتوى للمشاهدة دون إنترنت.</p>',
            'en' => '<h2>Frequently Asked Questions</h2>
<h3>How do I start a subscription?</h3>
<p>Download the app, choose the plan that suits you, then enter your payment details to start your subscription.</p>
<h3>Can I cancel my subscription anytime?</h3>
<p>Yes, you can cancel your subscription at any time without any additional fees.</p>
<h3>On how many devices can I watch?</h3>
<p>It depends on your subscription plan. It ranges from 1 device to 5 devices.</p>
<h3>Can I download content?</h3>
<p>Yes, Premium and Gold plans allow you to download content for offline viewing.</p>'
        ],
        'meta_title' => ['ar' => 'الأسئلة الشائعة - منصة ألوان', 'en' => 'FAQ - Alenwan Platform'],
        'meta_description' => ['ar' => 'إجابات عن الأسئلة الشائعة حول منصة ألوان', 'en' => 'Answers to frequently asked questions about Alenwan platform'],
        'icon' => 'question-mark-circle',
        'order' => 4,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الدعم ومركز المساعدة', 'en' => 'Support & Help Center'],
        'slug' => 'support',
        'type' => 'support',
        'content' => [
            'ar' => '<h2>الدعم الفني</h2>
<p>نحن هنا لمساعدتك! تواصل معنا عبر:</p>
<ul>
<li>📧 البريد الإلكتروني: support@alenwan.com</li>
<li>📞 الهاتف: 920000000</li>
<li>💬 الدردشة المباشرة: متاحة 24/7</li>
</ul>
<h3>ساعات العمل</h3>
<p>فريق الدعم متاح من السبت إلى الخميس من 9 صباحاً حتى 9 مساءً.</p>
<h3>الموضوعات الشائعة</h3>
<ul>
<li>مشاكل تسجيل الدخول</li>
<li>مشاكل الدفع والفوترة</li>
<li>جودة البث</li>
<li>مشاكل التطبيق</li>
</ul>',
            'en' => '<h2>Technical Support</h2>
<p>We\'re here to help! Contact us via:</p>
<ul>
<li>📧 Email: support@alenwan.com</li>
<li>📞 Phone: 920000000</li>
<li>💬 Live Chat: Available 24/7</li>
</ul>
<h3>Business Hours</h3>
<p>Support team is available Saturday to Thursday from 9 AM to 9 PM.</p>
<h3>Common Topics</h3>
<ul>
<li>Login Issues</li>
<li>Payment and Billing Issues</li>
<li>Streaming Quality</li>
<li>App Issues</li>
</ul>'
        ],
        'meta_title' => ['ar' => 'الدعم - منصة ألوان', 'en' => 'Support - Alenwan Platform'],
        'meta_description' => ['ar' => 'تواصل مع فريق الدعم الفني لمنصة ألوان', 'en' => 'Contact Alenwan platform technical support team'],
        'icon' => 'lifebuoy',
        'order' => 5,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'اتصل بنا', 'en' => 'Contact Us'],
        'slug' => 'contact',
        'type' => 'contact',
        'content' => [
            'ar' => '<h2>اتصل بنا</h2>
<h3>معلومات التواصل</h3>
<p><strong>العنوان:</strong> الرياض، المملكة العربية السعودية</p>
<p><strong>البريد الإلكتروني:</strong> info@alenwan.com</p>
<p><strong>الهاتف:</strong> 920000000</p>
<h3>أوقات العمل</h3>
<p>من السبت إلى الخميس: 9:00 ص - 9:00 م</p>
<p>الجمعة: مغلق</p>
<h3>وسائل التواصل الاجتماعي</h3>
<ul>
<li>تويتر: @AlenwanTV</li>
<li>إنستغرام: @AlenwanTV</li>
<li>فيسبوك: /AlenwanTV</li>
</ul>',
            'en' => '<h2>Contact Us</h2>
<h3>Contact Information</h3>
<p><strong>Address:</strong> Riyadh, Saudi Arabia</p>
<p><strong>Email:</strong> info@alenwan.com</p>
<p><strong>Phone:</strong> 920000000</p>
<h3>Business Hours</h3>
<p>Saturday to Thursday: 9:00 AM - 9:00 PM</p>
<p>Friday: Closed</p>
<h3>Social Media</h3>
<ul>
<li>Twitter: @AlenwanTV</li>
<li>Instagram: @AlenwanTV</li>
<li>Facebook: /AlenwanTV</li>
</ul>'
        ],
        'meta_title' => ['ar' => 'اتصل بنا - منصة ألوان', 'en' => 'Contact Us - Alenwan Platform'],
        'meta_description' => ['ar' => 'تواصل معنا للاستفسارات والدعم', 'en' => 'Contact us for inquiries and support'],
        'icon' => 'envelope',
        'order' => 6,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الشروط والأحكام', 'en' => 'Terms and Conditions'],
        'slug' => 'terms',
        'type' => 'terms',
        'content' => [
            'ar' => '<h2>الشروط والأحكام</h2>
<p>آخر تحديث: ' . date('Y-m-d') . '</p>
<h3>1. القبول بالشروط</h3>
<p>باستخدام منصة ألوان، فإنك توافق على الالتزام بهذه الشروط والأحكام.</p>
<h3>2. الاشتراك والحساب</h3>
<p>يجب أن يكون عمرك 18 عاماً أو أكثر للاشتراك في الخدمة.</p>
<h3>3. الاستخدام المقبول</h3>
<p>يحظر استخدام الخدمة لأي غرض غير قانوني أو غير مصرح به.</p>
<h3>4. حقوق الملكية الفكرية</h3>
<p>جميع المحتويات محمية بموجب قوانين حقوق النشر والملكية الفكرية.</p>',
            'en' => '<h2>Terms and Conditions</h2>
<p>Last updated: ' . date('Y-m-d') . '</p>
<h3>1. Acceptance of Terms</h3>
<p>By using Alenwan platform, you agree to be bound by these terms and conditions.</p>
<h3>2. Subscription and Account</h3>
<p>You must be 18 years or older to subscribe to the service.</p>
<h3>3. Acceptable Use</h3>
<p>Use of the service for any illegal or unauthorized purpose is prohibited.</p>
<h3>4. Intellectual Property Rights</h3>
<p>All content is protected under copyright and intellectual property laws.</p>'
        ],
        'meta_title' => ['ar' => 'الشروط والأحكام - منصة ألوان', 'en' => 'Terms and Conditions - Alenwan Platform'],
        'meta_description' => ['ar' => 'اطلع على شروط وأحكام استخدام منصة ألوان', 'en' => 'View the terms and conditions for using Alenwan platform'],
        'icon' => 'document-text',
        'order' => 7,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'سياسة الخصوصية', 'en' => 'Privacy Policy'],
        'slug' => 'privacy',
        'type' => 'privacy',
        'content' => [
            'ar' => '<h2>سياسة الخصوصية</h2>
<p>آخر تحديث: ' . date('Y-m-d') . '</p>
<h3>1. المعلومات التي نجمعها</h3>
<p>نجمع المعلومات الشخصية التي تقدمها لنا عند التسجيل والاستخدام.</p>
<h3>2. كيف نستخدم معلوماتك</h3>
<p>نستخدم معلوماتك لتوفير وتحسين خدماتنا وللتواصل معك.</p>
<h3>3. مشاركة المعلومات</h3>
<p>لا نشارك معلوماتك الشخصية مع أطراف ثالثة دون موافقتك.</p>
<h3>4. أمن المعلومات</h3>
<p>نتخذ تدابير أمنية مناسبة لحماية معلوماتك الشخصية.</p>',
            'en' => '<h2>Privacy Policy</h2>
<p>Last updated: ' . date('Y-m-d') . '</p>
<h3>1. Information We Collect</h3>
<p>We collect personal information you provide when registering and using our service.</p>
<h3>2. How We Use Your Information</h3>
<p>We use your information to provide and improve our services and to communicate with you.</p>
<h3>3. Information Sharing</h3>
<p>We do not share your personal information with third parties without your consent.</p>
<h3>4. Information Security</h3>
<p>We take appropriate security measures to protect your personal information.</p>'
        ],
        'meta_title' => ['ar' => 'سياسة الخصوصية - منصة ألوان', 'en' => 'Privacy Policy - Alenwan Platform'],
        'meta_description' => ['ar' => 'اطلع على سياسة الخصوصية الخاصة بمنصة ألوان', 'en' => 'View the privacy policy of Alenwan platform'],
        'icon' => 'shield-check',
        'order' => 8,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'الأمان والخصوصية', 'en' => 'Security and Privacy'],
        'slug' => 'security',
        'type' => 'security',
        'content' => [
            'ar' => '<h2>الأمان والخصوصية</h2>
<h3>التزامنا بالأمان</h3>
<p>نأخذ أمان بياناتك على محمل الجد ونستخدم أحدث التقنيات لحماية معلوماتك.</p>
<h3>التشفير</h3>
<p>جميع البيانات المرسلة عبر منصتنا مشفرة باستخدام SSL/TLS.</p>
<h3>المصادقة الثنائية</h3>
<p>نوصي بتفعيل المصادقة الثنائية لحماية حسابك.</p>
<h3>إدارة كلمات المرور</h3>
<p>يتم تخزين كلمات المرور بشكل مشفر ولا يمكن لأي شخص الوصول إليها.</p>',
            'en' => '<h2>Security and Privacy</h2>
<h3>Our Security Commitment</h3>
<p>We take your data security seriously and use the latest technologies to protect your information.</p>
<h3>Encryption</h3>
<p>All data transmitted through our platform is encrypted using SSL/TLS.</p>
<h3>Two-Factor Authentication</h3>
<p>We recommend enabling two-factor authentication to protect your account.</p>
<h3>Password Management</h3>
<p>Passwords are stored encrypted and cannot be accessed by anyone.</p>'
        ],
        'meta_title' => ['ar' => 'الأمان - منصة ألوان', 'en' => 'Security - Alenwan Platform'],
        'meta_description' => ['ar' => 'معلومات حول أمان وخصوصية بياناتك على منصة ألوان', 'en' => 'Information about security and privacy of your data on Alenwan platform'],
        'icon' => 'lock-closed',
        'order' => 9,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'سياسة الإلغاء', 'en' => 'Cancellation Policy'],
        'slug' => 'cancellation',
        'type' => 'cancellation',
        'content' => [
            'ar' => '<h2>سياسة الإلغاء</h2>
<h3>إلغاء الاشتراك</h3>
<p>يمكنك إلغاء اشتراكك في أي وقت دون أي رسوم إلغاء.</p>
<h3>كيفية الإلغاء</h3>
<ol>
<li>انتقل إلى إعدادات الحساب</li>
<li>اختر "إدارة الاشتراك"</li>
<li>انقر على "إلغاء الاشتراك"</li>
</ol>
<h3>متى يصبح الإلغاء فعالاً؟</h3>
<p>ستستمر في الاستفادة من الخدمة حتى نهاية دورة الفوترة الحالية.</p>
<h3>إعادة الاشتراك</h3>
<p>يمكنك إعادة الاشتراك في أي وقت بعد الإلغاء.</p>',
            'en' => '<h2>Cancellation Policy</h2>
<h3>Subscription Cancellation</h3>
<p>You can cancel your subscription at any time without any cancellation fees.</p>
<h3>How to Cancel</h3>
<ol>
<li>Go to Account Settings</li>
<li>Select "Manage Subscription"</li>
<li>Click "Cancel Subscription"</li>
</ol>
<h3>When Does Cancellation Take Effect?</h3>
<p>You will continue to enjoy the service until the end of your current billing cycle.</p>
<h3>Re-subscribing</h3>
<p>You can re-subscribe at any time after cancellation.</p>'
        ],
        'meta_title' => ['ar' => 'سياسة الإلغاء - منصة ألوان', 'en' => 'Cancellation Policy - Alenwan Platform'],
        'meta_description' => ['ar' => 'تعرف على سياسة إلغاء الاشتراك في منصة ألوان', 'en' => 'Learn about the subscription cancellation policy on Alenwan platform'],
        'icon' => 'x-circle',
        'order' => 10,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'سياسة الاسترداد', 'en' => 'Refund Policy'],
        'slug' => 'refund',
        'type' => 'refund',
        'content' => [
            'ar' => '<h2>سياسة الاسترداد</h2>
<h3>الاسترداد خلال 7 أيام</h3>
<p>نوفر ضمان استرداد كامل خلال 7 أيام من الاشتراك الأول.</p>
<h3>شروط الاسترداد</h3>
<ul>
<li>طلب الاسترداد خلال 7 أيام من تاريخ الاشتراك</li>
<li>للمشتركين الجدد فقط</li>
<li>لم يتم استخدام الخدمة بشكل مكثف</li>
</ul>
<h3>كيفية طلب الاسترداد</h3>
<p>تواصل مع فريق الدعم عبر البريد الإلكتروني أو الدردشة المباشرة.</p>
<h3>مدة معالجة الاسترداد</h3>
<p>يتم معالجة طلبات الاسترداد خلال 5-7 أيام عمل.</p>',
            'en' => '<h2>Refund Policy</h2>
<h3>7-Day Refund</h3>
<p>We offer a full refund within 7 days of the first subscription.</p>
<h3>Refund Conditions</h3>
<ul>
<li>Request refund within 7 days of subscription date</li>
<li>For new subscribers only</li>
<li>Service not heavily used</li>
</ul>
<h3>How to Request a Refund</h3>
<p>Contact the support team via email or live chat.</p>
<h3>Refund Processing Time</h3>
<p>Refund requests are processed within 5-7 business days.</p>'
        ],
        'meta_title' => ['ar' => 'سياسة الاسترداد - منصة ألوان', 'en' => 'Refund Policy - Alenwan Platform'],
        'meta_description' => ['ar' => 'تعرف على سياسة استرداد المبالغ في منصة ألوان', 'en' => 'Learn about the refund policy on Alenwan platform'],
        'icon' => 'arrow-path',
        'order' => 11,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
    [
        'title' => ['ar' => 'سياسة حذف الاشتراك', 'en' => 'Subscription Deletion Policy'],
        'slug' => 'subscription-delete',
        'type' => 'subscription_delete',
        'content' => [
            'ar' => '<h2>سياسة حذف الاشتراك والحساب</h2>
<h3>حذف الحساب</h3>
<p>يمكنك طلب حذف حسابك بشكل نهائي في أي وقت.</p>
<h3>ما يحدث عند حذف الحساب</h3>
<ul>
<li>سيتم حذف جميع بياناتك الشخصية</li>
<li>سيتم إيقاف الاشتراك فوراً</li>
<li>لن تتمكن من استعادة الحساب</li>
<li>سيتم حذف قوائم المفضلة والمحتوى المحمل</li>
</ul>
<h3>كيفية طلب الحذف</h3>
<ol>
<li>انتقل إلى إعدادات الحساب</li>
<li>اختر "حذف الحساب"</li>
<li>اتبع التعليمات</li>
</ol>
<h3>مدة الحذف</h3>
<p>يتم حذف الحساب بشكل نهائي خلال 30 يوماً من الطلب.</p>',
            'en' => '<h2>Subscription and Account Deletion Policy</h2>
<h3>Account Deletion</h3>
<p>You can request permanent deletion of your account at any time.</p>
<h3>What Happens When You Delete Your Account</h3>
<ul>
<li>All your personal data will be deleted</li>
<li>Subscription will be stopped immediately</li>
<li>You will not be able to recover the account</li>
<li>Favorites and downloaded content will be deleted</li>
</ul>
<h3>How to Request Deletion</h3>
<ol>
<li>Go to Account Settings</li>
<li>Select "Delete Account"</li>
<li>Follow the instructions</li>
</ol>
<h3>Deletion Timeline</h3>
<p>Account is permanently deleted within 30 days of the request.</p>'
        ],
        'meta_title' => ['ar' => 'سياسة حذف الاشتراك - منصة ألوان', 'en' => 'Subscription Deletion - Alenwan Platform'],
        'meta_description' => ['ar' => 'تعرف على سياسة حذف الاشتراك والحساب في منصة ألوان', 'en' => 'Learn about the subscription and account deletion policy on Alenwan platform'],
        'icon' => 'trash',
        'order' => 12,
        'is_published' => true,
        'show_in_menu' => false,
        'show_in_footer' => true,
    ],
];

$createdCount = 0;
foreach ($pages as $pageData) {
    $page = Page::firstOrCreate(
        ['slug' => $pageData['slug']],
        $pageData
    );
    $createdCount++;
    echo "✅ تم إضافة صفحة: {$pageData['slug']}\n";
}

echo "\n🎉 تم إضافة {$createdCount} صفحة بنجاح!\n";
echo "✨ يمكنك الآن إدارة الصفحات من لوحة التحكم على http://localhost:8000/admin/pages\n";
