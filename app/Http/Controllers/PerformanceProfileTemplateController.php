<?php

namespace App\Http\Controllers;

use App\Models\PerformanceProfileTemplate;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\DeadlockException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use PDOException;

class PerformanceProfileTemplateController extends Controller
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
    public function index(): View
    {
        return view('performanceProfileTemplate.index', 
        ['performanceProfiles' => PerformanceProfileTemplate::with('user')->latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('performanceProfileTemplate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
                 Rule::unique('performance_profile_templates')->where(function ($query) use ($request) {
                    return $query->where('user_id', $request->user()->id);
                }),
            ],
            'description' => 'required|string|max:255',
            'default_value' => [
                'required',
            Rule::in(['0', '1']),
            ]
        ]);

        $validated['default_value'] = ($validated['default_value'] === '1');


        try {
            $request->user()->performanceProfileTemplate()->create($validated);
            return redirect(route('performance-profile-templates.index'));
        }catch(ModelNotFoundException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'Performance Profile Template cannot be found');
        } catch(QueryException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'An error occurred while updating the record. Please try again later.');
        } catch(MassAssignmentException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'Unauthorized fields were provided for updating. Please check your request');
        } catch(ValidationException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'The data provided for updating does not pass validation. Please correct the errors and try again.');
        }catch(DeadlockException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'A deadlock occurred while updating the record. Please try again later.');
        }catch(PDOException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'A database error occurred while updating the record. Please try again later.');
        }catch(Exception $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'An unexpected error occurred while updating the record. Please contact support for assistance.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PerformanceProfileTemplate $performanceProfileTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceProfileTemplate $performanceProfileTemplate): View
    {
        return view('performanceProfileTemplate.edit', [
            'performanceProfileTemplate' => $performanceProfileTemplate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceProfileTemplate $performanceProfileTemplate): RedirectResponse
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'description' => 'required|string|max:255',
            'default_value' => [
                'required',
            Rule::in(['0', '1']),
            ]
        ]);
        try {
            $performanceProfileTemplate->update($validated);
            return redirect(route('performance-profile-templates.index'));
        } catch(ModelNotFoundException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'Performance Profile Template cannot be found');
        } catch(QueryException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'An error occurred while updating the record. Please try again later.');
        } catch(MassAssignmentException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'Unauthorized fields were provided for updating. Please check your request');
        } catch(ValidationException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'The data provided for updating does not pass validation. Please correct the errors and try again.');
        }catch(DeadlockException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'A deadlock occurred while updating the record. Please try again later.');
        }catch(PDOException $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'A database error occurred while updating the record. Please try again later.');
        }catch(Exception $e ){
            return redirect()->route('performance-profile-templates.index')->with('error', 'An unexpected error occurred while updating the record. Please contact support for assistance.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceProfileTemplate $performanceProfileTemplate): RedirectResponse
    {

        try {
            $performanceProfileTemplate->delete();

            return redirect(route('performance-profile-templates.index'));
        } catch (QueryException $e) {
            return redirect()->route('performance-profile-templates.index')->with('error', 'Cannot delete the template as it is being used:');
        }
        
    }
}
