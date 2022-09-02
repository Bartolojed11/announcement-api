<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidEndDate;
use Illuminate\Support\Facades\Log;

class AnnouncementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $announcement_id = $this->announcement->id ?? 0;
        return [
            'title' => 'required|unique:announcements,title,' . $announcement_id . ',id',
            'announcement_content' => 'required',
            'startDate' => 'required|date_format:Y-m-d H:i:s|after_or_equal:today',
            'endDate' => 'nullable|date_format:Y-m-d H:i:s|after_or_equal:' . date('Y-m-d H:i:s')
        ];
    }

    public function prepareData() {

        return [
            'title' => $this->title,
            'announcement_content' => $this->announcement_content,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate ?? null
        ];
    }

}
