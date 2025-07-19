<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormField;
use App\Models\FormSubmission;
use Illuminate\Http\Request;

class UserFormController extends Controller
{
    // Display all available forms to public
    public function index()
    {
        $forms = Form::withCount('fields')->whereNull('deleted_at')->get();
        return view('user.forms.index', compact('forms'));
    }

    // Display a specific form
    public function show($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('user.forms.show', compact('form'));
    }

    // Handle form submission
    public function submit(Request $request, $formId)
    {
        $form = Form::with('fields')->findOrFail($formId);

        $submission = new FormSubmission();
        $submission->form_id = $form->id;

        // Build submitted data array
        $data = [];

        foreach ($form->fields as $field) {
            $inputName = 'field_' . $field->id;
            $value = $request->input($inputName);

            if ($value === null) {
                continue;
            }

            $data[$field->label] = $value;
        }

        // Assign the full array at once
        $submission->submitted_data = $data;

        $submission->save();

        return redirect()->route('user.forms.index')->with('success', 'Form submitted successfully!');
    }
}
