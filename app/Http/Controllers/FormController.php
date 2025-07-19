<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;

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
            'types.*' => 'required|string|in:text,number,select',
            'options' => 'array',
        ]);

        // Save the form
        $form = Form::create([
            'title' => $request->form_name,
        ]);

        // Loop and save each form field
        foreach ($request->labels as $index => $label) {
            FormField::create([
                'form_id' => $form->id,
                'label' => $label,
                'type' => $request->types[$index],
                'options' => $request->types[$index] === 'select' ? $request->options[$index] : null,
            ]);
        }

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
            'types.*' => 'required|string|in:text,number,select',
            'options' => 'array',
        ]);

        $form = Form::findOrFail($id);
        $form->update(['title' => $request->form_name]);

        // Delete old fields before re-inserting updated ones
        $form->fields()->delete();

        foreach ($request->labels as $index => $label) {
            FormField::create([
                'form_id' => $form->id,
                'label' => $label,
                'type' => $request->types[$index],
                'options' => $request->types[$index] === 'select'
    ? json_encode(array_map('trim', explode(',', $request->options[$index] ?? '')))
    : null,

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
