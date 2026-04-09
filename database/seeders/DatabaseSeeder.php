<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Courses
        $courses = [
            [
                'name' => 'Laravel Framework Toàn Tập',
                'slug' => 'laravel-framework-toan-tap',
                'price' => 1200000,
                'description' => 'Học sâu về Laravel từ cơ bản đến nâng cao, xây dựng dự án thực tế.',
                'status' => 'published',
            ],
            [
                'name' => 'Lập trình Web với NodeJS',
                'slug' => 'lap-trinh-web-voi-nodejs',
                'price' => 1500000,
                'description' => 'Tìm hiểu NodeJS và ExpressJS chuyên sâu.',
                'status' => 'published',
            ],
            [
                'name' => 'Thiết kế UI/UX cơ bản',
                'slug' => 'thiet-ke-uiux-co-ban',
                'price' => 800000,
                'description' => 'Làm quen với Figma và các nguyên lý thiết kế.',
                'status' => 'draft',
            ],
            [
                'name' => 'ReactJS Mastery',
                'slug' => 'reactjs-mastery',
                'price' => 1800000,
                'description' => 'Làm chủ framework React và hệ sinh thái Hooks/Redux.',
                'status' => 'published',
            ],
            [
                'name' => 'Docker for DevOps',
                'slug' => 'docker-for-devops',
                'price' => 2000000,
                'description' => 'Triển khai và vận hành hệ thống container hóa chuyên nghiệp.',
                'status' => 'published',
            ],
        ];

        foreach ($courses as $c) {
            $course = Course::create($c);

            // 2. Create Lessons for each course
            for ($i = 1; $i <= 5; $i++) {
                Lesson::create([
                    'course_id' => $course->id,
                    'title' => 'Bài học số ' . $i . ': Nội dung chuyên sâu',
                    'content' => 'Nội dung hướng dẫn chi tiết cho bài học số ' . $i . ' của khóa ' . $course->name,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'order' => $i,
                ]);
            }
        }

        // 3. Create Students
        $students = [
            ['name' => 'Nguyễn Văn Anh', 'email' => 'anh.nv@gmail.com'],
            ['name' => 'Trần Thị Bình', 'email' => 'binh.tt@yahoo.com'],
            ['name' => 'Lê Quang Cường', 'email' => 'cuong.lq@hotmail.com'],
            ['name' => 'Phạm Minh Dũng', 'email' => 'dung.pm@gmail.com'],
            ['name' => 'Hoàng Mỹ Linh', 'email' => 'linh.hm@gmail.com'],
        ];

        foreach ($students as $s) {
            $student = Student::create($s);

            // 4. Enroll students into random courses (1-2 courses per student)
            $randomCourses = Course::inRandomOrder()->take(rand(1, 2))->get();
            foreach ($randomCourses as $randomCourse) {
                Enrollment::create([
                    'course_id' => $randomCourse->id,
                    'student_id' => $student->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
