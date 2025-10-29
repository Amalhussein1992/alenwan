# دليل الترجمة الصوتية الفورية - Audio Translation Feature Guide

## نظرة عامة | Overview

تم إضافة ميزة الترجمة الصوتية الفورية لجميع أنواع المحتوى في منصة Alenwan. هذه الميزة تتيح للمستخدمين الاستماع إلى المحتوى بلغات متعددة في الوقت الفعلي.

The instant audio translation feature has been added to all content types on the Alenwan platform. This feature allows users to listen to content in multiple languages in real-time.

---

## الحقول المضافة | Added Fields

تم إضافة ثلاثة حقول لكل نوع محتوى:

Three fields have been added to each content type:

### 1. `has_audio_translation` (Boolean)
- يحدد إذا كان المحتوى يحتوي على ترجمة صوتية
- Determines if the content has audio translation available
- القيمة الافتراضية: `false`
- Default value: `false`

### 2. `audio_languages` (JSON Array)
- قائمة باللغات المتاحة للترجمة الصوتية
- List of available languages for audio translation
- مثال | Example: `["ar", "en", "es", "fr", "de"]`
- يمكن أن تكون `null` إذا لم تكن الترجمة متاحة
- Can be `null` if translation is not available

### 3. `default_audio_language` (String)
- اللغة الافتراضية للترجمة الصوتية
- Default language for audio translation
- القيمة الافتراضية: `"ar"`
- Default value: `"ar"`

---

## أنواع المحتوى المدعومة | Supported Content Types

تم إضافة الترجمة الصوتية لجميع أنواع المحتوى التالية:

Audio translation has been added to all the following content types:

1. **Movies** (الأفلام)
2. **Series** (المسلسلات)
3. **Episodes** (الحلقات)
4. **Podcasts** (البودكاست)
5. **Sports** (الرياضة)
6. **Documentaries** (الوثائقيات)
7. **Cartoons** (الرسوم المتحركة)
8. **Live Streams** (البثوث المباشرة)

---

## استخدام الميزة | Usage

### في لوحة التحكم | In Admin Panel

عند إضافة أو تعديل أي محتوى، ستجد قسم "الترجمة الصوتية" يحتوي على:

When adding or editing any content, you will find an "Audio Translation" section containing:

1. **تفعيل الترجمة الصوتية** | Enable Audio Translation
   - مفتاح لتفعيل/تعطيل الميزة
   - Toggle to enable/disable the feature

2. **اللغات المتاحة** | Available Languages
   - قائمة متعددة الاختيار للغات المدعومة
   - Multi-select list for supported languages
   - اللغات المتاحة: العربية، الإنجليزية، الإسبانية، الفرنسية، الألمانية، الإيطالية، البرتغالية، الصينية، اليابانية، الكورية
   - Available languages: Arabic, English, Spanish, French, German, Italian, Portuguese, Chinese, Japanese, Korean

3. **اللغة الافتراضية** | Default Language
   - اختيار اللغة التي سيتم تشغيلها افتراضياً
   - Select the language to play by default

### في API

#### الحصول على محتوى مع معلومات الترجمة | Get Content with Translation Info

```json
{
  "id": 1,
  "title": "فيلم رائع",
  "has_audio_translation": true,
  "audio_languages": ["ar", "en", "es", "fr"],
  "default_audio_language": "ar"
}
```

#### تغيير لغة الترجمة الصوتية | Change Audio Translation Language

عند طلب المحتوى، يمكن إضافة parameter للغة:

When requesting content, you can add a language parameter:

```
GET /api/movies/1?audio_language=en
```

---

## أمثلة على الاستخدام | Usage Examples

### مثال 1: فيلم مع ترجمة صوتية

```php
$movie = Movie::create([
    'title' => ['ar' => 'الرسالة', 'en' => 'The Message'],
    'description' => ['ar' => 'فيلم تاريخي', 'en' => 'Historical film'],
    'has_audio_translation' => true,
    'audio_languages' => ['ar', 'en', 'fr', 'es'],
    'default_audio_language' => 'ar',
    // ... باقي الحقول
]);
```

### مثال 2: بودكاست بدون ترجمة صوتية

```php
$podcast = Podcast::create([
    'title' => 'بودكاست التقنية',
    'has_audio_translation' => false,
    'audio_languages' => null,
    'default_audio_language' => 'ar',
    // ... باقي الحقول
]);
```

### مثال 3: فحص توفر الترجمة الصوتية

```php
if ($movie->has_audio_translation) {
    $availableLanguages = $movie->audio_languages;
    $defaultLanguage = $movie->default_audio_language;

    // عرض خيارات اللغات للمستخدم
    foreach ($availableLanguages as $lang) {
        echo "اللغة المتاحة: $lang\n";
    }
}
```

---

## التكامل مع التطبيق | App Integration

### Flutter Example

```dart
class AudioTranslation {
  final bool hasAudioTranslation;
  final List<String>? audioLanguages;
  final String defaultAudioLanguage;

  AudioTranslation({
    required this.hasAudioTranslation,
    this.audioLanguages,
    this.defaultAudioLanguage = 'ar',
  });

  factory AudioTranslation.fromJson(Map<String, dynamic> json) {
    return AudioTranslation(
      hasAudioTranslation: json['has_audio_translation'] ?? false,
      audioLanguages: json['audio_languages'] != null
          ? List<String>.from(json['audio_languages'])
          : null,
      defaultAudioLanguage: json['default_audio_language'] ?? 'ar',
    );
  }
}
```

---

## رموز اللغات | Language Codes

| الكود | Code | اللغة | Language |
|-------|------|--------|----------|
| `ar`  | ar   | العربية | Arabic |
| `en`  | en   | الإنجليزية | English |
| `es`  | es   | الإسبانية | Spanish |
| `fr`  | fr   | الفرنسية | French |
| `de`  | de   | الألمانية | German |
| `it`  | it   | الإيطالية | Italian |
| `pt`  | pt   | البرتغالية | Portuguese |
| `zh`  | zh   | الصينية | Chinese |
| `ja`  | ja   | اليابانية | Japanese |
| `ko`  | ko   | الكورية | Korean |

---

## ملاحظات تقنية | Technical Notes

1. **Database Schema**: تم إضافة الحقول إلى جميع جداول المحتوى باستخدام migration واحد
2. **Model Updates**: تم تحديث جميع النماذج لدعم الحقول الجديدة مع `array` casting للغات
3. **Backward Compatibility**: الميزة اختيارية ولا تؤثر على المحتوى الحالي
4. **Default Values**: جميع الحقول لها قيم افتراضية مناسبة

---

## الخطوات التالية | Next Steps

- [ ] إضافة واجهة المستخدم في لوحة التحكم (Filament)
- [ ] تطوير API endpoints لتغيير اللغة
- [ ] دمج مع خدمات الترجمة الصوتية (Google Translate Speech API, Amazon Polly, etc.)
- [ ] إضافة تحليلات لمعرفة اللغات الأكثر استخداماً

---

## الدعم | Support

للمزيد من المعلومات أو الدعم، يرجى التواصل مع فريق التطوير.

For more information or support, please contact the development team.
