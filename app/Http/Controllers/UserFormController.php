<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class UserFormController extends Controller
{
    /**
     * Show all available forms to the user.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $forms = Form::withCount('fields')->whereNull('deleted_at')->get();
        return view('user.forms.index', compact('forms'));
    }

    /**
     * Show a specific form and its fields to the user.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('user.forms.show', compact('form'));
    }

    /**
     * Handle user form submission.
     * Validates input based on field types, saves submission data.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $formId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(Request $request, $formId)
    {
        $form = Form::with('fields')->findOrFail($formId);

        $validationRules = [];
        $attributeNames = [];

        foreach ($form->fields as $field) {
            $inputName = 'field_' . $field->id;

            // Set validation rules
            switch ($field->type) {
                case 'email':
                    $validationRules[$inputName] = 'required|email';
                    break;
                case 'number':
                    $validationRules[$inputName] = 'required|numeric';
                    break;
                case 'checkbox':
                    $validationRules[$inputName] = 'required|array';
                    break;
                case 'radio':
                case 'select':
                case 'text':
                case 'textarea':
                    $validationRules[$inputName] = 'required|string';
                    break;
                default:
                    $validationRules[$inputName] = 'required';
            }

            // Set user-friendly name for error messages
            $attributeNames[$inputName] = $field->label;
        }

        // Validate with custom attribute names
        $validatedData = $request->validate(
            $validationRules,
            [
                'required' => 'The :attribute field is required.',
                'email' => 'The :attribute must be a valid email address.',
                'numeric' => 'The :attribute must be a number.',
            ],
            $attributeNames //  Custom field names go here
        );

        // Save submission
        $submission = new FormSubmission();
        $submission->form_id = $form->id;

        $submittedData = [];

        foreach ($form->fields as $field) {
            $inputName = 'field_' . $field->id;
            $value = $field->type === 'checkbox'
                ? $request->input($inputName, [])
                : $request->input($inputName);

            $submittedData[$field->label] = $value;
        }

        $submission->submitted_data = $submittedData;
        $submission->save();

        return redirect()->route('user.forms.index')->with('success', ' Form submitted successfully!');
    }
}
