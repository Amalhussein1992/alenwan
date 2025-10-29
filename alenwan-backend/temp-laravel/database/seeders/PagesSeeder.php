<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'title' => [
                    'ar' => 'من نحن',
                    'en' => 'About Us'
                ],
                'slug' => 'about-us',
                'content' => [
                    'ar' => '<h2>مرحباً بكم في ألوان</h2>
                    <p>ألوان هي منصة ترفيهية رائدة توفر مجموعة واسعة من المحتوى المتنوع بما في ذلك الأفلام والمسلسلات والبث المباشر والمزيد.</p>
                    <h3>رؤيتنا</h3>
                    <p>نسعى لأن نكون المنصة الترفيهية الأولى في المنطقة، حيث نقدم محتوى عالي الجودة يلبي احتياجات جميع أفراد الأسرة.</p>
                    <h3>مهمتنا</h3>
                    <p>توفير تجربة مشاهدة استثنائية من خلال محتوى متنوع وجودة عالية وواجهة سهلة الاستخدام.</p>',
                    'en' => '<h2>Welcome to Alenwan</h2>
                    <p>Alenwan is a leading entertainment platform offering a wide range of diverse content including movies, series, live streaming, and more.</p>
                    <h3>Our Vision</h3>
                    <p>We strive to be the premier entertainment platform in the region, providing high-quality content that meets the needs of all family members.</p>
                    <h3>Our Mission</h3>
                    <p>To provide an exceptional viewing experience through diverse content, high quality, and an easy-to-use interface.</p>'
                ],
                'type' => 'about',
                'icon' => 'fas fa-info-circle',
                'order' => 1,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'من نحن - ألوان',
                    'en' => 'About Us - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'تعرف على ألوان، منصتك الترفيهية المفضلة للأفلام والمسلسلات والبث المباشر',
                    'en' => 'Learn about Alenwan, your favorite entertainment platform for movies, series, and live streaming'
                ]
            ],
            [
                'title' => [
                    'ar' => 'الشروط والأحكام',
                    'en' => 'Terms and Conditions'
                ],
                'slug' => 'terms-conditions',
                'content' => [
                    'ar' => '<h2>الشروط والأحكام</h2>
                    <p>مرحباً بك في ألوان. باستخدامك لخدماتنا، فإنك توافق على الالتزام بالشروط والأحكام التالية:</p>

                    <h3>1. استخدام الخدمة</h3>
                    <p>يجب أن يكون عمرك 18 عاماً على الأقل لاستخدام خدماتنا. يُمنع استخدام الخدمة لأي أغراض غير قانونية.</p>

                    <h3>2. الحساب</h3>
                    <p>أنت مسؤول عن الحفاظ على سرية معلومات حسابك وكلمة المرور الخاصة بك.</p>

                    <h3>3. الاشتراك والدفع</h3>
                    <p>يتم تجديد الاشتراكات تلقائياً ما لم يتم إلغاؤها قبل تاريخ التجديد.</p>

                    <h3>4. المحتوى</h3>
                    <p>جميع المحتويات المتاحة على المنصة محمية بحقوق الطبع والنشر.</p>

                    <h3>5. الإلغاء والاسترداد</h3>
                    <p>يمكنك إلغاء اشتراكك في أي وقت. راجع سياسة الاسترداد للحصول على مزيد من التفاصيل.</p>',
                    'en' => '<h2>Terms and Conditions</h2>
                    <p>Welcome to Alenwan. By using our services, you agree to comply with the following terms and conditions:</p>

                    <h3>1. Use of Service</h3>
                    <p>You must be at least 18 years old to use our services. Using the service for any illegal purposes is prohibited.</p>

                    <h3>2. Account</h3>
                    <p>You are responsible for maintaining the confidentiality of your account information and password.</p>

                    <h3>3. Subscription and Payment</h3>
                    <p>Subscriptions are automatically renewed unless canceled before the renewal date.</p>

                    <h3>4. Content</h3>
                    <p>All content available on the platform is protected by copyright.</p>

                    <h3>5. Cancellation and Refund</h3>
                    <p>You can cancel your subscription at any time. Please review our refund policy for more details.</p>'
                ],
                'type' => 'terms',
                'icon' => 'fas fa-file-contract',
                'order' => 2,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'الشروط والأحكام - ألوان',
                    'en' => 'Terms and Conditions - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'اقرأ الشروط والأحكام الخاصة باستخدام منصة ألوان',
                    'en' => 'Read the terms and conditions for using the Alenwan platform'
                ]
            ],
            [
                'title' => [
                    'ar' => 'سياسة الخصوصية',
                    'en' => 'Privacy Policy'
                ],
                'slug' => 'privacy-policy',
                'content' => [
                    'ar' => '<h2>سياسة الخصوصية</h2>
                    <p>في ألوان، نحن ملتزمون بحماية خصوصيتك وأمان معلوماتك الشخصية.</p>

                    <h3>1. جمع المعلومات</h3>
                    <p>نقوم بجمع المعلومات التي تقدمها لنا عند إنشاء حساب أو استخدام خدماتنا:</p>
                    <ul>
                        <li>المعلومات الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف)</li>
                        <li>معلومات الدفع</li>
                        <li>معلومات الاستخدام والتفضيلات</li>
                    </ul>

                    <h3>2. استخدام المعلومات</h3>
                    <p>نستخدم معلوماتك للأغراض التالية:</p>
                    <ul>
                        <li>تقديم وتحسين خدماتنا</li>
                        <li>معالجة المدفوعات</li>
                        <li>التواصل معك</li>
                        <li>تخصيص تجربتك</li>
                    </ul>

                    <h3>3. مشاركة المعلومات</h3>
                    <p>لا نبيع أو نشارك معلوماتك الشخصية مع أطراف ثالثة إلا في الحالات التالية:</p>
                    <ul>
                        <li>بموافقتك الصريحة</li>
                        <li>لمعالجة المدفوعات</li>
                        <li>للامتثال للقوانين</li>
                    </ul>

                    <h3>4. أمن المعلومات</h3>
                    <p>نستخدم إجراءات أمنية متقدمة لحماية معلوماتك الشخصية.</p>

                    <h3>5. حقوقك</h3>
                    <p>لديك الحق في الوصول إلى معلوماتك وتحديثها أو حذفها في أي وقت.</p>',
                    'en' => '<h2>Privacy Policy</h2>
                    <p>At Alenwan, we are committed to protecting your privacy and the security of your personal information.</p>

                    <h3>1. Information Collection</h3>
                    <p>We collect information you provide when creating an account or using our services:</p>
                    <ul>
                        <li>Personal information (name, email, phone number)</li>
                        <li>Payment information</li>
                        <li>Usage information and preferences</li>
                    </ul>

                    <h3>2. Use of Information</h3>
                    <p>We use your information for the following purposes:</p>
                    <ul>
                        <li>Providing and improving our services</li>
                        <li>Processing payments</li>
                        <li>Communicating with you</li>
                        <li>Personalizing your experience</li>
                    </ul>

                    <h3>3. Information Sharing</h3>
                    <p>We do not sell or share your personal information with third parties except in the following cases:</p>
                    <ul>
                        <li>With your explicit consent</li>
                        <li>To process payments</li>
                        <li>To comply with laws</li>
                    </ul>

                    <h3>4. Information Security</h3>
                    <p>We use advanced security measures to protect your personal information.</p>

                    <h3>5. Your Rights</h3>
                    <p>You have the right to access, update, or delete your information at any time.</p>'
                ],
                'type' => 'privacy',
                'icon' => 'fas fa-shield-alt',
                'order' => 3,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'سياسة الخصوصية - ألوان',
                    'en' => 'Privacy Policy - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'تعرف على كيفية حماية ألوان لخصوصيتك ومعلوماتك الشخصية',
                    'en' => 'Learn how Alenwan protects your privacy and personal information'
                ]
            ],
            [
                'title' => [
                    'ar' => 'سياسة الإلغاء',
                    'en' => 'Cancellation Policy'
                ],
                'slug' => 'cancellation-policy',
                'content' => [
                    'ar' => '<h2>سياسة الإلغاء</h2>
                    <p>يمكنك إلغاء اشتراكك في ألوان في أي وقت.</p>

                    <h3>كيفية الإلغاء</h3>
                    <ol>
                        <li>قم بتسجيل الدخول إلى حسابك</li>
                        <li>انتقل إلى إعدادات الحساب</li>
                        <li>اختر "إدارة الاشتراك"</li>
                        <li>اضغط على "إلغاء الاشتراك"</li>
                    </ol>

                    <h3>ماذا يحدث بعد الإلغاء؟</h3>
                    <p>بعد إلغاء اشتراكك:</p>
                    <ul>
                        <li>ستتمكن من الوصول إلى المحتوى حتى نهاية فترة الفوترة الحالية</li>
                        <li>لن يتم تجديد اشتراكك تلقائياً</li>
                        <li>ستتلقى تأكيداً عبر البريد الإلكتروني</li>
                    </ul>',
                    'en' => '<h2>Cancellation Policy</h2>
                    <p>You can cancel your Alenwan subscription at any time.</p>

                    <h3>How to Cancel</h3>
                    <ol>
                        <li>Log in to your account</li>
                        <li>Go to Account Settings</li>
                        <li>Select "Manage Subscription"</li>
                        <li>Click "Cancel Subscription"</li>
                    </ol>

                    <h3>What Happens After Cancellation?</h3>
                    <p>After canceling your subscription:</p>
                    <ul>
                        <li>You will have access to content until the end of your current billing period</li>
                        <li>Your subscription will not be automatically renewed</li>
                        <li>You will receive a confirmation email</li>
                    </ul>'
                ],
                'type' => 'cancellation',
                'icon' => 'fas fa-times-circle',
                'order' => 4,
                'is_published' => true,
                'show_in_menu' => false,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'سياسة الإلغاء - ألوان',
                    'en' => 'Cancellation Policy - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'تعرف على سياسة إلغاء الاشتراك في ألوان',
                    'en' => 'Learn about Alenwan subscription cancellation policy'
                ]
            ],
            [
                'title' => [
                    'ar' => 'اتصل بنا',
                    'en' => 'Contact Us'
                ],
                'slug' => 'contact-us',
                'content' => [
                    'ar' => '<h2>تواصل معنا</h2>
                    <p>نحن هنا للمساعدة! تواصل معنا عبر القنوات التالية:</p>

                    <h3>البريد الإلكتروني</h3>
                    <p>support@alenwan.com</p>

                    <h3>الهاتف</h3>
                    <p>+966 50 123 4567</p>

                    <h3>ساعات العمل</h3>
                    <p>الأحد - الخميس: 9:00 صباحاً - 6:00 مساءً</p>

                    <h3>وسائل التواصل الاجتماعي</h3>
                    <ul>
                        <li>تويتر: @alenwan</li>
                        <li>إنستغرام: @alenwan</li>
                        <li>فيسبوك: /alenwan</li>
                    </ul>',
                    'en' => '<h2>Contact Us</h2>
                    <p>We are here to help! Contact us through the following channels:</p>

                    <h3>Email</h3>
                    <p>support@alenwan.com</p>

                    <h3>Phone</h3>
                    <p>+966 50 123 4567</p>

                    <h3>Business Hours</h3>
                    <p>Sunday - Thursday: 9:00 AM - 6:00 PM</p>

                    <h3>Social Media</h3>
                    <ul>
                        <li>Twitter: @alenwan</li>
                        <li>Instagram: @alenwan</li>
                        <li>Facebook: /alenwan</li>
                    </ul>'
                ],
                'type' => 'contact',
                'icon' => 'fas fa-envelope',
                'order' => 5,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'اتصل بنا - ألوان',
                    'en' => 'Contact Us - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'تواصل مع فريق دعم ألوان',
                    'en' => 'Contact Alenwan support team'
                ]
            ],
            [
                'title' => [
                    'ar' => 'الميزات',
                    'en' => 'Features'
                ],
                'slug' => 'features',
                'content' => [
                    'ar' => '<h2>ميزات ألوان</h2>
                    <p>استمتع بأفضل تجربة مشاهدة مع منصة ألوان - منصة البث الأولى للمحتوى العربي والعالمي</p>

                    <h3>🎬 محتوى متنوع وحصري</h3>
                    <ul>
                        <li>آلاف الأفلام والمسلسلات العربية والعالمية</li>
                        <li>محتوى حصري من إنتاج ألوان</li>
                        <li>أفلام وثائقية ورسوم متحركة للأطفال</li>
                        <li>برامج رياضية وبث مباشر للمباريات</li>
                    </ul>

                    <h3>📱 تجربة مشاهدة مرنة</h3>
                    <ul>
                        <li>شاهد على أي جهاز - هاتف، تابلت، تلفاز ذكي</li>
                        <li>تنزيل المحتوى للمشاهدة بدون إنترنت</li>
                        <li>مشاهدة على 4 أجهزة في نفس الوقت</li>
                        <li>استئناف المشاهدة من حيث توقفت</li>
                    </ul>

                    <h3>🎯 جودة عالية</h3>
                    <ul>
                        <li>دقة عرض تصل إلى 4K Ultra HD</li>
                        <li>صوت محيطي Dolby Atmos</li>
                        <li>جودة تكيفية حسب سرعة الإنترنت</li>
                    </ul>

                    <h3>👨‍👩‍👧‍👦 مناسب للعائلة</h3>
                    <ul>
                        <li>ملفات تعريف متعددة لأفراد الأسرة</li>
                        <li>رقابة أبوية كاملة</li>
                        <li>محتوى مناسب لجميع الأعمار</li>
                    </ul>',
                    'en' => '<h2>Alenwan Features</h2>
                    <p>Enjoy the best viewing experience with Alenwan - the premier platform for Arabic and international content</p>

                    <h3>🎬 Diverse and Exclusive Content</h3>
                    <ul>
                        <li>Thousands of Arabic and international movies and series</li>
                        <li>Exclusive Alenwan original content</li>
                        <li>Documentaries and children\'s cartoons</li>
                        <li>Sports programs and live match streaming</li>
                    </ul>

                    <h3>📱 Flexible Viewing Experience</h3>
                    <ul>
                        <li>Watch on any device - phone, tablet, smart TV</li>
                        <li>Download content for offline viewing</li>
                        <li>Watch on 4 devices simultaneously</li>
                        <li>Resume watching from where you left off</li>
                    </ul>

                    <h3>🎯 High Quality</h3>
                    <ul>
                        <li>Up to 4K Ultra HD resolution</li>
                        <li>Dolby Atmos surround sound</li>
                        <li>Adaptive quality based on internet speed</li>
                    </ul>

                    <h3>👨‍👩‍👧‍👦 Family Friendly</h3>
                    <ul>
                        <li>Multiple profiles for family members</li>
                        <li>Complete parental controls</li>
                        <li>Content suitable for all ages</li>
                    </ul>'
                ],
                'type' => 'features',
                'icon' => 'fas fa-star',
                'order' => 6,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'الميزات - ألوان',
                    'en' => 'Features - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'اكتشف ميزات منصة ألوان للبث المباشر',
                    'en' => 'Discover Alenwan streaming platform features'
                ]
            ],
            [
                'title' => [
                    'ar' => 'الأسئلة الشائعة',
                    'en' => 'FAQ'
                ],
                'slug' => 'faq',
                'content' => [
                    'ar' => '<h2>الأسئلة الشائعة</h2>

                    <h3>ما هي ألوان؟</h3>
                    <p>ألوان هي منصة بث رقمية توفر مجموعة واسعة من الأفلام والمسلسلات والمحتوى الترفيهي بجودة عالية.</p>

                    <h3>كم تكلفة الاشتراك؟</h3>
                    <p>نوفر عدة خطط اشتراك تبدأ من 29 ريال شهرياً. يمكنك الاطلاع على جميع الخطط في صفحة الأسعار.</p>

                    <h3>هل يمكنني إلغاء الاشتراك في أي وقت؟</h3>
                    <p>نعم، يمكنك إلغاء اشتراكك في أي وقت بدون أي رسوم إضافية.</p>

                    <h3>على كم جهاز يمكنني المشاهدة؟</h3>
                    <p>يعتمد ذلك على خطة اشتراكك. الخطة الأساسية تتيح جهازاً واحداً، والخطة العائلية تتيح حتى 4 أجهزة في نفس الوقت.</p>

                    <h3>هل يمكنني تنزيل المحتوى؟</h3>
                    <p>نعم، يمكنك تنزيل المحتوى للمشاهدة بدون إنترنت على تطبيق الهاتف.</p>

                    <h3>ما هي طرق الدفع المتاحة؟</h3>
                    <p>نقبل جميع بطاقات الائتمان الرئيسية، Apple Pay، وSTC Pay.</p>

                    <h3>هل المحتوى متاح بترجمة؟</h3>
                    <p>نعم، معظم المحتوى متوفر بترجمة عربية وإنجليزية.</p>

                    <h3>كيف أتواصل مع الدعم الفني؟</h3>
                    <p>يمكنك التواصل معنا عبر البريد الإلكتروني: support@alenwan.com أو عبر صفحة اتصل بنا.</p>',
                    'en' => '<h2>Frequently Asked Questions</h2>

                    <h3>What is Alenwan?</h3>
                    <p>Alenwan is a digital streaming platform offering a wide range of movies, series, and entertainment content in high quality.</p>

                    <h3>How much does a subscription cost?</h3>
                    <p>We offer several subscription plans starting from 29 SAR per month. You can view all plans on the pricing page.</p>

                    <h3>Can I cancel my subscription anytime?</h3>
                    <p>Yes, you can cancel your subscription at any time without any additional fees.</p>

                    <h3>On how many devices can I watch?</h3>
                    <p>It depends on your subscription plan. The basic plan allows one device, while the family plan allows up to 4 devices simultaneously.</p>

                    <h3>Can I download content?</h3>
                    <p>Yes, you can download content for offline viewing on the mobile app.</p>

                    <h3>What payment methods are available?</h3>
                    <p>We accept all major credit cards, Apple Pay, and STC Pay.</p>

                    <h3>Is content available with subtitles?</h3>
                    <p>Yes, most content is available with Arabic and English subtitles.</p>

                    <h3>How do I contact technical support?</h3>
                    <p>You can contact us via email: support@alenwan.com or through the Contact Us page.</p>'
                ],
                'type' => 'faq',
                'icon' => 'fas fa-question-circle',
                'order' => 7,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'الأسئلة الشائعة - ألوان',
                    'en' => 'FAQ - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'إجابات على الأسئلة الشائعة حول منصة ألوان',
                    'en' => 'Answers to frequently asked questions about Alenwan'
                ]
            ],
            [
                'title' => [
                    'ar' => 'الدعم الفني',
                    'en' => 'Technical Support'
                ],
                'slug' => 'support',
                'content' => [
                    'ar' => '<h2>الدعم الفني</h2>
                    <p>فريق الدعم الفني لدينا متواجد دائماً لمساعدتك في أي وقت!</p>

                    <h3>📧 البريد الإلكتروني</h3>
                    <p><strong>support@alenwan.com</strong></p>
                    <p>وقت الاستجابة: خلال 24 ساعة</p>

                    <h3>📱 الهاتف</h3>
                    <p><strong>+966 50 123 4567</strong></p>
                    <p>متاح من الأحد إلى الخميس (9 صباحاً - 6 مساءً)</p>

                    <h3>💬 الدردشة المباشرة</h3>
                    <p>متاحة في تطبيق الهاتف والموقع الإلكتروني</p>
                    <p>متاح 24/7</p>

                    <h3>🌐 وسائل التواصل الاجتماعي</h3>
                    <ul>
                        <li><strong>تويتر:</strong> @alenwan_support</li>
                        <li><strong>إنستغرام:</strong> @alenwan</li>
                        <li><strong>فيسبوك:</strong> /alenwan</li>
                    </ul>

                    <h3>❓ مركز المساعدة</h3>
                    <p>قم بزيارة مركز المساعدة للحصول على إجابات فورية على الأسئلة الشائعة ومقالات مفيدة حول استخدام المنصة.</p>

                    <h3>🔧 المشاكل الشائعة وحلولها</h3>

                    <h4>مشكلة في تسجيل الدخول</h4>
                    <p>1. تأكد من صحة البريد الإلكتروني وكلمة المرور<br>
                    2. جرب إعادة تعيين كلمة المرور<br>
                    3. تحقق من اتصالك بالإنترنت</p>

                    <h4>مشكلة في جودة الفيديو</h4>
                    <p>1. تحقق من سرعة الإنترنت لديك<br>
                    2. قم بتغيير جودة الفيديو من الإعدادات<br>
                    3. أعد تشغيل التطبيق</p>

                    <h4>مشكلة في الدفع</h4>
                    <p>1. تحقق من صلاحية البطاقة<br>
                    2. تأكد من وجود رصيد كافٍ<br>
                    3. جرب طريقة دفع أخرى<br>
                    4. تواصل مع البنك الخاص بك</p>',
                    'en' => '<h2>Technical Support</h2>
                    <p>Our technical support team is always here to help you anytime!</p>

                    <h3>📧 Email</h3>
                    <p><strong>support@alenwan.com</strong></p>
                    <p>Response time: Within 24 hours</p>

                    <h3>📱 Phone</h3>
                    <p><strong>+966 50 123 4567</strong></p>
                    <p>Available Sunday to Thursday (9 AM - 6 PM)</p>

                    <h3>💬 Live Chat</h3>
                    <p>Available in mobile app and website</p>
                    <p>Available 24/7</p>

                    <h3>🌐 Social Media</h3>
                    <ul>
                        <li><strong>Twitter:</strong> @alenwan_support</li>
                        <li><strong>Instagram:</strong> @alenwan</li>
                        <li><strong>Facebook:</strong> /alenwan</li>
                    </ul>

                    <h3>❓ Help Center</h3>
                    <p>Visit the Help Center for instant answers to frequently asked questions and helpful articles about using the platform.</p>

                    <h3>🔧 Common Issues and Solutions</h3>

                    <h4>Login Problem</h4>
                    <p>1. Check your email and password<br>
                    2. Try resetting your password<br>
                    3. Check your internet connection</p>

                    <h4>Video Quality Issue</h4>
                    <p>1. Check your internet speed<br>
                    2. Change video quality from settings<br>
                    3. Restart the app</p>

                    <h4>Payment Problem</h4>
                    <p>1. Check card validity<br>
                    2. Ensure sufficient balance<br>
                    3. Try another payment method<br>
                    4. Contact your bank</p>'
                ],
                'type' => 'support',
                'icon' => 'fas fa-headset',
                'order' => 8,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'الدعم الفني - ألوان',
                    'en' => 'Technical Support - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'احصل على المساعدة من فريق الدعم الفني لألوان',
                    'en' => 'Get help from Alenwan technical support team'
                ]
            ],
            [
                'title' => [
                    'ar' => 'الأسعار',
                    'en' => 'Pricing'
                ],
                'slug' => 'pricing',
                'content' => [
                    'ar' => '<h2>خطط الاشتراك</h2>
                    <p>اختر الخطة المناسبة لك - يمكنك الترقية أو الإلغاء في أي وقت</p>

                    <h3>📱 الخطة الأساسية - 29 ريال/شهر</h3>
                    <ul>
                        <li>مشاهدة على جهاز واحد</li>
                        <li>جودة SD</li>
                        <li>مكتبة محتوى كاملة</li>
                        <li>بدون إعلانات</li>
                    </ul>

                    <h3>💎 الخطة المتقدمة - 49 ريال/شهر</h3>
                    <ul>
                        <li>مشاهدة على جهازين في نفس الوقت</li>
                        <li>جودة Full HD</li>
                        <li>مكتبة محتوى كاملة</li>
                        <li>تنزيل على جهازين</li>
                        <li>بدون إعلانات</li>
                    </ul>

                    <h3>👨‍👩‍👧‍👦 الخطة العائلية - 79 ريال/شهر</h3>
                    <ul>
                        <li>مشاهدة على 4 أجهزة في نفس الوقت</li>
                        <li>جودة 4K Ultra HD</li>
                        <li>مكتبة محتوى كاملة</li>
                        <li>تنزيل على 4 أجهزة</li>
                        <li>5 ملفات تعريف</li>
                        <li>رقابة أبوية</li>
                        <li>بدون إعلانات</li>
                    </ul>

                    <p><strong>✨ جميع الخطط تشمل:</strong></p>
                    <ul>
                        <li>فترة تجريبية مجانية لمدة 7 أيام</li>
                        <li>إلغاء في أي وقت</li>
                        <li>محتوى حصري</li>
                        <li>دعم فني 24/7</li>
                    </ul>',
                    'en' => '<h2>Subscription Plans</h2>
                    <p>Choose the plan that suits you - upgrade or cancel anytime</p>

                    <h3>📱 Basic Plan - 29 SAR/month</h3>
                    <ul>
                        <li>Watch on 1 device</li>
                        <li>SD quality</li>
                        <li>Full content library</li>
                        <li>No ads</li>
                    </ul>

                    <h3>💎 Premium Plan - 49 SAR/month</h3>
                    <ul>
                        <li>Watch on 2 devices simultaneously</li>
                        <li>Full HD quality</li>
                        <li>Full content library</li>
                        <li>Download on 2 devices</li>
                        <li>No ads</li>
                    </ul>

                    <h3>👨‍👩‍👧‍👦 Family Plan - 79 SAR/month</h3>
                    <ul>
                        <li>Watch on 4 devices simultaneously</li>
                        <li>4K Ultra HD quality</li>
                        <li>Full content library</li>
                        <li>Download on 4 devices</li>
                        <li>5 profiles</li>
                        <li>Parental controls</li>
                        <li>No ads</li>
                    </ul>

                    <p><strong>✨ All plans include:</strong></p>
                    <ul>
                        <li>7-day free trial</li>
                        <li>Cancel anytime</li>
                        <li>Exclusive content</li>
                        <li>24/7 technical support</li>
                    </ul>'
                ],
                'type' => 'pricing',
                'icon' => 'fas fa-tag',
                'order' => 9,
                'is_published' => true,
                'show_in_menu' => true,
                'show_in_footer' => true,
                'meta_title' => [
                    'ar' => 'الأسعار - ألوان',
                    'en' => 'Pricing - Alenwan'
                ],
                'meta_description' => [
                    'ar' => 'اطلع على خطط اشتراك ألوان وأسعارها',
                    'en' => 'View Alenwan subscription plans and pricing'
                ]
            ]
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        $this->command->info('Pages seeded successfully!');
    }
}
