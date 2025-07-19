<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;

class FormFieldController extends Controller
{
    public function create($formId)
    {
        $form = Form::findOrFail($formId);
        return view('fields.create', compact('form'));
    }

    public function store(Request $request, $formId)
    {
        $form = Form::findOrFail($formId);

        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,email,select,textarea,checkbox,radio',
            'options' => 'nullable|string', // for select, checkbox, radio (comma separated)
        ]);

        FormField::create([
            'form_id' => $form->id,
            'label' => $request->label,
            'type' => $request->type,
            'options' => $request->options, // Store options as comma-separated values
        ]);

        return redirect()->route('form.list')->with('success', 'Field added to form.');
    }
}
