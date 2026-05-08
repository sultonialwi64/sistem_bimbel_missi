# Planning Document - Sistem Manajemen Bimbel (Tutoring Management System)

## 📋 Overview

Sistem web-based untuk mengelola bisnis bimbel door-to-door dengan fitur tracking jadwal, absensi berbasis lokasi, manajemen gaji tutor, dan dashboard progress untuk orang tua murid.

---

## 🎯 User Roles

| Role | Deskripsi | Akses Utama |
|------|-----------|-------------|
| **Admin** | Owner/Staff bimbel | Full access - manage semua data, laporan, pembayaran |
| **Tutor** | Pengajar | Jadwal, absensi, input progress murid, lihat gaji |
| **Client** | Orang tua murid | Lihat jadwal, progress anak, pembayaran |

---

## 🏗️ System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        Laravel Web App                          │
│                    (Laravel 10/11 + Breeze)                     │
├─────────────────────────────────────────────────────────────────┤
│  Frontend: Blade + TailwindCSS / Livewire / Inertia (optional)  │
│  Backend:  Laravel Controllers, Services, Repositories          │
│  Database: MySQL / PostgreSQL                                   │
│  Auth:     Laravel Breeze (Session-based)                       │
│  Maps:     Google Maps API / Leaflet (OpenStreetMap)            │
│  Storage:  Local / AWS S3 (untuk dokumen & foto)                │
└─────────────────────────────────────────────────────────────────┘
```

---

## 📊 Database Schema Design

### 1. **users** (extended)
```
- id
- name
- email
- password
- role (enum: admin, tutor, client)
- phone
- avatar
- created_at
- updated_at
```

### 2. **tutors** (tutor profiles)
```
- id
- user_id (FK)
- specialization (array: Matematika, Fisika, Bahasa, dll)
- hourly_rate / session_rate
- rating_avg
- total_sessions
- status (active, inactive, suspended)
- bank_account
- bank_name
- created_at
- updated_at
```

### 3. **clients** (parent profiles)
```
- id
- user_id (FK)
- address
- address_lat
- address_lng
- emergency_contact
- created_at
- updated_at
```

### 4. **students**
```
- id
- client_id (FK)
- name
- birth_date
- school_name
- grade_level
- photo
- created_at
- updated_at
```

### 5. **subjects**
```
- id
- name (Matematika, Fisika, Bahasa Inggris, dll)
- description
- level (SD, SMP, SMA)
- created_at
- updated_at
```

### 6. **schedules**
```
- id
- student_id (FK)
- tutor_id (FK)
- subject_id (FK)
- date
- start_time
- end_time
- status (scheduled, completed, cancelled, rescheduled)
- notes
- created_at
- updated_at
```

### 7. **attendances**
```
- id
- schedule_id (FK)
- tutor_id (FK)
- check_in_time
- check_out_time
- check_in_lat
- check_in_lng
- check_out_lat
- check_out_lng
- location_verified (boolean)
- distance_from_target (meters)
- photo_proof (nullable - foto di lokasi)
- notes
- status (present, late, absent, pending)
- created_at
- updated_at
```

### 8. **session_reports**
```
- id
- schedule_id (FK)
- tutor_id (FK)
- student_id (FK)
- material_covered
- student_understanding (1-5)
- homework_assigned
- notes_for_parent
- tutor_rating_by_student (1-5, optional)
- created_at
- updated_at
```

### 9. **salaries**
```
- id
- tutor_id (FK)
- period_start
- period_end
- total_sessions
- rate_per_session
- bonus
- deduction
- total_amount
- status (pending, paid)
- payment_date
- payment_proof
- created_at
- updated_at
```

### 10. **payments** (from clients)
```
- id
- client_id (FK)
- student_id (FK)
- amount
- payment_date
- due_date
- status (pending, paid, overdue)
- payment_method
- payment_proof
- notes
- created_at
- updated_at
```

### 11. **student_progress**
```
- id
- student_id (FK)
- subject_id (FK)
- tutor_id (FK)
- assessment_date
- skill_areas (JSON: {algebra: 75, geometry: 80, ...})
- overall_score
- improvement_notes
- created_at
- updated_at
```

### 12. **notifications**
```
- id
- user_id (FK)
- type
- title
- message
- is_read
- created_at
```

### 13. **quality_assessments** (untuk tracking kualitas tutor)
```
- id
- tutor_id (FK)
- student_id (FK)
- schedule_id (FK)
- criteria_scores (JSON: {punctuality: 5, clarity: 4, engagement: 5, ...})
- overall_score
- feedback_text
- assessed_by (client/admin)
- created_at
```

---

## 🎯 Core Features

### 1. **Authentication & Authorization**
- Login/Register dengan Laravel Breeze
- Role-based middleware (admin, tutor, client)
- Password reset
- Email verification (optional)

### 2. **Admin Dashboard**
- Overview statistics (total students, tutors, sessions, revenue)
- Manage tutors (CRUD, approval, suspend)
- Manage clients & students
- Schedule management (view all, assign tutors)
- Attendance monitoring (real-time map view)
- Salary calculation & payment processing
- Payment tracking from clients
- Reports & analytics
- Quality assessment dashboard

### 3. **Tutor Features**
- View personal schedule
- Check-in/Check-out with GPS verification
- Upload photo proof at student's location
- Submit session reports
- View student progress history
- View salary history & current balance
- Update availability
- Receive notifications

### 4. **Client (Parent) Features**
- View child's schedule
- View session reports after each meeting
- Dashboard progress (charts, graphs)
- Payment history & billing
- Rate tutor after sessions
- Submit feedback/complaints
- Request reschedule
- Receive notifications

### 5. **Location-Based Attendance**
- GPS coordinate validation
- Geofencing (radius check ~50-100m dari alamat murid)
- Check-in photo requirement
- Anti-spoofing measures (mock location detection)
- Late arrival tracking

### 6. **Quality Control System** ⭐ (Solves teaching quality inconsistency)
- Standardized assessment criteria per session
- Client ratings after each session
- Admin periodic reviews
- Tutor performance dashboard
- Automatic flagging for low-rated tutors
- Training recommendations based on weak areas
- Leaderboard for motivation

### 7. **Salary Management**
- Automatic calculation based on completed sessions
- Configurable rate per session/subject/level
- Bonus system (performance-based)
- Deduction tracking (cancellations, complaints)
- Payment history
- Export to payroll system

### 8. **Progress Tracking**
- Per-subject skill breakdown
- Visual charts (progress over time)
- Comparison with previous periods
- Tutor notes & recommendations
- Homework tracking
- Assessment scores

### 9. **Notifications**
- Email notifications (Laravel Mail)
- In-app notifications
- WhatsApp integration (optional via Twilio/Fonnte)
- Reminder for upcoming sessions
- Payment reminders
- Schedule change alerts

---

## 🔍 Quality Control Enhancement (Addressing Teaching Quality Issues)

### Problem: Kualitas pengajaran antar tutor tidak konsisten

### Solutions Implemented:

1. **Standardized Session Report Template**
   - Mandatory fields untuk setiap sesi
   - Checklist materi yang harus dicover
   - Minimum understanding score threshold

2. **Multi-Source Assessment**
   - Client rating setelah setiap sesi
   - Student feedback (age-appropriate)
   - Admin periodic observation
   - Peer review (optional)

3. **Performance Metrics Dashboard**
   ```
   - Average rating per tutor
   - Student improvement rate
   - Session completion rate
   - Punctuality score
   - Parent complaint rate
   - Student retention rate
   ```

4. **Tier System untuk Tutor**
   ```
   - Junior Tutor (rating < 4.0)
   - Regular Tutor (rating 4.0 - 4.5)
   - Senior Tutor (rating 4.5 - 4.8)
   - Master Tutor (rating > 4.8)
   ```
   - Different rates per tier
   - Clear promotion criteria

5. **Continuous Improvement**
   - Monthly training sessions
   - Best practice sharing
   - Mentoring program (Senior → Junior)
   - Quality audit random sampling

6. **Automatic Alerts**
   - Rating drops below threshold
   - Multiple complaints in short period
   - High cancellation rate
   - Low student improvement

---

## 📁 Project Structure

```
sistem_bimbel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── TutorController.php
│   │   │   │   ├── ClientController.php
│   │   │   │   ├── ScheduleController.php
│   │   │   │   ├── SalaryController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── Tutor/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ScheduleController.php
│   │   │   │   ├── AttendanceController.php
│   │   │   │   └── ReportController.php
│   │   │   ├── Client/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── ScheduleController.php
│   │   │   │   └── ProgressController.php
│   │   │   └── Auth/
│   │   ├── Middleware/
│   │   │   ├── RoleMiddleware.php
│   │   │   └── CheckLocationMiddleware.php
│   │   └── Requests/
│   │       ├── Admin/
│   │       ├── Tutor/
│   │       └── Client/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Tutor.php
│   │   ├── Client.php
│   │   ├── Student.php
│   │   ├── Subject.php
│   │   ├── Schedule.php
│   │   ├── Attendance.php
│   │   ├── SessionReport.php
│   │   ├── Salary.php
│   │   ├── Payment.php
│   │   ├── StudentProgress.php
│   │   └── QualityAssessment.php
│   ├── Services/
│   │   ├── LocationService.php
│   │   ├── SalaryCalculationService.php
│   │   ├── QualityAssessmentService.php
│   │   └── NotificationService.php
│   └── Repositories/
│       ├── TutorRepository.php
│       ├── ScheduleRepository.php
│       └── ReportRepository.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── tutor/
│   │   ├── client/
│   │   └── components/
│   └── js/
├── routes/
│   ├── web.php
│   └── api.php (optional for mobile app later)
├── public/
├── tests/
└── README.md
```

---

## 🗓️ Development Phases

### Phase 1: Foundation (Week 1-2)
- [ ] Laravel installation & Breeze setup
- [ ] Database migrations
- [ ] Authentication with role management
- [ ] Basic CRUD for Users, Tutors, Clients, Students
- [ ] Basic dashboard per role

### Phase 2: Core Features (Week 3-4)
- [ ] Schedule management
- [ ] Location-based attendance system
- [ ] GPS integration (Google Maps/Leaflet)
- [ ] Session reports
- [ ] Basic notifications

### Phase 3: Financial & Quality (Week 5-6)
- [ ] Salary calculation system
- [ ] Payment management
- [ ] Quality assessment system
- [ ] Rating & review system
- [ ] Performance dashboards

### Phase 4: Client Features (Week 7)
- [ ] Parent dashboard
- [ ] Student progress tracking
- [ ] Visual charts & reports
- [ ] Payment portal
- [ ] Feedback system

### Phase 5: Polish & Testing (Week 8)
- [ ] UI/UX improvements
- [ ] Testing (Unit, Feature, Integration)
- [ ] Security audit
- [ ] Performance optimization
- [ ] Documentation
- [ ] Deployment preparation

---

## 🔒 Security Considerations

1. **Location Spoofing Prevention**
   - Mock location detection
   - IP address validation
   - Device fingerprinting
   - Photo timestamp verification

2. **Data Privacy**
   - Encrypt sensitive data (addresses, phone numbers)
   - GDPR compliance considerations
   - Secure file uploads
   - SQL injection prevention (Eloquent ORM)

3. **Access Control**
   - Role-based middleware
   - Policy classes for authorization
   - API rate limiting
   - CSRF protection

4. **Audit Trail**
   - Log all critical actions
   - Track data changes
   - Login attempt monitoring

---

## 🚀 Future Enhancements

1. **Mobile App** (React Native/Flutter)
   - Better GPS accuracy
   - Push notifications
   - Offline mode

2. **Video Call Integration**
   - Hybrid (online/offline) sessions
   - Recording for quality review

3. **AI-Powered Insights**
   - Predict student performance
   - Optimal tutor-student matching
   - Automatic schedule optimization

4. **E-Learning Content**
   - Practice exercises
   - Video tutorials
   - Interactive quizzes

5. **Payment Gateway Integration**
   - Midtrans/Xendit for Indonesia
   - Auto-billing
   - Installment plans

6. **WhatsApp Bot**
   - Automated reminders
   - Quick support
   - Schedule changes

---

## 📝 Notes & Considerations

### Technical Decisions Needed:
1. **Frontend**: Pure Blade vs Livewire vs Inertia.js?
2. **Maps**: Google Maps (paid) vs Leaflet/OpenStreetMap (free)?
3. **Charts**: Chart.js vs ApexCharts vs Laravel Charts?
4. **Deployment**: Shared hosting vs VPS vs Cloud (AWS/GCP)?

### Business Logic Questions:
1. How to handle cancelled sessions (who bears the cost)?
2. What's the grace period for late arrivals?
3. How to calculate salary for group sessions?
4. What's the policy for tutor changes/replacements?
5. How to handle holiday/special day pricing?

### Scalability Considerations:
1. Queue system for notifications (Laravel Queue)
2. Caching for frequently accessed data
3. Database indexing strategy
4. CDN for static assets
5. Horizontal scaling preparation

---

## ✅ Success Metrics

- **System Uptime**: >99%
- **Location Accuracy**: <50m tolerance
- **Response Time**: <2s page load
- **User Satisfaction**: >4.5/5 rating
- **Data Accuracy**: 100% salary calculation accuracy
- **Security**: Zero data breaches

---

## 📞 Stakeholder Communication

Regular check-ins needed with:
1. **Owner** - Business requirements, pricing, policies
2. **Tutors** - UX feedback, pain points
3. **Parents** - Dashboard usability, report clarity
4. **Admin Staff** - Daily operations, reporting needs

---

*Last Updated: March 16, 2026*
