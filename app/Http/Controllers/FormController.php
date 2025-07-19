<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendFormCreatedNotification;

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::with('fields')->latest()->get();
        return view('forms.index', compact('forms'));
    }

    public function create()
    {
        return view('forms.create');
    }


   public function store(Request $request)
{
    $request->validate([
        'form_name' => 'required|string|max:255',
        'labels' => 'required|array',
        'types' => 'required|array',
        'labels.*' => 'required|string',
        'types.*' => 'required|string|in:text,number,email,textarea,select,checkbox,radio',
        'options' => 'array',
    ]);

    $form = Form::create([
        'title' => $request->form_name,
    ]);

    foreach ($request->labels as $index => $label) {
        $type = $request->types[$index];

        $options = in_array($type, ['select', 'checkbox', 'radio']) && !empty($request->options[$index])
            ? json_encode(array_map('trim', explode(',', $request->options[$index])))
            : null;

        FormField::create([
            'form_id' => $form->id,
            'label' => $label,
            'type' => $type,
            'options' => $options,
        ]);
    }

    SendFormCreatedNotification::dispatch($form, Auth::user()->email);

    return redirect()->route('form.index')->with('success', 'Form created successfully!');
}

    public function edit($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('forms.edit', compact('form'));
    }
   public function update(Request $request, $id)
{
    $request->validate([
        'form_name' => 'required|string|max:255',
        'labels' => 'required|array',
        'types' => 'required|array',
        'labels.*' => 'required|string',
        'types.*' => 'required|string|in:text,number,email,textarea,select,checkbox,radio',
        'options' => 'array',
    ]);

    $form = Form::findOrFail($id);
    $form->update(['title' => $request->form_name]);

    $form->fields()->delete();

    foreach ($request->labels as $index => $label) {
        $type = $request->types[$index];
        $options = in_array($type, ['select', 'checkbox', 'radio']) && isset($request->options[$index])
            ? json_encode(array_map('trim', explode(',', $request->options[$index])))
            : null;

        FormField::create([
            'form_id' => $form->id,
            'label' => $label,
            'type' => $type,
            'options' => $options,
        ]);
    }

    return redirect()->route('form.index')->with('success', 'Form updated successfully!');
}


    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete(); // soft delete

        return redirect()->route('form.index')->with('success', 'Form soft deleted successfully!');
    }
}
