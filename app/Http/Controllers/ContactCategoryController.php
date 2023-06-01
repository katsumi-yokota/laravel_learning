<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactCategory;

class ContactCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // TODO: all()以外を使えないか検討
        $contactCategories = ContactCategory::all(); 
        return view('contact-category.index', ['contactCategories' => $contactCategories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact-category.create'); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $contactCategories = new ContactCategory();
        $contactCategories->contact_category = $request->category;
        $contactCategories->save();
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
