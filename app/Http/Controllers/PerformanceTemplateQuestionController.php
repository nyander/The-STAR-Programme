<?php

namespace App\Http\Controllers;

use App\Models\PerformanceCategory;
use App\Models\PerformanceProfileTemplate;
use App\Models\PerformanceTemplateQuestion;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PDOException;

class PerformanceTemplateQuestionController extends Controller
{
    function __construct(){
        $this->middleware('permission:performance-profile-template-list|performance-profile-template-create|performance-profile-template-edit|performance-profile-template-delete', ['only' => ['index','show']]);
        $this->middleware('permission:performance-profile-template-create', ['only' => ['create','store']]);
        $this->middleware('permission:performance-profile-template-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:performance-profile-template-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PerformanceProfileTemplate $performanceProfileTemplate): View
    {
        $performanceProfileQuestions = $performanceProfileTemplate->questions()->orderByRaw('ISNULL(`order`), `order`')->get();
        $categories = PerformanceCategory::all();
        return view('performance-template-questions.index', 
        ['performanceProfileQuestions' => $performanceProfileQuestions, 
        'performanceProfileTemplate' => $performanceProfileTemplate, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PerformanceProfileTemplate $performanceProfileTemplate)
    {
        $validatedData = $request->validate([
            'title' => ['required', Rule::unique('performance_template_questions')->where('performance_template_id', $performanceProfileTemplate->id)],
            'text' => 'required|string',
            'type' => 'required|in:text,textarea,select,radio',
            'options' => 'nullable|string',
            'required' => 'required|boolean',
            'categorytype' => 'required',
            'order' => [
                'nullable',
                'integer',
                Rule::unique('performance_template_questions')->where('performance_template_id', $performanceProfileTemplate->id),
            ],
        ]);

        

        $validatedData['title'] = str_replace(' ', '', $validatedData['title']);

        // Process options field
        if ($validatedData['type'] === 'select' || $validatedData['type'] === 'radio') {
            // If type is select or radio, validate and format the options
            $options = $request->input('options');
            if (empty($options)) {
                // Options field is required for select or radio type
                return redirect()->back()->withErrors(['options' => 'The options field is required.']);
            }

            // Split options by comma and trim whitespace
            $options = array_map('trim', explode(',', $options));

            // Remove empty options
            $options = array_filter($options);

            // Convert options to JSON
            $validatedData['options'] = json_encode($options);
        } else {
            // For other types, set options as null
            $validatedData['options'] = null;
        }

        $question = $performanceProfileTemplate->questions()->create($validatedData);


        return redirect()->route('performance-profile-templates.questions.index', $performanceProfileTemplate)->with('success', 'Question created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(PerformanceTemplateQuestion $performanceProfileQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceProfileTemplate $performanceProfileTemplate, PerformanceTemplateQuestion $question)
    {
        return view('performance-template-questions.edit', compact('performanceProfileTemplate', 'question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceProfileTemplate $performanceProfileTemplate, PerformanceTemplateQuestion $question)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'text' => 'required|string',
            'type' => 'required|in:text,textarea,select,radio',
            'options' => 'nullable|string',
            'required' => 'required|boolean',
            'order' => 'nullable|integer',
        ]);

        // Process options field
        if ($validatedData['options']) {
            $decodedOptions = explode(',', $validatedData['options']);
            $validatedData['options'] = json_encode(array_map('trim', $decodedOptions));
        }

        $question->update($validatedData);

        return redirect()->route('performance-profile-templates.questions.index', $performanceProfileTemplate)->with('success', 'Question updated successfully.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceProfileTemplate $performanceProfileTemplate, PerformanceTemplateQuestion $question)
    {
        try {
            $performanceProfileTemplate->delete();
            return redirect(route('performance-profile-templates.index'))->with('success', 'Template deleted successfully.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('performance-profile-templates.index')->with('error', 'Template not found.');
        } catch (PDOException $e) {
            return redirect()->route('performance-profile-templates.index')->with('error', 'Cannot delete the template as it is being used.');
        }
    }
}
