<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Step as StepResource;

class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'step_id' => $this->step_id,
            'parent_question_id' => $this->parent_question_id,
            'title' => $this->title,
            'short_name' => $this->short_name,
            'slug' => $this->slug,
            'description' => $this->description,
            'status' => $this->status,
            'image' => $this->image,
            'sort' => $this->sort,
            'answer_properties' => $this->answer_properties,
            'available_if_parent_answer_operator' => $this->available_if_parent_answer_operator,
            'available_if_parent_answer_value' => $this->available_if_parent_answer_value,
            'is_required_to_receive_diet' => $this->is_required_to_receive_diet,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'step' => new StepResource($this->whenLoaded('step')),
            'all_steps' => $this->all_steps,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success'
        ];
    }
}
