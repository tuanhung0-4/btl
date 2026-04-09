<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $course = $this->route('course');
        $id = is_object($course) ? $course->id : $course;

        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug,' . $id,
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên khóa học không được để trống.',
            'price.required' => 'Giá khóa học không được để trống.',
            'price.numeric' => 'Giá khóa học phải là số.',
            'price.min' => 'Giá khóa học phải lớn hơn 0.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'image.image' => 'File phải là hình ảnh.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
        ];
    }
}
