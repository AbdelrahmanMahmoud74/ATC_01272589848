# Backend Project - Event Booking System

## Overview

هذا المشروع هو الـ Backend الخاص بنظام حجز الفعاليات.  
تم تطويره باستخدام Laravel Framework و PHP.  
يوفر API لإدارة الفعاليات، المستخدمين، والحجوزات.

---

## Requirements

- PHP >= 8.0
- Composer
- MySQL أو أي قاعدة بيانات متوافقة
- Laravel 9.x أو أحدث

---

## Installation

1. استنساخ المستودع:

```bash
git clone https://github.com/AbdelrahmanMahmoud74/ATC_01272589848.git
cd ATC_01272589848
                                                                                                                                           2-تثبيت الاعتمادات
composer install
3-نسخ ملف الإعدادات .env:

cp .env.example .env
                                                                                                                                           4-تعديل إعدادات قاعدة البيانات في ملف .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api-tutorial
DB_USERNAME=root
DB_PASSWORD=
5-تنفيذ migrations
php artisan migrate
لتشغيل السيرفر المحلي:

php artisan serve
      http://127.0.0.1:8000




