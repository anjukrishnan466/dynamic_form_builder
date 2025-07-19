<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendFormCreatedNotification;
use App\Models\FormSubmission;

class FormController extends Controller
{

    /**
     * Display a listing of all forms with their fields.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $forms = Form::with('fields')->latest()->get();
        return view('forms.index', compact('forms'));
    }
    /**
     * Show the form creation page.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created form and its fields in the database.
     * Validates input, creates the form, saves each field, and dispatches notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
    /**
     * Show the form edit page for a specific form.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('forms.edit', compact('form'));
    }
    /**
     * Update an existing form and its fields.
     * Validates input, updates the form, deletes old fields, and saves new fields.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

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

    /**
     * Soft delete a form by its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $form = Form::findOrFail($id);
        $form->delete(); // soft delete

        return redirect()->route('form.index')->with('success', 'Form soft deleted successfully!');
    }

    /**
     * Display all submissions for a specific form.
     * Retrieves the form and its fields, fetches all related submissions,
     * and passes them to the submissions view.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewSubmissions($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        $submissions = FormSubmission::where('form_id', $id)->latest()->get();

        return view('forms.submissions', compact('form', 'submissions'));
    }
}
