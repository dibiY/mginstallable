<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title' => 'تنصيب Laravel',
    'next' => 'متابعة',

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'title'   => 'تنصيب Laravel',
        'message' => 'أهلا بك في صفحة تنصيب Laravel',
    ],

            /*
     *
     * license page translations.
     *
     */
    'checkLicense' => [
        'templateTitle' => 'Step 3 | License',
        'title' => 'License',
        'next'    => 'Configure Environment',
        'form' => [
            'app_name_placeholder'=>'App Name',
            'app_key_placeholder'=>'License Key',
            'app_name_label'=>'App Name',
            'app_key'=>'License Key',
            'domainName_required' => 'Name of app is required.',
            'key_required' => 'Key of app is required.',
            'buttons'=> [
                'check'=>'Verification License Key'
            ]
        ]
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'title' => 'المتطلبات',
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'title' => 'تراخيص المجلدات',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'title' => 'الإعدادات',
        'save' => 'حفظ ملف .env',
        'success' => 'تم حفظ الإعدادات بنجاح',
        'errors' => 'حدث خطأ أثناء إنشاء ملف .env. رجاءا قم بإنشاءه يدويا',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'النهاية',
        'finished' => 'تم تنصيب البرنامج بنجاح...',
        'exit' => 'إضغط هنا للخروج',
    ],
];
